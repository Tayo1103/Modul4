<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\ArticleController as AdminArticleController;

Route::get('/', [HomeController::class, 'index'])->name('home');

Auth::routes();

Route::middleware(['auth'])->group(function () {
    Route::get('admin', [AdminArticleController::class, 'index'])->name('admin.index');
    Route::get('admin/create', [AdminArticleController::class, 'create'])->name('admin.create');
    Route::post('admin', [AdminArticleController::class, 'store'])->name('admin.store');
    Route::get('admin/{article}/edit', [AdminArticleController::class, 'edit'])->name('admin.edit');
    Route::put('admin/{article}', [AdminArticleController::class, 'update'])->name('admin.update');
    Route::delete('admin/{article}', [AdminArticleController::class, 'destroy'])->name('admin.destroy');
    Route::post('/articles/{article}/comments', [CommentController::class, 'store']);
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comment.destroy');
});

Route::get('/articles/{article}', [ArticleController::class, 'show'])->name('articles.show');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
