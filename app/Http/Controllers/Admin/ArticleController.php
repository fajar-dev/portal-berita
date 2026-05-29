<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Support\Str;

class ArticleController extends Controller
{
    public function index(Request $request)
    {
        $query = Article::with(['user', 'category']);
        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($qb) use ($q) {
                $qb->where('title', 'like', "%{$q}%")
                   ->orWhere('content', 'like', "%{$q}%")
                   ->orWhereHas('category', fn($cq) => $cq->where('name', 'like', "%{$q}%"));
            });
        }
        $articles = $query->orderBy('created_at', 'desc')->paginate(10)->withQueryString();
        return view('admin.articles.index', compact('articles'));
    }

    public function create()
    {
        $categories = Category::orderBy('order')->get();
        $tags = Tag::orderBy('name')->get();
        $selectedTags = old('tags', []);
        return view('admin.articles.form', compact('categories', 'tags', 'selectedTags'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'category_id' => 'required|exists:categories,id',
            'content' => 'required',
            'status' => 'required|in:published,draft,archived',
        ]);

        $article = new Article($validated);
        $article->slug = Str::slug($request->title) . '-' . time();
        $article->user_id = auth()->id() ?? 1;
        $article->excerpt = Str::limit(strip_tags($request->input('content')), 150);
        $wordCount = str_word_count(strip_tags($request->input('content')));
        $article->read_time = ceil($wordCount / 200) . ' Menit';

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('images/articles', 'public');
            $article->image = 'storage/' . $path;
        }

        $article->save();

        // Sync tags
        $tagIds = $request->input('tags', []);
        if ($request->filled('new_tags')) {
            foreach ($request->new_tags as $tagName) {
                $tag = Tag::firstOrCreate(
                    ['slug' => Str::slug($tagName)],
                    ['name' => $tagName]
                );
                $tagIds[] = $tag->id;
            }
        }
        $article->tags()->sync(array_unique($tagIds));

        return redirect()->route('admin.articles.index')->with('success', 'Artikel berhasil ditambahkan.');
    }

    public function edit(Article $article)
    {
        $categories = Category::orderBy('order')->get();
        $tags = Tag::orderBy('name')->get();
        $selectedTags = old('tags', $article->tags->pluck('id')->toArray());
        return view('admin.articles.form', compact('article', 'categories', 'tags', 'selectedTags'));
    }

    public function update(Request $request, Article $article)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'category_id' => 'required|exists:categories,id',
            'content' => 'required',
            'status' => 'required|in:published,draft,archived',
        ]);

        $article->fill($validated);
        $article->excerpt = Str::limit(strip_tags($request->input('content')), 150);
        $wordCount = str_word_count(strip_tags($request->input('content')));
        $article->read_time = ceil($wordCount / 200) . ' Menit';

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('images/articles', 'public');
            $article->image = 'storage/' . $path;
        }

        $article->save();

        // Sync tags
        $tagIds = $request->input('tags', []);
        if ($request->filled('new_tags')) {
            foreach ($request->new_tags as $tagName) {
                $tag = Tag::firstOrCreate(
                    ['slug' => Str::slug($tagName)],
                    ['name' => $tagName]
                );
                $tagIds[] = $tag->id;
            }
        }
        $article->tags()->sync(array_unique($tagIds));

        return redirect()->route('admin.articles.index')->with('success', 'Artikel berhasil diperbarui.');
    }

    public function destroy(Article $article)
    {
        $article->tags()->detach();
        $article->delete();
        return redirect()->route('admin.articles.index')->with('success', 'Artikel berhasil dihapus.');
    }
}
