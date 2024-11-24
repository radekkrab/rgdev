<?php

namespace App\Http\Controllers;

use App\Filament\Resources\ArticleResource\Pages\ListArticles;
use App\Models\Article;
use App\Models\Topic;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TopicController extends Controller
{
    public function index() {
        $topics = Topic::with('articles')->get();
        return Inertia::render('Topics', ['topics' => $topics]);
    }

    public function show(Topic $topic) {
        $articles = Article::where('topic_id', $topic->id)->get();
        return Inertia::render('Topic', ['articles' => $articles, 'topic' => $topic]);
    }
}
