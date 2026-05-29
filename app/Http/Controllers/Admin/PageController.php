<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PageController extends Controller
{
    public function index(Request $request)
    {
        $query = Page::query();
        if ($request->filled('q')) {
            $query->where('title', 'like', "%{$request->q}%");
        }
        $pages = $query->orderBy('created_at', 'desc')->paginate(10)->withQueryString();
        return view('admin.pages.index', compact('pages'));
    }

    public function create()
    {
        return view('admin.pages.form');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'slug' => 'required|max:255|unique:pages',
            'content' => 'required'
        ]);
        Page::create([
            'title' => $request->title,
            'slug' => Str::slug($request->slug),
            'content' => $request->input('content'),
            'css' => $request->css,
            'builder_data' => $request->builder_data,
            'is_active' => $request->boolean('is_active', true),
        ]);
        return redirect()->route('admin.pages.index')->with('success', 'Halaman berhasil dibuat.');
    }

    public function edit(Page $page)
    {
        return view('admin.pages.form', compact('page'));
    }

    public function update(Request $request, Page $page)
    {
        $request->validate([
            'title' => 'required|max:255',
            'slug' => 'required|max:255|unique:pages,slug,' . $page->id,
            'content' => 'required'
        ]);
        $page->update([
            'title' => $request->title,
            'slug' => Str::slug($request->slug),
            'content' => $request->input('content'),
            'css' => $request->css,
            'builder_data' => $request->builder_data,
            'is_active' => $request->boolean('is_active', true),
        ]);
        return redirect()->route('admin.pages.index')->with('success', 'Halaman berhasil diperbarui.');
    }

    public function destroy(Page $page)
    {
        $page->delete();
        return redirect()->route('admin.pages.index')->with('success', 'Halaman berhasil dihapus.');
    }
}
