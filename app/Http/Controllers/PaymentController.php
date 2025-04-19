<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use YooKassa\Client;
use App\Models\Order;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class PaymentController extends Controller
{
    public function createPayment(Request $request)
    {
        try {
            $request->validate([
                'product_id' => 'required|exists:products,id',
                'amount' => 'required|numeric|min:1'
            ]);

            $order = Order::create([
                'user_id' => auth()->id(),
                'product_id' => $request->product_id,
                'amount' => $request->amount,
                'status' => 'pending',
            ]);

            $client = new Client();
            $client->setAuth(config('services.yukassa.shop_id'), config('services.yukassa.secret_key'));

            $payment = $client->createPayment(
                [
                    'amount' => [
                        'value' => $order->amount,
                        'currency' => 'RUB',
                    ],
                    'confirmation' => [
                        'type' => 'redirect',
                        'return_url' => route('payment.callback'),
                    ],
                    'metadata' => [
                        'order_id' => $order->id,
                    ],
                    'description' => 'Оплата PDF: ' . $order->product->title,
                ],
                uniqid('', true)
            );

            $order->update([
                'payment_id' => $payment->getId(),
                'payment_url' => $payment->getConfirmation()->getConfirmationUrl()
            ]);

            return response()->json([
                'confirmation_url' => $payment->getConfirmation()->getConfirmationUrl(),
            ]);
        } catch (\Exception $e) {
            Log::error('Ошибка создания платежа: ' . $e->getMessage());
            return response()->json(['error' => 'Payment creation failed'], 500);
        }

    }

    public function callback(Request $request)
    {
        // 1. Проверка наличия event
        if (!$request->has('event')) {
            Log::error('ЮКасса callback: отсутствует поле event', $request->all());
            return response()->json(['error' => 'Event field missing'], 400);
        }

        // 2. Валидация подписи (если используется)
        $webhookSecret = config('services.yukassa.webhook_secret');
        if ($webhookSecret && !$this->validateWebhook($request, $webhookSecret)) {
            Log::error('ЮКасса callback: неверная подпись уведомления');
            return response()->json(['error' => 'Invalid signature'], 403);
        }

        // 3. Проверка наличия payment_id
        if (!$request->has('object') || !isset($request->object['id'])) {
            Log::error('ЮКасса callback: отсутствует payment_id в запросе', $request->all());
            return response()->json(['error' => 'Invalid request'], 400);
        }

        $paymentId = $request->object['id'];
        $event = $request->input('event');

        try {
            $client = new Client();
            $client->setAuth(config('services.yukassa.shop_id'), config('services.yukassa.secret_key'));

            // Для всех событий кроме succeeded получаем актуальный статус
            if ($event !== 'payment.succeeded') {
                $payment = $client->getPaymentInfo($paymentId);
            }

            $order = Order::where('payment_id', $paymentId)->firstOrFail();

            switch ($event) {
                case 'payment.succeeded':
                    if ($order->status !== 'completed') {
                        $order->update([
                            'status' => 'completed',
                            'paid_at' => now(),
                        ]);
                        Log::info("Платеж {$paymentId} успешно обработан");
                    }
                    break;

                case 'payment.canceled':
                    $order->update(['status' => 'canceled']);
                    Log::info("Платеж {$paymentId} отменен");
                    break;

                case 'payment.waiting_for_capture':
                    // Для цифровых товаров сразу подтверждаем
                    $client->capturePayment([
                        'amount' => $request->object['amount']
                    ], $paymentId, uniqid('', true));
                    Log::info("Платеж {$paymentId} подтвержден");
                    break;

                default:
                    Log::warning("ЮКасса callback: неизвестное событие {$event}");
                    return response()->json(['error' => 'Unknown event'], 400);
            }

            return response()->json(['status' => 'success']);

        } catch (ModelNotFoundException $e) {
            Log::error("Заказ с payment_id {$paymentId} не найден");
            return response()->json(['error' => 'Order not found'], 404);
        } catch (\Exception $e) {
            Log::error("Ошибка обработки платежа: " . $e->getMessage());
            return response()->json(['error' => 'Server error'], 500);
        }
    }

    private function validateWebhook(Request $request, string $secret): bool
    {
        $signature = $request->header('Content-Signature');
        if (empty($signature)) {
            return false;
        }

        $payload = $request->getContent();
        $expectedSign = base64_encode(hash_hmac('sha256', $payload, $secret, true));

        return hash_equals($expectedSign, base64_decode($signature));
    }

    public function checkPaymentStatus(Order $order)
    {
        $client = new Client();
        $client->setAuth(config('services.yukassa.shop_id'), config('services.yukassa.secret_key'));

        try {
            $payment = $client->getPaymentInfo($order->payment_id);

            if ($payment->getStatus() === 'succeeded' && $order->status !== 'completed') {
                $order->update(['status' => 'completed']);
                return true;
            }

            return false;
        } catch (\Exception $e) {
            Log::error("Ошибка проверки статуса платежа: " . $e->getMessage());
            return false;
        }
    }
}
