<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Article;
use App\Models\Category;
use App\Models\VideoStory;
use App\Models\Opinion;
use App\Models\Infographic;
use App\Models\Subscriber;
use App\Models\Contact;
use App\Models\Comment;
use App\Models\Setting;
use App\Models\ArticleView;
use App\Models\SearchLog;
use App\Models\PollVote;
use App\Models\Poll;
use App\Models\Tag;
use App\Models\Menu;
use App\Models\Page;
use App\Enums\ContentStatus;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    /**
     * Helper to transform Eloquent Article model to the specific view array structure.
     * This keeps the template blade views 100% compatible while connecting to a normalized DB.
     */
    private function transformArticle($article)
    {
        if (!$article) return null;
        
        \Illuminate\Support\Carbon::setLocale('id');

        return [
            'slug' => $article->slug,
            'title' => $article->title,
            'excerpt' => $article->excerpt,
            'content' => $article->content,
            'category' => $article->category ? $article->category->name : 'Uncategorized',
            'category_slug' => $article->category ? $article->category->slug : '',
            'category_color' => $article->category ? $article->category->color : '#666',
            'image' => asset($article->image),
            'author' => $article->user->name,
            'author_username' => $article->user->username,
            'author_avatar' => asset($article->user->avatar),
            'author_bio' => $article->user->bio,
            'date' => $article->formatted_date, // Accessor from Carbon
            'read_time' => $article->read_time,
            'views' => $article->views,
            'comments_count' => $article->comments()->count(),
            'reactions' => [
                'suka' => $article->reactions_suka,
                'terkejut' => $article->reactions_terkejut,
                'inspiratif' => $article->reactions_inspiratif,
                'sedih' => $article->reactions_sedih,
            ],
            'comments' => $article->comments ? $article->comments->map(function($comment) {
                return [
                    'name' => $comment->name,
                    'email' => $comment->email,
                    'body' => $comment->body,
                    'date' => $comment->created_at->translatedFormat('d M Y - H:i'),
                ];
            })->all() : [],
            'tags' => $article->tags ? $article->tags->map(function($tag) {
                return [
                    'name' => $tag->name,
                    'slug' => $tag->slug
                ];
            })->all() : []
        ];
    }

    /**
     * Home Page Controller Method
     */
    public function home()
    {
        // 1. Fetch headline and secondary stacked articles from DB
        $dbHeadline = Article::with(['user', 'category'])->where('status', \App\Enums\ContentStatus::PUBLISHED)->where('is_headline', true)->first() ?: Article::with(['user', 'category'])->where('status', \App\Enums\ContentStatus::PUBLISHED)->first();
        $headline = $this->transformArticle($dbHeadline);
        
        $secondaryHeadlines = collect(Article::with(['user', 'category'])
            ->where('status', \App\Enums\ContentStatus::PUBLISHED)
            ->where('is_secondary_headline', true)
            ->orderBy('created_at', 'desc')
            ->take(2)
            ->get())
            ->map(fn($item) => $this->transformArticle($item))
            ->all();

        // 1.5 Fetch popular tags
        $popularTags = \App\Models\Tag::withCount('articles')
            ->orderBy('articles_count', 'desc')
            ->take(5)
            ->get();

        // 2. Fetch video multimedia records
        $videos = VideoStory::where('status', \App\Enums\ContentStatus::PUBLISHED)->get()->toArray();

        // 3. Fetch opinion columns
        $opinions = Opinion::where('status', \App\Enums\ContentStatus::PUBLISHED)->orderBy('id', 'desc')->take(3)->get()->toArray();

        // 4. Fetch infographics
        $infographics = Infographic::where('status', \App\Enums\ContentStatus::PUBLISHED)->get()->toArray();
        
        // 5. Group articles by category dynamically from DB
        $allCategories = Category::orderBy('order')->get();
        $categorySections = [];
        foreach ($allCategories as $cat) {
            $articles = collect(Article::with(['user', 'category'])
                ->where('status', \App\Enums\ContentStatus::PUBLISHED)
                ->where('category_id', $cat->id)
                ->orderBy('created_at', 'desc')
                ->take(4)
                ->get())
                ->map(fn($item) => $this->transformArticle($item))
                ->all();

            $categorySections[] = [
                'name' => $cat->name,
                'slug' => $cat->slug,
                'color' => $cat->color,
                'articles' => $articles,
            ];
        }

        // 6. Sidebar Trending lists
        $trendingArticles = collect(Article::with(['user', 'category'])
            ->where('status', \App\Enums\ContentStatus::PUBLISHED)
            ->orderBy('views', 'desc')
            ->take(5)
            ->get())
            ->map(fn($item) => $this->transformArticle($item))
            ->all();

        $latestArticles = collect(Article::with(['user', 'category'])
            ->where('status', \App\Enums\ContentStatus::PUBLISHED)
            ->orderBy('created_at', 'desc')
            ->get())
            ->map(fn($item) => $this->transformArticle($item))
            ->all();

        return view('pages.home', compact(
            'headline', 
            'secondaryHeadlines', 
            'videos', 
            'opinions',
            'infographics',
            'categorySections',
            'trendingArticles',
            'latestArticles',
            'popularTags'
        ));
    }

    /**
     * Category Page Method
     */
    public function category($categorySlug)
    {
        $cat = Category::where('slug', $categorySlug)->firstOrFail();
        $categoryName = $cat->name;

        // Query database
        $categoryArticles = collect(Article::with(['user', 'category'])
            ->where('status', \App\Enums\ContentStatus::PUBLISHED)
            ->where('category_id', $cat->id)
            ->orderBy('created_at', 'desc')
            ->get())
            ->map(fn($item) => $this->transformArticle($item))
            ->all();

        // Sidebar Trending
        $trendingArticles = collect(Article::with(['user', 'category'])
            ->where('status', \App\Enums\ContentStatus::PUBLISHED)
            ->orderBy('views', 'desc')
            ->take(5)
            ->get())
            ->map(fn($item) => $this->transformArticle($item))
            ->all();

        return view('pages.category', compact('categoryArticles', 'categoryName', 'trendingArticles'));
    }

    /**
     * Article Detail Page Method
     */
    public function detail($slug)
    {
        $dbArticle = Article::with(['user', 'tags'])
            ->where('slug', $slug)
            ->where('status', \App\Enums\ContentStatus::PUBLISHED)
            ->first();

        if (!$dbArticle) {
            abort(404, 'Artikel tidak ditemukan.');
        }

        // Active dynamic interaction: Increment views directly in DB on click!
        $dbArticle->increment('views');

        // Log detailed article views with IP and User Agent
        ArticleView::create([
            'article_id' => $dbArticle->id,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
        
        $article = $this->transformArticle($dbArticle);

        // Get related articles (same category, excluding active one)
        $related = collect(Article::with(['user', 'category'])
            ->where('status', \App\Enums\ContentStatus::PUBLISHED)
            ->where('category_id', $dbArticle->category_id)
            ->where('id', '!=', $dbArticle->id)
            ->take(3)
            ->get())
            ->map(fn($item) => $this->transformArticle($item))
            ->all();

        // Sidebar Trending
        $trendingArticles = collect(Article::with(['user', 'category'])
            ->where('status', \App\Enums\ContentStatus::PUBLISHED)
            ->orderBy('views', 'desc')
            ->take(5)
            ->get())
            ->map(fn($item) => $this->transformArticle($item))
            ->all();

        return view('pages.detail', compact('article', 'related', 'trendingArticles'));
    }

    /**
     * AJAX Get Comments Method
     */
    public function getComments($slug)
    {
        $dbArticle = Article::where('slug', $slug)
            ->where('status', \App\Enums\ContentStatus::PUBLISHED)
            ->first();

        if (!$dbArticle) {
            return response()->json(['error' => 'Artikel tidak ditemukan'], 404);
        }

        \Illuminate\Support\Carbon::setLocale('id');
        
        $rootComments = \App\Models\Comment::with(['user', 'replies.user', 'replies' => function($q) {
            $q->orderBy('created_at', 'asc');
        }])
        ->where('article_id', $dbArticle->id)
        ->whereNull('parent_id')
        ->orderBy('created_at', 'desc')
        ->get();

        $formatComment = function($comment) use (&$formatComment) {
            return [
                'id' => $comment->id,
                'name' => $comment->user ? $comment->user->name : $comment->name,
                'email' => $comment->user ? $comment->user->email : $comment->email,
                'avatar' => $comment->user && $comment->user->avatar ? asset($comment->user->avatar) : null,
                'is_admin' => $comment->user && $comment->user->role === 'admin',
                'body' => $comment->body,
                'date' => $comment->created_at->translatedFormat('d M Y - H:i'),
                'replies' => $comment->replies ? $comment->replies->map($formatComment)->all() : []
            ];
        };

        $comments = $rootComments->map($formatComment)->all();
        $commentsCount = \App\Models\Comment::where('article_id', $dbArticle->id)->count();

        return view('partials.comments', compact('comments', 'commentsCount'));
    }

    /**
     * Bookmarks Page Method
     */
    public function bookmarks()
    {
        $trendingArticles = collect(Article::with(['user', 'category'])
            ->where('status', \App\Enums\ContentStatus::PUBLISHED)
            ->orderBy('views', 'desc')
            ->take(5)
            ->get())
            ->map(fn($item) => $this->transformArticle($item))
            ->all();
            
        return view('pages.bookmarks', compact('trendingArticles'));
    }

    /**
     * Search Results Page Method
     */
    public function search(Request $request)
    {
        $query = $request->input('q');
        
        $results = [];
        if ($query) {
            // Log search query in database
            SearchLog::create([
                'query' => $query,
                'ip_address' => $request->ip(),
            ]);

            $results = collect(Article::with(['user', 'category'])
                ->where('status', \App\Enums\ContentStatus::PUBLISHED)
                ->where(function($q) use ($query) {
                    $q->where('title', 'like', "%{$query}%")
                      ->orWhere('excerpt', 'like', "%{$query}%");
                })
                ->get())
                ->map(fn($item) => $this->transformArticle($item))
                ->all();
        }

        $trendingArticles = collect(Article::with(['user', 'category'])
            ->where('status', \App\Enums\ContentStatus::PUBLISHED)
            ->orderBy('views', 'desc')
            ->take(5)
            ->get())
            ->map(fn($item) => $this->transformArticle($item))
            ->all();

        return view('pages.search', compact('results', 'query', 'trendingArticles'));
    }

    /**
     * GET Action: Live Autocomplete Search API
     */
    public function autocomplete(Request $request)
    {
        $query = $request->query('q');

        if (empty($query) || strlen($query) < 2) {
            return response()->json([]);
        }

        $results = Article::select('title', 'slug', 'image', 'category')
            ->where('status', \App\Enums\ContentStatus::PUBLISHED)
            ->where(function($q) use ($query) {
                $q->where('title', 'like', "%{$query}%")
                  ->orWhere('excerpt', 'like', "%{$query}%");
            })
            ->take(5)
            ->get()
            ->map(function($article) {
                return [
                    'title' => $article->title,
                    'url' => route('news.detail', $article->slug),
                    'image' => asset($article->image),
                    'category' => $article->category
                ];
            });

        return response()->json($results);
    }

    /**
     * Author Profile Page Method
     */
    public function author($username)
    {
        // Find matching author user in DB
        $dbUser = User::where('username', str_replace('-', '.', $username))->first();

        if (!$dbUser) {
            abort(404, 'Penulis tidak ditemukan.');
        }

        // Query articles of this author
        $authorArticles = collect(Article::with(['user', 'category'])
            ->where('status', \App\Enums\ContentStatus::PUBLISHED)
            ->where('user_id', $dbUser->id)
            ->orderBy('created_at', 'desc')
            ->get())
            ->map(fn($item) => $this->transformArticle($item))
            ->all();

        $author = [
            'name' => $dbUser->name,
            'username' => $dbUser->username,
            'avatar' => $dbUser->avatar,
            'bio' => $dbUser->bio,
        ];

        // Dynamic aggregate stats direct from DB!
        $totalViews = Article::where('status', \App\Enums\ContentStatus::PUBLISHED)->where('user_id', $dbUser->id)->sum('views');
        $totalArticles = Article::where('status', \App\Enums\ContentStatus::PUBLISHED)->where('user_id', $dbUser->id)->count();

        $trendingArticles = collect(Article::with(['user', 'category'])
            ->where('status', \App\Enums\ContentStatus::PUBLISHED)
            ->get())
            ->map(fn($item) => $this->transformArticle($item))
            ->all();

        return view('pages.author', compact('author', 'authorArticles', 'totalViews', 'totalArticles', 'trendingArticles'));
    }

    /**
     * Contact Page Method
     */
    public function contact()
    {
        $trendingArticles = collect(Article::with(['user', 'category'])
            ->orderBy('views', 'desc')
            ->take(5)
            ->get())
            ->map(fn($item) => $this->transformArticle($item))
            ->all();
            
        return view('pages.contact', compact('trendingArticles'));
    }

    /**
     * Dynamic Custom Page Method
     */
    public function showPage($slug)
    {
        $page = Page::where('slug', $slug)->where('is_active', true)->firstOrFail();
        
        $trendingArticles = collect(Article::with(['user', 'category'])
            ->orderBy('views', 'desc')
            ->take(5)
            ->get())
            ->map(fn($item) => $this->transformArticle($item))
            ->all();
            
        return view('pages.custom', compact('page', 'trendingArticles'));
    }

    /**
     * Dynamic Sitemap.xml Generator
     */
    public function sitemap()
    {
        $articles = Article::where('status', \App\Enums\ContentStatus::PUBLISHED)->orderBy('updated_at', 'desc')->get();
        $pages = Page::where('is_active', true)->orderBy('updated_at', 'desc')->get();
        $tags = Tag::orderBy('updated_at', 'desc')->get();

        $categories = Category::orderBy('order')->get();

        $content = view('pages.sitemap', compact('articles', 'pages', 'tags', 'categories'));

        return response($content, 200)
            ->header('Content-Type', 'text/xml');
    }

    /**
     * POST Action: Newsletter Subscribe
     */
    public function subscribe(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:subscribers,email',
        ], [
            'email.required' => 'Alamat email wajib diisi.',
            'email.email' => 'Format alamat email tidak valid.',
            'email.unique' => 'Email ini sudah terdaftar dalam newsletter kami.',
        ]);

        $subscriber = Subscriber::create([
            'email' => $request->email,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Terima kasih! Email Anda berhasil didaftarkan dalam newsletter NusaKini.',
            'data' => $subscriber
        ]);
    }

    /**
     * POST Action: Contact Send Message
     */
    public function sendMessage(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'email.required' => 'Alamat email wajib diisi.',
            'email.email' => 'Format alamat email tidak valid.',
            'subject.required' => 'Subjek wajib dipilih.',
            'message.required' => 'Pesan wajib diisi.',
        ]);

        $contact = Contact::create([
            'name' => $request->name,
            'email' => $request->email,
            'subject' => $request->subject,
            'message' => $request->message,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Pesan Anda berhasil terkirim. Redaksi kami akan segera meninjau umpan balik Anda.',
            'data' => $contact
        ]);
    }

    /**
     * POST Action: Add Article Comment
     */
    public function addComment(Request $request, $slug)
    {
        $article = Article::where('slug', $slug)->where('status', \App\Enums\ContentStatus::PUBLISHED)->first();

        if (!$article) {
            return response()->json([
                'success' => false,
                'message' => 'Artikel tidak ditemukan.'
            ], 404);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'body' => 'required|string',
            'parent_id' => 'nullable|exists:comments,id',
        ], [
            'name.required' => 'Nama wajib diisi.',
            'email.required' => 'Alamat email wajib diisi.',
            'email.email' => 'Format alamat email tidak valid.',
            'body.required' => 'Isi komentar wajib diisi.',
            'parent_id.exists' => 'Komentar yang dibalas tidak ditemukan.',
        ]);

        $comment = Comment::create([
            'article_id' => $article->id,
            'parent_id' => $request->parent_id,
            'user_id' => auth()->id(), // Save user_id if authenticated
            'name' => auth()->check() ? auth()->user()->name : $request->name,
            'email' => auth()->check() ? auth()->user()->email : $request->email,
            'body' => $request->body,
        ]);

        // Format date in Indonesian for direct rendering in JS
        \Illuminate\Support\Carbon::setLocale('id');
        $formattedDate = $comment->created_at->translatedFormat('d M Y - H:i');

        return response()->json([
            'success' => true,
            'message' => 'Komentar berhasil ditambahkan!',
            'data' => [
                'id' => $comment->id,
                'name' => $comment->name,
                'email' => $comment->email,
                'body' => $comment->body,
                'date' => $formattedDate,
                'replies' => [],
                'parent_id' => $comment->parent_id
            ]
        ], 201);
    }

    /**
     * POST Action: Submit Opinion Poll Vote
     */
    public function votePoll(Request $request)
    {
        $request->validate([
            'poll_id' => 'required',
            'option' => 'required|string|in:opt1,opt2,opt3,opt4',
        ]);

        $pollId = $request->poll_id;
        $option = $request->option;
        $ip = $request->ip();

        // Verify active poll exists in database
        $poll = Poll::where('id', $pollId)->where('is_active', true)->first();
        if (!$poll) {
            return response()->json([
                'success' => false,
                'message' => 'Jajak pendapat tidak aktif atau tidak ditemukan.'
            ], 404);
        }

        // Prevent double-voting by IP address
        $hasVoted = PollVote::where('poll_id', $pollId)
            ->where('ip_address', $ip)
            ->exists();

        if ($hasVoted) {
            return response()->json([
                'success' => false,
                'message' => 'Anda sudah memberikan suara untuk jajak pendapat ini.'
            ], 422);
        }

        // Save vote to DB
        PollVote::create([
            'poll_id' => $pollId,
            'option_key' => $option,
            'ip_address' => $ip,
        ]);

        return $this->getPollResultsResponse($pollId, 'Terima kasih atas partisipasi Anda!');
    }

    /**
     * GET Action: Fetch Live Opinion Poll Results
     */
    public function getPollResults($pollId)
    {
        return $this->getPollResultsResponse($pollId);
    }

    /**
     * Private helper to compile poll percentage results from base seed counts + database entries
     */
    private function getPollResultsResponse($pollId, ?string $message = null)
    {
        $poll = Poll::find($pollId);
        if (!$poll) {
            return response()->json([
                'success' => false,
                'message' => 'Jajak pendapat tidak ditemukan.'
            ], 404);
        }

        $dbVotes = PollVote::where('poll_id', $pollId)->get()->groupBy('option_key');

        // Incorporate realistic base seed numbers only if it's the EBT default poll (ID = 1)
        $baseOpt1 = ($pollId == 1) ? 520 : 0;
        $baseOpt2 = ($pollId == 1) ? 240 : 0;
        $baseOpt3 = ($pollId == 1) ? 110 : 0;
        $baseOpt4 = ($pollId == 1) ? 45 : 0;

        $votes = [
            'opt1' => $baseOpt1 + ($dbVotes->has('opt1') ? $dbVotes->get('opt1')->count() : 0),
            'opt2' => $baseOpt2 + ($dbVotes->has('opt2') ? $dbVotes->get('opt2')->count() : 0),
            'opt3' => $baseOpt3 + ($dbVotes->has('opt3') ? $dbVotes->get('opt3')->count() : 0),
            'opt4' => $baseOpt4 + ($dbVotes->has('opt4') ? $dbVotes->get('opt4')->count() : 0),
        ];

        $total = array_sum($votes);
        $percentages = [];
        foreach ($votes as $key => $count) {
            $percentages[$key] = $total > 0 ? round(($count / $total) * 100) : 0;
        }

        return response()->json([
            'success' => true,
            'message' => $message,
            'poll_id' => $pollId,
            'total_votes' => $total,
            'results' => $percentages,
        ]);
    }

    /**
     * GET Action: Tag Listing Page
     */
    public function tag($slug)
    {
        $tag = Tag::where('slug', $slug)->first();

        if (!$tag) {
            abort(404, 'Tag tidak ditemukan.');
        }

        // Fetch articles associated with this tag (published only)
        $tagArticles = collect($tag->articles()->where('status', \App\Enums\ContentStatus::PUBLISHED)->with('user')->orderBy('created_at', 'desc')->get())
            ->map(fn($item) => $this->transformArticle($item))
            ->all();

        $tagName = $tag->name;

        $trendingArticles = collect(Article::with(['user', 'category'])
            ->where('status', \App\Enums\ContentStatus::PUBLISHED)
            ->orderBy('views', 'desc')
            ->take(5)
            ->get())
            ->map(fn($item) => $this->transformArticle($item))
            ->all();

        return view('pages.tag', compact('tagArticles', 'tagName', 'trendingArticles'));
    }

    /**
     * POST Action: Dynamic Article Reactions Increment
     */
    public function react(Request $request, $slug)
    {
        $request->validate([
            'type' => 'required|string|in:suka,terkejut,inspiratif,sedih',
        ]);

        $article = Article::where('slug', $slug)->where('status', \App\Enums\ContentStatus::PUBLISHED)->first();

        if (!$article) {
            return response()->json([
                'success' => false,
                'message' => 'Artikel tidak ditemukan.'
            ], 404);
        }

        $type = $request->type;
        $columnMap = [
            'suka' => 'reactions_suka',
            'terkejut' => 'reactions_terkejut',
            'inspiratif' => 'reactions_inspiratif',
            'sedih' => 'reactions_sedih',
        ];

        $column = $columnMap[$type];
        $article->increment($column);

        return response()->json([
            'success' => true,
            'message' => 'Reaksi berhasil dicatat.',
            'new_count' => $article->$column,
        ]);
    }
    /**
     * RSS Feed Generator
     */
    public function feed()
    {
        $articles = Article::with(['user', 'category'])
            ->where('status', \App\Enums\ContentStatus::PUBLISHED)
            ->orderBy('created_at', 'desc')
            ->take(20)
            ->get();

        return response()->view('feed', compact('articles'))
            ->header('Content-Type', 'application/rss+xml; charset=utf-8');
    }
}
