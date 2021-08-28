<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <?php $__currentLoopData = $Advs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $adv): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <url>
            <loc><?php echo e(url('/adv/'. $adv->id)); ?></loc>
            <lastmod><?php echo e($adv->updated_at->tz('UTC')->toAtomString()); ?></lastmod>
            <changefreq>daily</changefreq>
            <priority>0.6</priority>
        </url>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</urlset>