<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Advertisement;
use App\Enums\AdPosition;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdvertisementController extends Controller
{
    public function index()
    {
        // Ensure all 4 positions exist
        foreach (AdPosition::cases() as $pos) {
            Advertisement::firstOrCreate(
                ['position' => $pos->value],
                ['title' => ucwords(str_replace('_', ' ', $pos->value)), 'image_url' => '', 'target_url' => '', 'is_active' => false]
            );
        }

        $ads = Advertisement::orderByRaw("CASE position WHEN 'header' THEN 1 WHEN 'sidebar' THEN 2 WHEN 'home_middle' THEN 3 WHEN 'article_inline' THEN 4 ELSE 5 END")->get();

        return view('admin.ads.index', compact('ads'));
    }

    public function edit(Advertisement $ad)
    {
        return view('admin.ads.form', compact('ad'));
    }

    public function update(Request $request, Advertisement $ad)
    {
        $request->validate([
            'title' => 'required|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:2048',
            'target_url' => 'required|max:500',
        ]);

        $data = [
            'title' => $request->title,
            'target_url' => $request->target_url,
            'is_active' => $request->boolean('is_active', true),
        ];

        if ($request->hasFile('image')) {
            $oldPath = str_replace('storage/', '', $ad->image_url);
            if ($oldPath && Storage::disk('public')->exists($oldPath)) {
                Storage::disk('public')->delete($oldPath);
            }
            $data['image_url'] = 'storage/' . $request->file('image')->store('ads', 'public');
        }

        $ad->update($data);

        return redirect()->route('admin.ads.index')->with('success', 'Iklan "' . $ad->title . '" berhasil diperbarui.');
    }
}
