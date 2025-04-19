<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class DownloadController extends Controller
{
    public function download(Product $product)
    {
        if (!auth()->check() || !auth()->user()->hasPurchased($product)) {
            abort(403);
        }

        return Storage::download($product->file_path);
    }
}
