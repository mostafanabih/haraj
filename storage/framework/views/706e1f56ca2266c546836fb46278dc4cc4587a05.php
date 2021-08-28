<?php $__env->startSection('content'); ?>
</section>
<!--End Header-->



<div class="container-fluid padding-r-l-50 pt-3">
    <div class="row">
        <!-- start of content -->
        <div class="col-xs-12">
            <ul>
                <?php if(count(\App\Http\Controllers\AdvsController::get_menus()) > 0): ?>
                    <?php $__currentLoopData = \App\Http\Controllers\AdvsController::get_menus(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $main_section): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li>
                            <a class="color-gold" href="<?php echo e(url('/?search=&city=0&main_section='.$main_section->id)); ?>">
                                <h4><?php echo e($main_section->name); ?></h4>
                            </a>
                        </li>
                        <ul>
                            <?php if(count(\App\Http\Controllers\AdvsController::get_menus_sub($main_section->id)) > 0): ?>
                                <?php $__currentLoopData = \App\Http\Controllers\AdvsController::get_menus_sub($main_section->id); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sub_section): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li>
                                        <a class="color-green" href="<?php echo e(url('/?search=&city=0&main_section='.$main_section->id.'&sub_section='.$sub_section->id)); ?>">
                                            <h4><?php echo e($sub_section->name); ?></h4>
                                        </a>
                                    </li>
                                    <ul>
                                        <?php if(count(\App\Http\Controllers\AdvsController::get_menus_internal($main_section->id, $sub_section->id)) > 0): ?>
                                            <?php $__currentLoopData = \App\Http\Controllers\AdvsController::get_menus_internal($main_section->id, $sub_section->id); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $internal_section): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <li>
                                                    <a class="color-silver-darker2" href="<?php echo e(url('/?search=&city=0&main_section='.$main_section->id.'&sub_section='.$sub_section->id.'&internal_section='.$internal_section->id)); ?>">
                                                        <h4><?php echo e($internal_section->name); ?></h4>
                                                    </a>
                                                </li>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php endif; ?>
                                    </ul>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endif; ?>
                        </ul>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>
            </ul>
        </div>
        <!-- end of content -->
    </div>
</div>


<?php $__env->stopSection(); ?>

<?php $__env->startSection('footer'); ?>
<script></script>
</body>
</html>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.layouts', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>