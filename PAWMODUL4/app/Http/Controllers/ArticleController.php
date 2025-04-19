<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;

class ArticleController extends Controller
{
    public function show($id)
    {
        $article = Article::with('comments.user')->findOrFail($id);
        return view('articles.show', compact('article'));
    }
}
