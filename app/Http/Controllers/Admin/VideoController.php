<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\VideoStory;
use Illuminate\Http\Request;

class VideoController extends Controller
{
    public function index(Request $request)
    {
        $query = VideoStory::query();
        if ($request->filled('q')) {
            $query->where('title', 'like', "%{$request->q}%");
        }
        $videos = $query->orderBy('created_at', 'desc')->paginate(10)->withQueryString();
        return view('admin.videos.index', compact('videos'));
    }

    public function create()
    {
        return view('admin.videos.form');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'iframe_link' => 'required',
            'status' => 'required|in:published,draft,archived',
        ]);

        VideoStory::create([
            'title' => $request->title,
            'iframe_link' => $request->iframe_link,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.videos.index')->with('success', 'Video berhasil ditambahkan.');
    }

    public function edit(VideoStory $video)
    {
        return view('admin.videos.form', compact('video'));
    }

    public function update(Request $request, VideoStory $video)
    {
        $request->validate([
            'title' => 'required|max:255',
            'iframe_link' => 'required',
            'status' => 'required|in:published,draft,archived',
        ]);

        $video->update([
            'title' => $request->title,
            'iframe_link' => $request->iframe_link,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.videos.index')->with('success', 'Video berhasil diperbarui.');
    }

    public function destroy(VideoStory $video)
    {
        $video->delete();
        return redirect()->route('admin.videos.index')->with('success', 'Video berhasil dihapus.');
    }
}
