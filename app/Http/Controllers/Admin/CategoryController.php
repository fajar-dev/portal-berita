<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $query = Category::withCount('articles');
        if ($request->filled('q')) {
            $query->where('name', 'like', "%{$request->q}%");
        }
        $categories = $query->orderBy('order')->paginate(10)->withQueryString();
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.form');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'slug' => 'required|max:255|unique:categories,slug',
            'color' => 'required|max:7',
            'order' => 'nullable|integer',
        ]);

        Category::create([
            'name' => $request->name,
            'slug' => Str::slug($request->slug),
            'color' => $request->color,
            'order' => $request->order ?? 0,
        ]);

        return redirect()->route('admin.categories.index')->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function edit(Category $category)
    {
        return view('admin.categories.form', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|max:255',
            'slug' => 'required|max:255|unique:categories,slug,' . $category->id,
            'color' => 'required|max:7',
            'order' => 'nullable|integer',
        ]);

        $category->update([
            'name' => $request->name,
            'slug' => Str::slug($request->slug),
            'color' => $request->color,
            'order' => $request->order ?? 0,
        ]);

        return redirect()->route('admin.categories.index')->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy(Category $category)
    {
        if ($category->articles()->count() > 0) {
            return redirect()->route('admin.categories.index')
                ->with('error', 'Tidak dapat menghapus kategori yang masih memiliki artikel.');
        }
        $category->delete();
        return redirect()->route('admin.categories.index')->with('success', 'Kategori berhasil dihapus.');
    }
}
