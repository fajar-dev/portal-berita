<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Poll;
use App\Models\PollVote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PollController extends Controller
{
    public function index(Request $request)
    {
        $query = Poll::query();
        if ($request->filled('q')) {
            $query->where('question', 'like', "%{$request->q}%");
        }
        $polls = $query->orderBy('created_at', 'desc')->paginate(10)->withQueryString();

        // Attach vote counts to each poll
        $pollIds = $polls->pluck('id');
        $voteCounts = PollVote::whereIn('poll_id', $pollIds)
            ->select('poll_id', DB::raw('COUNT(*) as total'))
            ->groupBy('poll_id')
            ->pluck('total', 'poll_id');

        return view('admin.polls.index', compact('polls', 'voteCounts'));
    }

    public function show(Poll $poll)
    {
        $totalVotes = PollVote::where('poll_id', $poll->id)->count();

        $optionVotes = PollVote::where('poll_id', $poll->id)
            ->select('option_key', DB::raw('COUNT(*) as total'))
            ->groupBy('option_key')
            ->pluck('total', 'option_key');

        $options = [];
        foreach (['opt1', 'opt2', 'opt3', 'opt4'] as $key) {
            if (!empty($poll->$key)) {
                $count = $optionVotes[$key] ?? 0;
                $options[] = [
                    'key' => $key,
                    'label' => $poll->$key,
                    'votes' => $count,
                    'percent' => $totalVotes > 0 ? round(($count / $totalVotes) * 100, 1) : 0,
                ];
            }
        }

        // Recent votes (last 20)
        $recentVotes = PollVote::where('poll_id', $poll->id)
            ->orderBy('created_at', 'desc')
            ->take(20)
            ->get();

        return view('admin.polls.show', compact('poll', 'totalVotes', 'options', 'recentVotes'));
    }

    public function create()
    {
        return view('admin.polls.form');
    }

    public function store(Request $request)
    {
        $request->validate(['question' => 'required', 'opt1' => 'required', 'opt2' => 'required']);

        $isActive = $request->boolean('is_active', false);
        if ($isActive) {
            Poll::where('is_active', true)->update(['is_active' => false]);
        }

        Poll::create([
            'question' => $request->question,
            'opt1' => $request->opt1,
            'opt2' => $request->opt2,
            'opt3' => $request->opt3,
            'opt4' => $request->opt4,
            'is_active' => $isActive,
        ]);
        return redirect()->route('admin.polls.index')->with('success', 'Polling berhasil dibuat.');
    }

    public function edit(Poll $poll)
    {
        return view('admin.polls.form', compact('poll'));
    }

    public function update(Request $request, Poll $poll)
    {
        $request->validate(['question' => 'required', 'opt1' => 'required', 'opt2' => 'required']);

        $isActive = $request->boolean('is_active', false);
        if ($isActive) {
            Poll::where('is_active', true)->where('id', '!=', $poll->id)->update(['is_active' => false]);
        }

        $poll->update([
            'question' => $request->question,
            'opt1' => $request->opt1,
            'opt2' => $request->opt2,
            'opt3' => $request->opt3,
            'opt4' => $request->opt4,
            'is_active' => $isActive,
        ]);
        return redirect()->route('admin.polls.index')->with('success', 'Polling berhasil diperbarui.');
    }

    public function destroy(Poll $poll)
    {
        $poll->delete();
        return redirect()->route('admin.polls.index')->with('success', 'Polling berhasil dihapus.');
    }
}
