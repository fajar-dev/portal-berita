<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Infographic;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class InfographicController extends Controller
{
    public function index(Request $request)
    {
        $query = Infographic::query();
        if ($request->filled('q')) {
            $query->where('title', 'like', "%{$request->q}%");
        }
        $infographics = $query->orderBy('created_at', 'desc')->paginate(10)->withQueryString();
        return view('admin.infographics.index', compact('infographics'));
    }

    public function create()
    {
        return view('admin.infographics.form');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'image' => 'required|image|mimes:jpg,jpeg,png,webp|max:5120',
            'status' => 'required|in:published,draft,archived',
        ]);

        $imagePath = $request->file('image')->store('infographics', 'public');

        Infographic::create([
            'title' => $request->title,
            'slug' => Str::slug($request->title) . '-' . time(),
            'image' => 'storage/' . $imagePath,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.infographics.index')->with('success', 'Infografis berhasil ditambahkan.');
    }

    public function edit(Infographic $infographic)
    {
        return view('admin.infographics.form', compact('infographic'));
    }

    public function update(Request $request, Infographic $infographic)
    {
        $request->validate([
            'title' => 'required|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'status' => 'required|in:published,draft,archived',
        ]);

        $data = [
            'title' => $request->title,
            'status' => $request->status,
        ];

        if ($request->hasFile('image')) {
            // Delete old image
            $oldPath = str_replace('storage/', '', $infographic->image);
            if ($oldPath && Storage::disk('public')->exists($oldPath)) {
                Storage::disk('public')->delete($oldPath);
            }
            $data['image'] = 'storage/' . $request->file('image')->store('infographics', 'public');
        }

        $infographic->update($data);

        return redirect()->route('admin.infographics.index')->with('success', 'Infografis berhasil diperbarui.');
    }

    public function destroy(Infographic $infographic)
    {
        $oldPath = str_replace('storage/', '', $infographic->image);
        if ($oldPath && Storage::disk('public')->exists($oldPath)) {
            Storage::disk('public')->delete($oldPath);
        }
        $infographic->delete();
        return redirect()->route('admin.infographics.index')->with('success', 'Infografis berhasil dihapus.');
    }
}
