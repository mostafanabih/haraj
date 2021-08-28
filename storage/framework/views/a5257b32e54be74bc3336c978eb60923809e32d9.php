<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <sitemap>
      <loc><?php echo e(url('/sitemap-pages.xml')); ?></loc>
      <lastmod><?php echo e(Carbon\Carbon::now()); ?></lastmod>
   </sitemap>
    <sitemap>
      <loc><?php echo e(url('/sitemap-categories.xml')); ?></loc>
      <lastmod><?php echo e(Carbon\Carbon::now()); ?></lastmod>
   </sitemap>
   <sitemap>
      <loc><?php echo e(url('/sitemap-advertisers.xml')); ?></loc>
      <lastmod><?php echo e(Carbon\Carbon::now()); ?></lastmod>
   </sitemap>
   <?php for($i = 1; $i <= $advcount; $i++): ?>
   <sitemap>
      <loc><?php echo e(url('/sitemap-posts'.$i.'.xml')); ?></loc>
      <lastmod><?php echo e(Carbon\Carbon::now()); ?></lastmod>
   </sitemap>
    <?php endfor; ?>
  
</sitemapindex>
