{!! '<' . '?xml version="1.0" encoding="UTF-8"?' . '>' !!}
<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom" xmlns:media="http://search.yahoo.com/mrss/">
    <channel>
        <title>{{ \App\Models\Setting::get('site_name', 'NusaKini') }} - Portal Berita Modern, Kredibel, &amp; Tepercaya</title>
        <link>{{ route('news.home') }}</link>
        <description>{{ \App\Models\Setting::get('site_name', 'NusaKini') }} menyajikan portal berita terkini seputar Politik, Ekonomi, Teknologi, Olahraga secara mendalam dan berimbang.</description>
        <language>id</language>
        <lastBuildDate>{{ now()->toRfc2822String() }}</lastBuildDate>
        <atom:link href="{{ route('news.feed') }}" rel="self" type="application/rss+xml" />
        
        @foreach($articles as $article)
        <item>
            <title><![CDATA[{{ $article->title }}]]></title>
            <link>{{ route('news.detail', $article->slug) }}</link>
            <guid isPermaLink="true">{{ route('news.detail', $article->slug) }}</guid>
            <description><![CDATA[{{ $article->excerpt }}]]></description>
            <pubDate>{{ $article->created_at->toRfc2822String() }}</pubDate>
            <author>{{ $article->user ? $article->user->name : \App\Models\Setting::get('site_name', 'NusaKini') . ' Editorial' }}</author>
            <category>{{ $article->category }}</category>
            @if($article->image)
            <enclosure url="{{ asset($article->image) }}" type="image/jpeg" />
            <media:content url="{{ asset($article->image) }}" medium="image" />
            @endif
        </item>
        @endforeach
    </channel>
</rss>
