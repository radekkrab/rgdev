<?php

namespace App\Http\Controllers;

use App\Http\Requests\MailCreateRequest;
use App\Mail\GuestMail;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    public function send(MailCreateRequest $request)  
    {
        $data = $request->validated();

        Mail::to('radxxx7@mail.ru')->send(new GuestMail($data));
        return to_route('welcome');
    }
}
