<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <sitemap>
      <loc>{{ url('/sitemap-pages.xml') }}</loc>
      <lastmod>{{ Carbon\Carbon::now() }}</lastmod>
   </sitemap>
    <sitemap>
      <loc>{{ url('/sitemap-categories.xml') }}</loc>
      <lastmod>{{ Carbon\Carbon::now() }}</lastmod>
   </sitemap>
   <sitemap>
      <loc>{{ url('/sitemap-advertisers.xml') }}</loc>
      <lastmod>{{ Carbon\Carbon::now() }}</lastmod>
   </sitemap>
   @for($i = 1; $i <= $advcount; $i++)
   <sitemap>
      <loc>{{ url('/sitemap-posts'.$i.'.xml') }}</loc>
      <lastmod>{{ Carbon\Carbon::now() }}</lastmod>
   </sitemap>
    @endfor
  
</sitemapindex>
