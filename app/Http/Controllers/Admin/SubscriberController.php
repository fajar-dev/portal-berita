<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subscriber;
use Illuminate\Http\Request;

class SubscriberController extends Controller
{
    public function index(Request $request)
    {
        $query = Subscriber::query();
        if ($request->filled('q')) {
            $query->where('email', 'like', "%{$request->q}%");
        }
        $subscribers = $query->orderBy('created_at', 'desc')->paginate(10)->withQueryString();
        return view('admin.subscribers.index', compact('subscribers'));
    }

    public function destroy(Subscriber $subscriber)
    {
        $subscriber->delete();
        return redirect()->route('admin.subscribers.index')->with('success', 'Subscriber berhasil dihapus.');
    }
}
