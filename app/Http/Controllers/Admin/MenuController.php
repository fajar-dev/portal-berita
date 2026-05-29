<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index(Request $request)
    {
        $query = Menu::whereNull('parent_id')->with('children');
        if ($request->filled('q')) {
            $query->where('name', 'like', "%{$request->q}%");
        }
        $menus = $query->orderBy('order')->paginate(10)->withQueryString();
        return view('admin.menus.index', compact('menus'));
    }

    public function create()
    {
        $parents = Menu::whereNull('parent_id')->orderBy('order')->get();
        return view('admin.menus.form', compact('parents'));
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|max:100', 'url' => 'required']);
        Menu::create([
            'name' => $request->name,
            'url' => $request->url,
            'parent_id' => $request->parent_id ?: null,
            'order' => $request->order ?? 0,
            'is_active' => $request->boolean('is_active', true),
        ]);
        return redirect()->route('admin.menus.index')->with('success', 'Menu berhasil ditambahkan.');
    }

    public function edit(Menu $menu)
    {
        $parents = Menu::whereNull('parent_id')->where('id', '!=', $menu->id)->orderBy('order')->get();
        return view('admin.menus.form', compact('menu', 'parents'));
    }

    public function update(Request $request, Menu $menu)
    {
        $request->validate(['name' => 'required|max:100', 'url' => 'required']);
        $menu->update([
            'name' => $request->name,
            'url' => $request->url,
            'parent_id' => $request->parent_id ?: null,
            'order' => $request->order ?? 0,
            'is_active' => $request->boolean('is_active', true),
        ]);
        return redirect()->route('admin.menus.index')->with('success', 'Menu berhasil diperbarui.');
    }

    public function destroy(Menu $menu)
    {
        $menu->children()->delete();
        $menu->delete();
        return redirect()->route('admin.menus.index')->with('success', 'Menu berhasil dihapus.');
    }
}
