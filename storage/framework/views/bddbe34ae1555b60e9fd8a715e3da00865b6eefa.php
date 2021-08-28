<style>

</style>
<?php $__env->startSection('content'); ?>
    <div class="container-fluid padding-r-l-50 " style="background: #F0F3F8;">
        <div class="col-md-12" style="margin-top: 10px;">
            <?php if(count($errors) > 0): ?>
                <div class="alert alert-danger text-center">
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($error); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            <?php endif; ?>
            <?php if(session()->has('success')): ?>
                <p class="alert alert-success text-center"><?php echo e(session('success')); ?></p>
            <?php endif; ?>
            <?php if(session()->has('error')): ?>
                <p class="alert alert-danger text-center"><?php echo e(session('error')); ?></p>
            <?php endif; ?>
        </div>
        <div class="col-md-12 " style="margin-top: 10px;">
            <div class="col-md-2">
                <h3>الاقسام الرئيسيه</h3>
            </div>
            <div class="col-md-2 col-md-push-8">
                <a href="<?php echo e(route('add-main-section')); ?>" class="btn btn-green "><i class="fa fa-plus"></i>&nbsp;&nbsp; إضافه قسم رئيسى</a>
            </div>
        </div>

        <div class="col-md-8 col-md-offset-2" style="margin-top: 10px; background: white;">
            <table class="table table-striped table-hover table-responsive">
                <thead>
                <th>#</th>
                <th>القسم</th>
                <th>تعديل</th>
                <th>الاقسام الفرعيه</th>
                <th>حذف</th>
                </thead>
                <tbody>
                <?php if(count($m_sections) > 0): ?>
                <?php $__currentLoopData = $m_sections; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m_section): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($loop->iteration); ?></td>
                        <td><?php echo e($m_section->name); ?></td>
                        <td><a href="<?php echo e(url('/edit-main-section/'.$m_section->id)); ?>" class="btn btn-info "> تعديل</a></td>
                        <td><a href="<?php echo e(url('/sub-sections/'.$m_section->id)); ?>" class="btn btn-orange "> عرض</a></td>
                        <td>
                            <?php if($m_section->id == 1): ?>
                                <?php else: ?>
                                <form onsubmit="return confirm('سيتم حذف جميع الإعلانات المرتبطة بهذا القسم ... هل تريد الحذف بالتأكيد؟');" action="<?php echo e(url('/main-section-delete/'.$m_section->id)); ?>" method="post">
                                    <?php echo e(method_field('DELETE')); ?>

                                    <?php echo csrf_field(); ?>
                                    <button type="submit" class="btn btn-danger"> حذف</button>
                                </form>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4">
                            <div class="col-md-12 text-center"><h3>لا توجد أقسام حتى الأن ...</h3></div>
                        </td>
                    </tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>

        <div class="col-sm-12 text-center">
            <?php echo e($m_sections->onEachSide(1)->appends(Request::capture()->except('page'))->render()); ?>

        </div>

    </div>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('footer'); ?>
    <script></script>
    </body>
    </html>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dash-header', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>