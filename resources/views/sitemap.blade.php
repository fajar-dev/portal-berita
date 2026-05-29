{!! '<' . '?xml version="1.0" encoding="UTF-8"?' . '>' !!}
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <!-- Home Page -->
    <url>
        <loc>{{ route('news.home') }}</loc>
        <lastmod>{{ now()->startOfDay()->toAtomString() }}</lastmod>
        <changefreq>always</changefreq>
        <priority>1.0</priority>
    </url>

    <!-- Categories -->
    @foreach($categories as $cat)
        <url>
            <loc>{{ route('news.category', $cat->slug) }}</loc>
            <lastmod>{{ now()->startOfDay()->toAtomString() }}</lastmod>
            <changefreq>daily</changefreq>
            <priority>0.8</priority>
        </url>
    @endforeach

    <!-- Custom Pages -->
    @foreach($pages as $page)
        <url>
            <loc>{{ route('news.page', $page->slug) }}</loc>
            <lastmod>{{ $page->updated_at->toAtomString() }}</lastmod>
            <changefreq>weekly</changefreq>
            <priority>0.7</priority>
        </url>
    @endforeach

    <!-- Dynamic Tags -->
    @foreach($tags as $tag)
        <url>
            <loc>{{ route('news.tag', $tag->slug) }}</loc>
            <lastmod>{{ $tag->updated_at->toAtomString() }}</lastmod>
            <changefreq>weekly</changefreq>
            <priority>0.5</priority>
        </url>
    @endforeach

    <!-- Dynamic News Articles -->
    @foreach($articles as $article)
        <url>
            <loc>{{ route('news.detail', $article->slug) }}</loc>
            <lastmod>{{ $article->updated_at->toAtomString() }}</lastmod>
            <changefreq>monthly</changefreq>
            <priority>0.9</priority>
        </url>
    @endforeach
</urlset>