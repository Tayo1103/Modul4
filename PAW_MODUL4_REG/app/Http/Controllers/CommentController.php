<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Comment;

class CommentController extends Controller
{
    public function store(Request $request, Article $article)
    {
        $request->validate([
            'comment' => 'required|string|max:1000',
        ]);

        $comment = new Comment([
            'comment' => $request->comment,
            'user_id' => auth()->id(),
        ]);
        
        $article->comments()->save($comment);           

        session()->flash('success', 'Comment berhasil ditambahkan!');
        return redirect()->route('articles.show', $article->id);
    }

    public function destroy(Comment $comment) {
        $articleId = $comment->article_id;
        $comment->delete();
    
        session()->flash('success', 'Comment berhasil dihapus!');
        return redirect()->route('articles.show', ['article' => $articleId]);
    }
}
