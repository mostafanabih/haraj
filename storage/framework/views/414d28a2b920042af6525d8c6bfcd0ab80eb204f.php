<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
        <url>
            <loc><?php echo e(url('/login')); ?></loc>
            <lastmod><?php echo e(Carbon\Carbon::now()); ?></lastmod>
            <changefreq>weekly</changefreq>
            <priority>0.6</priority>
        </url>
          <url>
            <loc><?php echo e(url('/register')); ?></loc>
            <lastmod><?php echo e(Carbon\Carbon::now()); ?></lastmod>
            <changefreq>weekly</changefreq>
            <priority>0.6</priority>
        </url>
          <url>
            <loc><?php echo e(url('/ContactUs')); ?></loc>
            <lastmod><?php echo e(Carbon\Carbon::now()); ?></lastmod>
            <changefreq>weekly</changefreq>
            <priority>0.6</priority>
        </url>
          <url>
            <loc><?php echo e(url('/find_black_list')); ?></loc>
            <lastmod><?php echo e(Carbon\Carbon::now()); ?></lastmod>
            <changefreq>weekly</changefreq>
            <priority>0.6</priority>
        </url>
    <?php $__currentLoopData = $pages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <url>
            <loc><?php echo e(url('/page/'.$page->id)); ?></loc>
            <lastmod><?php echo e($page->updated_at->tz('UTC')->toAtomString()); ?></lastmod>
            <changefreq>weekly</changefreq>
            <priority>0.6</priority>
        </url>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</urlset>