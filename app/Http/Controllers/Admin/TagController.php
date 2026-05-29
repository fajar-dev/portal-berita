<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TagController extends Controller
{
    public function index(Request $request)
    {
        $query = Tag::withCount('articles');
        if ($request->filled('q')) {
            $query->where('name', 'like', "%{$request->q}%");
        }
        $tags = $query->orderBy('name')->paginate(10)->withQueryString();
        return view('admin.tags.index', compact('tags'));
    }

    public function create()
    {
        return view('admin.tags.form');
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|max:100|unique:tags,name']);
        Tag::create(['name' => $request->name, 'slug' => Str::slug($request->name)]);
        return redirect()->route('admin.tags.index')->with('success', 'Tag berhasil ditambahkan.');
    }

    public function edit(Tag $tag)
    {
        return view('admin.tags.form', compact('tag'));
    }

    public function update(Request $request, Tag $tag)
    {
        $request->validate(['name' => 'required|max:100|unique:tags,name,' . $tag->id]);
        $tag->update(['name' => $request->name, 'slug' => Str::slug($request->name)]);
        return redirect()->route('admin.tags.index')->with('success', 'Tag berhasil diperbarui.');
    }

    public function destroy(Tag $tag)
    {
        $tag->delete();
        return redirect()->route('admin.tags.index')->with('success', 'Tag berhasil dihapus.');
    }
}
