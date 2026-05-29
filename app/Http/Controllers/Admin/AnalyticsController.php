<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ArticleView;
use App\Models\Article;
use App\Models\SearchLog;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AnalyticsController extends Controller
{
    public function index()
    {
        $now = Carbon::now();

        // ── Overview Stats ──
        $totalViews = ArticleView::count();
        $todayViews = ArticleView::whereDate('created_at', $now->toDateString())->count();
        $weekViews = ArticleView::where('created_at', '>=', $now->startOfWeek()->toDateTimeString())->count();
        $monthViews = ArticleView::where('created_at', '>=', $now->copy()->startOfMonth()->toDateTimeString())->count();
        $uniqueVisitors = ArticleView::distinct('ip_address')->count('ip_address');

        // ── Daily Views (Last 14 Days) ──
        $dailyViews = ArticleView::select(
                DB::raw("DATE(created_at) as date"),
                DB::raw("COUNT(*) as views"),
                DB::raw("COUNT(DISTINCT ip_address) as unique_visitors")
            )
            ->where('created_at', '>=', Carbon::now()->subDays(13)->startOfDay())
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Fill in missing dates with zero
        $chartLabels = [];
        $chartViews = [];
        $chartUnique = [];
        for ($i = 13; $i >= 0; $i--) {
            $d = Carbon::now()->subDays($i)->format('Y-m-d');
            $chartLabels[] = Carbon::parse($d)->format('d M');
            $found = $dailyViews->firstWhere('date', $d);
            $chartViews[] = $found ? $found->views : 0;
            $chartUnique[] = $found ? $found->unique_visitors : 0;
        }

        // ── Top Articles (Most Viewed) ──
        $topArticles = Article::orderBy('views', 'desc')->take(10)->get();

        // ── Top Referrer Browsers (User Agent parsing) ──
        $browsers = ArticleView::select(
                DB::raw("
                    CASE
                        WHEN user_agent LIKE '%Firefox%' THEN 'Firefox'
                        WHEN user_agent LIKE '%Edg%' THEN 'Edge'
                        WHEN user_agent LIKE '%OPR%' OR user_agent LIKE '%Opera%' THEN 'Opera'
                        WHEN user_agent LIKE '%Chrome%' THEN 'Chrome'
                        WHEN user_agent LIKE '%Safari%' THEN 'Safari'
                        WHEN user_agent LIKE '%bot%' OR user_agent LIKE '%crawl%' OR user_agent LIKE '%spider%' THEN 'Bot/Crawler'
                        ELSE 'Lainnya'
                    END as browser
                "),
                DB::raw("COUNT(*) as total")
            )
            ->groupBy('browser')
            ->orderByDesc('total')
            ->get();

        // ── Device Type ──
        $devices = ArticleView::select(
                DB::raw("
                    CASE
                        WHEN user_agent LIKE '%Mobile%' OR user_agent LIKE '%Android%' THEN 'Mobile'
                        WHEN user_agent LIKE '%Tablet%' OR user_agent LIKE '%iPad%' THEN 'Tablet'
                        ELSE 'Desktop'
                    END as device
                "),
                DB::raw("COUNT(*) as total")
            )
            ->groupBy('device')
            ->orderByDesc('total')
            ->get();

        // ── Top Search Queries ──
        $topSearches = SearchLog::select('query', DB::raw('COUNT(*) as total'))
            ->groupBy('query')
            ->orderByDesc('total')
            ->take(10)
            ->get();

        // ── Views by Category ──
        $categoryViews = Article::select('category', DB::raw('SUM(views) as total_views'))
            ->where('status', \App\Enums\ContentStatus::PUBLISHED)
            ->groupBy('category')
            ->orderByDesc('total_views')
            ->get();

        // ── Reaction Analytics ──
        $reactionTypes = ['reactions_suka', 'reactions_terkejut', 'reactions_inspiratif', 'reactions_sedih'];
        $reactionTotals = [];
        foreach ($reactionTypes as $type) {
            $reactionTotals[$type] = Article::sum($type);
        }
        $totalReactions = array_sum($reactionTotals);

        // Top reacted articles (sum of all reactions)
        $topReactedArticles = Article::select('title', 'slug',
                'reactions_suka', 'reactions_terkejut', 'reactions_inspiratif', 'reactions_sedih',
                DB::raw('(reactions_suka + reactions_terkejut + reactions_inspiratif + reactions_sedih) as total_reactions')
            )
            ->whereRaw('(reactions_suka + reactions_terkejut + reactions_inspiratif + reactions_sedih) > 0')
            ->orderByDesc('total_reactions')
            ->take(10)
            ->get();

        return view('admin.analytics', compact(
            'totalViews', 'todayViews', 'weekViews', 'monthViews', 'uniqueVisitors',
            'chartLabels', 'chartViews', 'chartUnique',
            'topArticles', 'browsers', 'devices',
            'topSearches', 'categoryViews',
            'reactionTotals', 'totalReactions', 'topReactedArticles'
        ));
    }
}
