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

        <!-- start of content -->
        <div class="col-md-12" style="padding-top: 15px; ">
            <div class="col-md-2 text-center">
                <h3>المشرفين : </h3>
            </div>
            <div class="col-md-3 col-md-push-7 text-center">
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-success btn-block" data-toggle="modal" data-target="#myModal1">
                    <i class="fa fa-user-plus"></i>&nbsp;&nbsp;<span style="font-size: large">إضافة مشرف</span>
                </button>
            </div>
        </div>


        <!-- Modal -->
        <div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title" id="exampleModalLongTitle">إضافة مشرف جديد : </h3>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <form action="<?php echo e(route('RegisterByAdmin')); ?>" method="post" class="form-group">
                                <?php echo csrf_field(); ?><div class="col-md-1 col-xs-2"><i class="fa fa-user fa-2x"></i></div>
                                <div class="col-md-11 col-xs-10">
                                    <input name="name" value="<?php echo e(old('name')); ?>" type="text" class="form-control" placeholder="اسم المستخدم" required>
                                </div>
                                <div class="col-md-12 col-xs-12 clearfix"><br></div>

                                <div class="col-md-1 col-xs-2"><i class="fa fa-mobile fa-2x"></i></div>
                                <div class="col-md-11 col-xs-10">
                                    <input name="mobile" value="<?php echo e(old('mobile')); ?>" type="number" class="form-control" placeholder="الجوال" required>
                                </div>
                                <div class="col-md-12 col-xs-12 clearfix"><br></div>

                                <div class="col-md-1 col-xs-2"><i class="fa fa-envelope fa-2x"></i></div>
                                <div class="col-md-11 col-xs-10">
                                    <input name="e_mail" value="<?php echo e(old('e_mail')); ?>" type="email" class="form-control" placeholder="البريد الإلكترونى" >
                                </div>
                                <div class="col-md-12 col-xs-12 clearfix"><br></div>

                                <div class="col-md-1 col-xs-2"><i class="fa fa-map-marker fa-2x"></i></div>
                                <div class="col-md-11 col-xs-10">
                                    <input name="address" value="<?php echo e(old('address')); ?>" type="text" class="form-control" placeholder="العنوان" required>
                                </div>
                                <div class="col-md-12 col-xs-12 clearfix"><br></div>

                                <div class="col-md-1 col-xs-2"><i class="fa fa-lock fa-2x"></i></div>
                                <div class="col-md-11 col-xs-10">
                                    <input name="pass" type="password" class="form-control" placeholder="كلمة المرور" required>
                                </div>
                                <div class="col-md-12 col-xs-12 clearfix"><br></div>

                                <div class="col-md-1 col-xs-2"><i class="fa fa-lock fa-2x"></i></div>
                                <div class="col-md-11 col-xs-10">
                                    <input name="pass_confirmation" type="password" class="form-control" placeholder="إعادة كلمة المرور" required>
                                </div>
                                <div class="col-md-12 col-xs-12 clearfix"><br></div>

                                <input type="hidden" name="admin" value="1">
                                <div class="col-md-6 col-md-offset-3">
                                    <button type="submit" class="btn btn-green_1 btn-block"><h4>إنشاء</h4></button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">غلق</button>
                    </div>
                </div>
            </div>
        </div>


        <div class="col-sm-12">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                    <tr class="text-center">
                        <th>#</th>
                        
                        <th>الاسم</th>
                        <th>الجوال</th>
                        <th>البريد الالكترونى</th>
                        <th>الصلاحيات</th>
                        <th>الإعدادات</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if(count($admins) > 0): ?>
                        <?php for($i=0;$i<$admins->count();$i++): ?>
                            <tr>
                                <td><?php echo e($i+1); ?></td>
                                
                                <td><?php echo e($admins[$i]->name); ?></td>
                                <td><?php echo e($admins[$i]->mobile); ?></td>
                                <td><?php echo e($admins[$i]->e_mail ?? 'لا يوجد بريد إلكترونى حتى الأن'); ?></td>
                                <td>
                                    <?php if(\App\Http\Controllers\PermissionsController::get_permissions($admins[$i]->id)->count() > 0): ?>
                                        <?php $__currentLoopData = \App\Http\Controllers\PermissionsController::get_permissions($admins[$i]->id); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $permission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <label class="p-3 ml-4 bg-primary border-r-50"><?php echo e($permission->Permission->name); ?></label>
                                            <?php if(($k+1) % 4 == 0): ?>
                                                <br>
                                            <?php endif; ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php else: ?>
                                        <?php echo e('ليس لديه صلاحيات حتى الأن'); ?>

                                    <?php endif; ?>
                                </td>
                                <td>
                                    <a href="<?php echo e(url('/permissions/'.$admins[$i]->id.'/edit')); ?>" class="btn btn-info pull-right"><i class="fa fa-pencil"></i>&nbsp;&nbsp; تعديل الصلاحيات</a>
                                </td>
                            </tr>
                        <?php endfor; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center"><h2>لا توجد بيانات حتى الأن ...</h2></td>
                        </tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <!--Pagination -->
        <div class="col-sm-12 text-center">
            <?php echo e($admins->onEachSide(1)->appends(Request::capture()->except('page'))->render()); ?>

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