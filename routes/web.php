<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NewsController;

// NusaKini News Portal Routes
Route::get('/', [NewsController::class, 'home'])->name('news.home');
Route::get('/category/{slug}', [NewsController::class, 'category'])->name('news.category');
Route::get('/article/{slug}', [NewsController::class, 'detail'])->name('news.detail');
Route::get('/bookmarks', [NewsController::class, 'bookmarks'])->name('news.bookmarks');
Route::get('/search', [NewsController::class, 'search'])->name('news.search');
Route::get('/author/{username}', [NewsController::class, 'author'])->name('news.author');
Route::get('/contact', [NewsController::class, 'contact'])->name('news.contact');

// Dynamic Form POST Actions
Route::post('/newsletter/subscribe', [NewsController::class, 'subscribe'])->name('news.subscribe');
Route::post('/contact/send', [NewsController::class, 'sendMessage'])->name('news.contact.send');
Route::post('/article/{slug}/comment', [NewsController::class, 'addComment'])->name('news.comment');

// Polling & Analytics Routes
Route::post('/poll/vote', [NewsController::class, 'votePoll'])->name('news.poll.vote');
Route::get('/poll/{pollId}/results', [NewsController::class, 'getPollResults'])->name('news.poll.results');

// Dynamic Tags & Reactions Routes
Route::get('/tag/{slug}', [NewsController::class, 'tag'])->name('news.tag');
Route::post('/article/{slug}/react', [NewsController::class, 'react'])->name('news.react');
