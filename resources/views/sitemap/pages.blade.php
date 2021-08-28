<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
        <url>
            <loc>{{ url('/login') }}</loc>
            <lastmod>{{ Carbon\Carbon::now() }}</lastmod>
            <changefreq>weekly</changefreq>
            <priority>0.6</priority>
        </url>
          <url>
            <loc>{{ url('/register') }}</loc>
            <lastmod>{{ Carbon\Carbon::now() }}</lastmod>
            <changefreq>weekly</changefreq>
            <priority>0.6</priority>
        </url>
          <url>
            <loc>{{ url('/ContactUs') }}</loc>
            <lastmod>{{ Carbon\Carbon::now() }}</lastmod>
            <changefreq>weekly</changefreq>
            <priority>0.6</priority>
        </url>
          <url>
            <loc>{{ url('/find_black_list') }}</loc>
            <lastmod>{{ Carbon\Carbon::now() }}</lastmod>
            <changefreq>weekly</changefreq>
            <priority>0.6</priority>
        </url>
    @foreach ($pages as $page)
        <url>
            <loc>{{ url('/page/'.$page->id) }}</loc>
            <lastmod>{{ $page->updated_at->tz('UTC')->toAtomString() }}</lastmod>
            <changefreq>weekly</changefreq>
            <priority>0.6</priority>
        </url>
    @endforeach
</urlset>