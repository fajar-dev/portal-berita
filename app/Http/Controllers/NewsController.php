<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Article;
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
            'category' => $article->category,
            'image' => $article->image,
            'author' => $article->user->name,
            'author_username' => $article->user->username,
            'author_avatar' => $article->user->avatar,
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
        $dbHeadline = Article::with('user')->where('is_headline', true)->first() ?: Article::with('user')->first();
        $headline = $this->transformArticle($dbHeadline);
        
        $secondaryHeadlines = collect(Article::with('user')
            ->where('is_secondary_headline', true)
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get())
            ->map(fn($item) => $this->transformArticle($item))
            ->all();

        // 2. Fetch video multimedia records
        $videos = VideoStory::all()->toArray();

        // 3. Fetch opinion columns
        $opinions = Opinion::orderBy('id', 'desc')->take(3)->get()->toArray();

        // 4. Fetch infographics
        $infographics = Infographic::all()->toArray();
        
        // 5. Group articles by category dynamically
        $politikArticles = collect(Article::with('user')
            ->where('category', 'Politik')
            ->orderBy('created_at', 'desc')
            ->take(4)
            ->get())
            ->map(fn($item) => $this->transformArticle($item))
            ->all();

        $ekonomiArticles = collect(Article::with('user')
            ->where('category', 'Ekonomi')
            ->orderBy('created_at', 'desc')
            ->take(4)
            ->get())
            ->map(fn($item) => $this->transformArticle($item))
            ->all();

        $teknologiArticles = collect(Article::with('user')
            ->where('category', 'Teknologi')
            ->orderBy('created_at', 'desc')
            ->take(4)
            ->get())
            ->map(fn($item) => $this->transformArticle($item))
            ->all();
        
        $lifestyleArticles = collect(Article::with('user')
            ->whereIn('category', ['Gaya Hidup', 'Olahraga'])
            ->orderBy('created_at', 'desc')
            ->take(4)
            ->get())
            ->map(fn($item) => $this->transformArticle($item))
            ->all();

        // 6. Sidebar Trending lists
        $trendingArticles = collect(Article::with('user')
            ->orderBy('views', 'desc')
            ->take(5)
            ->get())
            ->map(fn($item) => $this->transformArticle($item))
            ->all();

        $latestArticles = collect(Article::with('user')
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
            'politikArticles', 
            'ekonomiArticles', 
            'teknologiArticles', 
            'lifestyleArticles',
            'trendingArticles',
            'latestArticles'
        ));
    }

    /**
     * Category Page Method
     */
    public function category($categorySlug)
    {
        // Category slug mappings
        $categoryName = ucfirst($categorySlug);
        if ($categorySlug === 'politik-hukum') $categoryName = 'Politik';
        if ($categorySlug === 'ekonomi-bisnis') $categoryName = 'Ekonomi';
        if ($categorySlug === 'teknologi-sains') $categoryName = 'Teknologi';
        if ($categorySlug === 'gaya-hidup') $categoryName = 'Gaya Hidup';

        // Query database
        $categoryArticles = collect(Article::with('user')
            ->where('category', $categoryName)
            ->orderBy('created_at', 'desc')
            ->get())
            ->map(fn($item) => $this->transformArticle($item))
            ->all();

        // Sidebar Trending
        $trendingArticles = collect(Article::with('user')
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
        $dbArticle = Article::with(['user', 'comments', 'tags'])->where('slug', $slug)->first();

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
        $related = collect(Article::with('user')
            ->where('category', $dbArticle->category)
            ->where('id', '!=', $dbArticle->id)
            ->take(3)
            ->get())
            ->map(fn($item) => $this->transformArticle($item))
            ->all();

        // Sidebar Trending
        $trendingArticles = collect(Article::with('user')
            ->orderBy('views', 'desc')
            ->take(5)
            ->get())
            ->map(fn($item) => $this->transformArticle($item))
            ->all();

        return view('pages.detail', compact('article', 'related', 'trendingArticles'));
    }

    /**
     * Bookmarks Page Method
     */
    public function bookmarks()
    {
        $trendingArticles = collect(Article::with('user')
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

            $results = collect(Article::with('user')
                ->where('title', 'like', "%{$query}%")
                ->orWhere('excerpt', 'like', "%{$query}%")
                ->get())
                ->map(fn($item) => $this->transformArticle($item))
                ->all();
        }

        $trendingArticles = collect(Article::with('user')
            ->orderBy('views', 'desc')
            ->take(5)
            ->get())
            ->map(fn($item) => $this->transformArticle($item))
            ->all();

        return view('pages.search', compact('results', 'query', 'trendingArticles'));
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
        $authorArticles = collect(Article::with('user')
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
        $totalViews = Article::where('user_id', $dbUser->id)->sum('views');
        $totalArticles = Article::where('user_id', $dbUser->id)->count();

        $trendingArticles = collect(Article::with('user')
            ->orderBy('views', 'desc')
            ->take(5)
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
        $trendingArticles = collect(Article::with('user')
            ->orderBy('views', 'desc')
            ->take(5)
            ->get())
            ->map(fn($item) => $this->transformArticle($item))
            ->all();
            
        return view('pages.contact', compact('trendingArticles'));
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
        $article = Article::where('slug', $slug)->first();

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
        ], [
            'name.required' => 'Nama wajib diisi.',
            'email.required' => 'Alamat email wajib diisi.',
            'email.email' => 'Format alamat email tidak valid.',
            'body.required' => 'Isi komentar wajib diisi.',
        ]);

        $comment = Comment::create([
            'article_id' => $article->id,
            'name' => $request->name,
            'email' => $request->email,
            'body' => $request->body,
        ]);

        // Format date in Indonesian for direct rendering in JS
        \Illuminate\Support\Carbon::setLocale('id');
        $formattedDate = $comment->created_at->translatedFormat('d M Y - H:i');

        return response()->json([
            'success' => true,
            'message' => 'Komentar Anda berhasil dipublikasikan!',
            'data' => [
                'name' => $comment->name,
                'email' => $comment->email,
                'body' => $comment->body,
                'date' => $formattedDate
            ]
        ]);
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

        // Fetch articles associated with this tag
        $tagArticles = collect($tag->articles()->with('user')->orderBy('created_at', 'desc')->get())
            ->map(fn($item) => $this->transformArticle($item))
            ->all();

        $tagName = $tag->name;

        $trendingArticles = collect(Article::with('user')
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

        $article = Article::where('slug', $slug)->first();

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
}
