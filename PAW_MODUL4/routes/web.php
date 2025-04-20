<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Admin\ArticleController as AdminArticleController;

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/articles/{id}', [ArticleController::class, 'show'])->name('articles.show');

Route::middleware(['auth', 'role:admin,mahasiswa'])->group(function () {
    Route::post('/articles/{article}/comments', [CommentController::class, 'store']);
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comment.destroy');
});

Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/articles', [AdminArticleController::class, 'index'])->name('admin.index');
    Route::get('/articles/create', [AdminArticleController::class, 'create'])->name('admin.create');
    Route::post('/articles', [AdminArticleController::class, 'store'])->name('admin.store');
    Route::get('/articles/{id}/edit', [AdminArticleController::class, 'edit'])->name('admin.edit');
    Route::put('/articles/{id}', [AdminArticleController::class, 'update'])->name('admin.update');
    Route::delete('/articles/{id}', [AdminArticleController::class, 'destroy'])->name('admin.destroy');
});
