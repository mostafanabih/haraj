<style>

</style>
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
        <div class="col-md-12 " style="margin-top: 10px;">
            <h3>طلبات الاشتراك</h3>
        </div>
        <div class="col-md-12 table-responsive" style="margin-top: 5px;">
            <table class="table table_noborder table-hover table-striped" style="background: white">
                <thead>
                <tr>
                    <th>#</th>
                    <th>الاسم</th>
                    <th>تاريخ الطلب</th>
                    <th>الباقة</th>
                    <th colspan="2">الاعدادات</th>
                </tr>
                </thead>
                <tbody>
                <?php if(count($requests) > 0): ?>
                    <?php $__currentLoopData = $requests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $req): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    
                    
                    <?php if($req->package): ?>
                        <tr>
                            <td><?php echo e($loop->iteration); ?></td>
                            <td><?php echo e($req->Advertiser->name); ?></td>
                            <td><?php echo e(\Carbon\Carbon::parse($req->updated_at)->format('d/m/Y')); ?></td>
                            <td><?php echo e($req->package->name.' ('.$req->package->duration.' شهر '.' > '.$req->package->price.' $ )'); ?></td>
                            <td>
                                <form action="<?php echo e(url('/add_subscription/'.$req->id)); ?>" method="post"
                                      class="form-group">
                                    <?php echo e(method_field('PUT')); ?>

                                    <?php echo csrf_field(); ?>
                                    <input type="hidden" name="duration" value="<?php echo e($req->package->duration); ?>">
                                    <input type="hidden" name="advertiser_id" value="<?php echo e($req->advertiser_id); ?>">
                                    <button type="submit" class="btn btn-primary btn-block"><i
                                                class="fa fa-thumbs-up"></i>&nbsp;&nbsp;موافق
                                    </button>
                                </form>
                            </td>
                            <td style="color: #FB6575">
                                <form onsubmit="return confirm('هل تريد الإلغاء بالفعل؟');" action="<?php echo e(url('/add_subscription/'.$req->id)); ?>" method="post">
                                    <?php echo e(method_field('DELETE')); ?>

                                    <?php echo csrf_field(); ?>
                                    <button type="submit" class="btn btn-danger"><i class="fa fa-trash"></i>&nbsp;&nbsp;الغاء
                                    </button>
                                </form>
                            </td>
                        </tr>
                        
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="text-center"><h2>لا توجد طلبات اشتراك حتى أن ...</h2></td>
                    </tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!--Pagination -->
        <div class="col-sm-12 text-center">
            <?php echo e($requests->onEachSide(1)->appends(Request::capture()->except('page'))->render()); ?>

        </div>

    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('footer'); ?>
    <script></script>
    </body>
    </html>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dash-header', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>