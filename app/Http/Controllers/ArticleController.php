<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Topic;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ArticleController extends Controller
{
    public function show(Article $article) {
        return Inertia::render('Articles/Show', ['article' => $article]);
    }
}
