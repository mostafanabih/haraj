<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <?php $__currentLoopData = $main_sections; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $main): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <url>
            <loc><?php echo e(url('/menu/'. $main->name)); ?></loc>
            <lastmod><?php echo e($main->updated_at->tz('UTC')->toAtomString()); ?></lastmod>
            <changefreq>weekly</changefreq>
            <priority>0.6</priority>
        </url>
        <?php $SubSection = \App\SubSection::select('id','name','updated_at')->where('main_id', $main->id)->get(); ?>
       
            <?php if($SubSection): ?>
                <?php $__currentLoopData = $SubSection; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sub): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                   <url>
                    <loc><?php echo e(url('/menu/'. $main->name.'?sub2='.$sub->id.'&name2='.$sub->name)); ?></loc>
                    <lastmod><?php echo e($sub->updated_at->tz('UTC')->toAtomString()); ?></lastmod>
                    <changefreq>weekly</changefreq>
                    <priority>0.6</priority>
                </url>
                 <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</urlset>