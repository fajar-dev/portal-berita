<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Opinion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class OpinionController extends Controller
{
    public function index(Request $request)
    {
        $query = Opinion::query();
        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($qb) use ($q) {
                $qb->where('title', 'like', "%{$q}%")
                   ->orWhere('author', 'like', "%{$q}%");
            });
        }
        $opinions = $query->orderBy('created_at', 'desc')->paginate(10)->withQueryString();
        return view('admin.opinions.index', compact('opinions'));
    }

    public function create()
    {
        return view('admin.opinions.form');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'excerpt' => 'required',
            'author' => 'required|max:255',
            'role' => 'required|max:255',
            'author_avatar' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:1024',
            'status' => 'required|in:published,draft,archived',
        ]);

        $avatarPath = '';
        if ($request->hasFile('author_avatar')) {
            $avatarPath = 'storage/' . $request->file('author_avatar')->store('avatars', 'public');
        }

        Opinion::create([
            'title' => $request->title,
            'excerpt' => $request->excerpt,
            'author' => $request->author,
            'author_avatar' => $avatarPath,
            'role' => $request->role,
            'published_date' => $request->published_date ?? now()->format('Y-m-d'),
            'status' => $request->status,
        ]);

        return redirect()->route('admin.opinions.index')->with('success', 'Opini berhasil ditambahkan.');
    }

    public function edit(Opinion $opinion)
    {
        return view('admin.opinions.form', compact('opinion'));
    }

    public function update(Request $request, Opinion $opinion)
    {
        $request->validate([
            'title' => 'required|max:255',
            'excerpt' => 'required',
            'author' => 'required|max:255',
            'role' => 'required|max:255',
            'author_avatar' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:1024',
            'status' => 'required|in:published,draft,archived',
        ]);

        $data = [
            'title' => $request->title,
            'excerpt' => $request->excerpt,
            'author' => $request->author,
            'role' => $request->role,
            'published_date' => $request->published_date ?? $opinion->published_date,
            'status' => $request->status,
        ];

        if ($request->hasFile('author_avatar')) {
            // Delete old avatar
            $oldPath = str_replace('storage/', '', $opinion->author_avatar);
            if ($oldPath && Storage::disk('public')->exists($oldPath)) {
                Storage::disk('public')->delete($oldPath);
            }
            $data['author_avatar'] = 'storage/' . $request->file('author_avatar')->store('avatars', 'public');
        }

        $opinion->update($data);

        return redirect()->route('admin.opinions.index')->with('success', 'Opini berhasil diperbarui.');
    }

    public function destroy(Opinion $opinion)
    {
        $oldPath = str_replace('storage/', '', $opinion->author_avatar);
        if ($oldPath && Storage::disk('public')->exists($oldPath)) {
            Storage::disk('public')->delete($oldPath);
        }
        $opinion->delete();
        return redirect()->route('admin.opinions.index')->with('success', 'Opini berhasil dihapus.');
    }
}
