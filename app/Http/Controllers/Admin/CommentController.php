<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function index(Request $request)
    {
        $query = Comment::with(['article', 'user', 'replies.user', 'replies' => function ($q) {
            $q->orderBy('created_at', 'asc');
        }])->whereNull('parent_id');
        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($qb) use ($q) {
                $qb->where('name', 'like', "%{$q}%")
                   ->orWhere('email', 'like', "%{$q}%")
                   ->orWhere('body', 'like', "%{$q}%");
            });
        }
        $comments = $query->orderBy('created_at', 'desc')->paginate(10)->withQueryString();
        return view('admin.comments.index', compact('comments'));
    }

    public function reply(Request $request, Comment $comment)
    {
        $request->validate(['body' => 'required']);
        Comment::create([
            'article_id' => $comment->article_id,
            'parent_id' => $comment->id,
            'user_id' => auth()->id(),
            'name' => auth()->user()->name ?? 'Admin ' . \App\Models\Setting::get('site_name', 'NusaKini'),
            'email' => auth()->user()->email ?? \App\Models\Setting::get('office_email', 'admin@nusakini.com'),
            'body' => $request->body,
        ]);
        return redirect()->route('admin.comments.index')->with('success', 'Balasan berhasil dikirim.');
    }

    public function destroy(Comment $comment)
    {
        $comment->replies()->delete();
        $comment->delete();
        return redirect()->route('admin.comments.index')->with('success', 'Komentar berhasil dihapus.');
    }
}
