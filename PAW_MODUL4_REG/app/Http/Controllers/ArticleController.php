<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Article;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ArticleController extends Controller
{
    public function index() {
        $articles = Article::latest()->get();
        return view('admin.index', compact('articles'));
    }

    public function create() {
        return view('admin.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'content' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $articleData = $request->only('title', 'content', 'image');

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('articles', 'public');
            $articleData['image'] = $imagePath;
        }

        auth()->user()->articles()->create($articleData);

        session()->flash('success', 'Artikel berhasil dibuat!');
        return redirect()->route('admin.index');
    }

    public function edit(Article $article) {
        return view('admin.edit', compact('article'));
    }

    public function update(Request $request, Article $article)
    {
        $request->validate([
            'title' => 'required',
            'content' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $articleData = $request->only('title', 'content', 'image');

        if ($request->hasFile('image')) {
            if ($article->image) {
                Storage::delete('public/' . $article->image);
            }

            $imagePath = $request->file('image')->store('articles', 'public');
            $articleData['image'] = $imagePath;
        }

        $article->update($articleData);

        session()->flash('success', 'Artikel berhasil diperbarui!');

        return redirect()->route('admin.index');
    }

    public function destroy(Article $article) {
        $article->delete();
        session()->flash('success', 'Artikel berhasil dihapus!');
        return redirect()->route('admin.index');
    }

    public function show($id)
    {
        $article = Article::with('comments.user')->findOrFail($id);
        return view('articles.show', compact('article'));
    }
}
