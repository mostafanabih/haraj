<?php $__env->startSection('content'); ?>
    <div class="container-fluid padding-r-l-50 " style="background: #F0F3F8;">
        <div class="col-md-12 " style="margin-top: 10px;">
            <?php if(session('error')): ?>
                <div class="flash alert alert-danger" align="center" role="alert"><?php echo e(session('error')); ?></div>
            <?php endif; ?>
            <?php if(session('success')): ?>
                <div class="flash alert alert-success" align="center" role="alert"><?php echo e(session('success')); ?></div>
            <?php endif; ?>
            <?php if($errors->any()): ?>
                <div class="text-center alert alert-danger">
                    <ul class="list-unstyled">
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><?php echo e($error); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            <?php endif; ?>
        </div>


        <div class="col-sm-3 pull-left">
            <a href="<?php echo e(url('/cities/create')); ?>" type="button" class="btn btn-primary btn-block">
                <i class="fa fa-plus"></i>&nbsp;اضافة مدينة</a>
        </div>
        <!-- start of content -->
        <div class="col-sm-12"><h2>المدن :</h2></div>
        <div class="col-sm-12">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                    <tr class="text-center">
                        <th>#</th>
                        <th>اسم المدينة</th>
                        <th>اسم المنطقة</th>
                        <th>الإعدادات</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if(count($cities) > 0): ?>
                        <?php for($i=0;$i<$cities->count();$i++): ?>
                            <tr>
                                <td><?php echo e($i+1); ?></td>
                                <td><?php echo e($cities[$i]->name); ?></td>
                                <td><?php echo e($cities[$i]->Area->name); ?></td>
                                <td>
                                    <a style="margin-left: 25px" href="<?php echo e(url('/cities/'.$cities[$i]->id.'/edit')); ?>" class="btn btn-info pull-right"><i class="fa fa-pencil"></i>&nbsp;&nbsp; تعديل</a>
                                    <form onsubmit="return confirm('سوف يتم حذف جميع المعلنين والإعلانات المرتبطين بهذه المدينة ... هل تريد الحذف بالفعل ؟');" action="<?php echo e(url('/cities/'.$cities[$i]->id)); ?>" method="post">
                                        <?php echo e(method_field('DELETE')); ?>

                                        <?php echo csrf_field(); ?>
                                        <button type="submit" class="btn btn-danger"><i class="fa fa-trash"></i>&nbsp;&nbsp;حذف</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endfor; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="3" class="text-center"><h2>لا توجد بيانات حتى الأن ...</h2></td>
                        </tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <!--Pagination -->
        <div class="col-sm-12 text-center">
            <?php echo e($cities->onEachSide(1)->appends(Request::capture()->except('page'))->render()); ?>

        </div>
        <!--End Pagination-->

    </div>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('footer'); ?>
    <script></script>
    </body>
    </html>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dash-header', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>