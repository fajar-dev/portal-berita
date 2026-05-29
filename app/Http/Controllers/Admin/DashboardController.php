<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\User;
use App\Models\Comment;
use App\Models\Subscriber;
use App\Models\Contact;
use App\Models\ArticleView;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'articles_count' => Article::count(),
            'published_count' => Article::where('status', \App\Enums\ContentStatus::PUBLISHED)->count(),
            'users_count' => User::count(),
            'comments_count' => Comment::count(),
        ];

        $recentArticles = Article::with(['user', 'category'])->orderBy('created_at', 'desc')->take(8)->get();

        return view('admin.dashboard', compact('stats', 'recentArticles'));
    }
}
