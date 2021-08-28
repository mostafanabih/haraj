<?php $__env->startSection('content'); ?>
</section>
<!--End Header-->

<div class="container-fluid padding-r-l-50 my-4">
    <div class="row">
        <?php if(session('error')): ?>
            <div class="flash alert alert-danger" align="center" role="alert"><?php echo e(session('error')); ?></div>
        <?php endif; ?>
        <?php if(session('success')): ?>
            <div class="flash alert alert-success" align="center" role="alert"><?php echo e(session('success')); ?></div>
        <?php endif; ?>

        <!-- start of content -->
        <div class="col-sm-12"><h2>رسائل التواصل معنا :</h2></div>
        <div class="col-sm-12">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                    <tr class="text-center">
                        <th>#</th>
                        <th>التاريخ</th>
                        <th>الاسم</th>
                        <th>الهاتف</th>
                        <th>البريد الإلكترونى</th>
                        
                        <th colspan="2" class="text-center">الإعدادات</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if(count($contact_us) > 0): ?>
                    <?php for($i=0;$i<$contact_us->count();$i++): ?>
                        <tr>
                            <td><?php echo e($i+1); ?></td>
                            <td><?php echo e(Carbon\Carbon::parse($contact_us[$i]->created_at)->format('Y-m-d >> h:i A')); ?></td>
                            <td><?php echo e($contact_us[$i]->name); ?></td>
                            <td><?php echo e($contact_us[$i]->mobile); ?></td>
                            <td><?php echo e($contact_us[$i]->e_mail); ?></td>
                            
                            <td>
                                <a href="<?php echo e(url('/contact_us/'.$contact_us[$i]->id)); ?>" type="button" class="btn btn-info"><i class="fa fa-eye"></i>&nbsp;&nbsp;رؤية الرسالة</a>
                            </td>
                            <td>
                                <form onsubmit="return confirm('هل تريد الحذف بالفعل ؟');" action="<?php echo e(url('/contact_us/'.$contact_us[$i]->id)); ?>" method="post">
                                    <?php echo e(method_field('DELETE')); ?>

                                    <?php echo csrf_field(); ?>
                                    <button type="submit" class="btn btn-danger"><i class="fa fa-trash"></i>&nbsp;&nbsp;حذف</button>
                                </form>
                            </td>
                        </tr>
                    <?php endfor; ?>
                        <?php else: ?>
                        <tr>
                            <td colspan="7">
                                <div class="text-center">
                                    <h2>لا توجد رسائل حتى الأن ...</h2>
                                </div>
                            </td>
                        </tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <!--Pagination -->
        <div class="col-sm-12 text-center">
            <?php echo e($contact_us->onEachSide(1)->appends(Request::capture()->except('page'))->render()); ?>

        </div>
        <!--End Pagination-->
        <!-- end of content -->
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('footer'); ?>
    <script type="text/javascript"></script>
    </body>
    </html>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.dash-header', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>