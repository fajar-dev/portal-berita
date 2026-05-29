<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NewsController;

// NusaKini News Portal Routes
Route::get('/', [NewsController::class, 'home'])->name('news.home');
Route::get('/category/{slug}', [NewsController::class, 'category'])->name('news.category');
Route::get('/article/{slug}', [NewsController::class, 'detail'])->name('news.detail');
Route::get('/article/{slug}/comments-list', [NewsController::class, 'getComments'])->name('news.comments.list');
Route::get('/bookmarks', [NewsController::class, 'bookmarks'])->name('news.bookmarks');
Route::get('/search', [NewsController::class, 'search'])->name('news.search');
Route::get('/api/search/autocomplete', [NewsController::class, 'autocomplete'])->name('news.search.autocomplete');
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

// Custom Pages Route
Route::get('/page/{slug}', [NewsController::class, 'showPage'])->name('news.page');

// Dynamic Sitemap.xml & RSS Feed Routes
Route::get('/sitemap.xml', [NewsController::class, 'sitemap'])->name('news.sitemap');
Route::get('/feed', [NewsController::class, 'feed'])->name('news.feed');

// --- Admin Dashboard Routes ---
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [\App\Http\Controllers\Admin\AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [\App\Http\Controllers\Admin\AuthController::class, 'login']);
    Route::post('/logout', [\App\Http\Controllers\Admin\AuthController::class, 'logout'])->name('logout');

    Route::middleware('auth')->group(function () {
        // ── Shared: admin & author ──
        Route::get('/', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
        Route::get('/analytics', [\App\Http\Controllers\Admin\AnalyticsController::class, 'index'])->name('analytics');
        
        // WYSIWYG Upload Route
        Route::post('/upload-image', [\App\Http\Controllers\Admin\UploadController::class, 'image'])->name('upload.image');

        Route::resource('articles', \App\Http\Controllers\Admin\ArticleController::class);
        Route::resource('categories', \App\Http\Controllers\Admin\CategoryController::class);
        Route::resource('tags', \App\Http\Controllers\Admin\TagController::class);
        Route::resource('opinions', \App\Http\Controllers\Admin\OpinionController::class);
        Route::resource('videos', \App\Http\Controllers\Admin\VideoController::class);
        Route::resource('infographics', \App\Http\Controllers\Admin\InfographicController::class);

        // Comments
        Route::get('comments', [\App\Http\Controllers\Admin\CommentController::class, 'index'])->name('comments.index');
        Route::post('comments/{comment}/reply', [\App\Http\Controllers\Admin\CommentController::class, 'reply'])->name('comments.reply');
        Route::delete('comments/{comment}', [\App\Http\Controllers\Admin\CommentController::class, 'destroy'])->name('comments.destroy');

        // Profile (semua user bisa akses profil sendiri)
        Route::get('profile', [\App\Http\Controllers\Admin\ProfileController::class, 'edit'])->name('profile.edit');
        Route::put('profile', [\App\Http\Controllers\Admin\ProfileController::class, 'update'])->name('profile.update');
        Route::put('profile/password', [\App\Http\Controllers\Admin\ProfileController::class, 'updatePassword'])->name('profile.password');
        Route::delete('profile/avatar', [\App\Http\Controllers\Admin\ProfileController::class, 'removeAvatar'])->name('profile.remove-avatar');

        // ── Admin only ──
        Route::middleware('admin.only')->group(function () {
            Route::resource('pages', \App\Http\Controllers\Admin\PageController::class);
            Route::resource('menus', \App\Http\Controllers\Admin\MenuController::class);
            Route::resource('polls', \App\Http\Controllers\Admin\PollController::class);
            Route::resource('users', \App\Http\Controllers\Admin\UserController::class);
            Route::resource('ads', \App\Http\Controllers\Admin\AdvertisementController::class)->only(['index', 'edit', 'update']);

            // Contacts
            Route::get('contacts', [\App\Http\Controllers\Admin\ContactController::class, 'index'])->name('contacts.index');
            Route::get('contacts/{contact}', [\App\Http\Controllers\Admin\ContactController::class, 'show'])->name('contacts.show');
            Route::delete('contacts/{contact}', [\App\Http\Controllers\Admin\ContactController::class, 'destroy'])->name('contacts.destroy');

            // Subscribers
            Route::get('subscribers', [\App\Http\Controllers\Admin\SubscriberController::class, 'index'])->name('subscribers.index');
            Route::delete('subscribers/{subscriber}', [\App\Http\Controllers\Admin\SubscriberController::class, 'destroy'])->name('subscribers.destroy');

            // Settings
            Route::get('settings', [\App\Http\Controllers\Admin\SettingController::class, 'index'])->name('settings.index');
            Route::put('settings', [\App\Http\Controllers\Admin\SettingController::class, 'update'])->name('settings.update');
        });
    });
});
