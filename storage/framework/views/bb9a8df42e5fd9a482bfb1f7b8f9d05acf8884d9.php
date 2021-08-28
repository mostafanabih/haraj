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


        <div class="col-md-12" style="padding-top: 15px; ">
            <div class="col-md-2 text-center" style="background: #020B10; margin-top: 3px;">
                <label style="color: white; margin-top: 5px; margin-bottom: 0px;">المستخدمين</label>
            </div>
        </div>
        <form>
            <div class="col-md-12 " style="padding-top: 15px; padding-bottom: 10px ; ">
                <div class="col-md-3" style="padding-right: 25px;">
                    <div class="row">
                        <label class="col-md-3">الاسم</label>

                        <div class="col-md-9">
                            <input name="name" value="<?php if(request('name')): ?><?php echo e(request('name')); ?><?php endif; ?>"
                                   class="form-control" type="text" placeholder="ضع الاسم هنا ...">
                        </div>
                    </div>
                </div>
                <div class="col-md-3" style="padding-right: 25px;">
                    <div class="row">
                        <label class="col-md-3">المدينه</label>

                        <div class="col-md-9">
                            <select class="form-control m-b selectpicker" name="city" data-live-search="true" required>
                                <option value="0">كل المدن</option>
                                <?php $__currentLoopData = $citits; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $city): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option <?php if(request('city') == $city->id): ?> selected
                                            <?php endif; ?> value="<?php echo e($city->id); ?>"><?php echo e($city->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-3" style="padding-right: 25px;">
                    <div class="row">
                        <label class="col-md-3">الاشتراك</label>

                        <div class="col-md-9">
                            <select class="form-control m-b selectpicker" name="marked" data-live-search="true"
                                    required>
                                <option <?php if(request('marked') == 0): ?> selected <?php endif; ?> value="0">كل الأعضاء</option>
                                <option <?php if(request('marked') == 1): ?> selected <?php endif; ?> value="1">عضو</option>
                                <option <?php if(request('marked') == 2): ?> selected <?php endif; ?> value="2">مشترك</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="col-md-12 br_" style="padding-right: 15px;">
                        <button class="col-md-12 btn btn-green">
                            <i class="fa fa-search"></i>&nbsp;&nbsp;بحث
                        </button>
                    </div>
                </div>
            </div>
        </form>
        <hr class="-black-tie" style="color: black !important;  background: black;   border: 1px solid black;  ">

        <div class="col-md-12 table-responsive" style="margin-top: 5px;">
            <table class="table table_noborder table-hover table-striped text-center"
                   style="background: white">
                <thead class="text-center" style="background: #6D747A;">
                <th>#</th>
                <th class="text-center" style="color: #D4D7DC;">اسم المستخدم</th>
                <th class="text-center" style="color: #D4D7DC;">رقم الجوال</th>
                <th class="text-center" style="color: #D4D7DC;">حاله الاشتراك</th>
                <th class="text-center" style="color: #D4D7DC;">تاريخ الاشتراك</th>

                <th class="text-center" colspan="6" style="color: #D4D7DC;">الإعدادات</th>
                </thead>
                <tbody>
                <?php if(count($advertisers) > 0): ?>
                    <?php $__currentLoopData = $advertisers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $advertiser): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($loop->iteration); ?></td>
                            <td>
                                <?php if($advertiser->special == 1): ?>
                                    <img src="<?php echo e(asset('public/img/ustar.png')); ?>">&nbsp;&nbsp;
                                <?php endif; ?>
                                <?php echo e($advertiser->name); ?>

                            </td>
                            <td><?php echo e($advertiser->mobile); ?></td>
                            <td>
                                <?php if($advertiser->marked == 0): ?>
                                    <?php echo e('عضو'); ?>

                                <?php else: ?>
                                    <?php echo e('مشترك'); ?>

                                <?php endif; ?>
                            </td>
                            <td><?php if($advertiser->marked != 0): ?> <?php echo e($advertiser->subscription->start_date); ?> <?php else: ?> <?php echo e('لم يشترك حتى الأن'); ?> <?php endif; ?></td>

                            <td>
                                <?php if($advertiser->marked == 0): ?>
                                    <?php if(!$advertiser->subscription): ?>
                                        <a href="<?php echo e(url('/advertisers/'.$advertiser->id)); ?>" class="btn btn-primary"><i
                                                    class="fa fa-reply"></i>&nbsp;&nbsp;تحويل لمشترك</a>
                                    <?php else: ?>
                                    <?php endif; ?>
                                <?php else: ?>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if($advertiser->roles == 1 and $advertiser->type_of_roles == 0): ?>
                                    <a href="<?php echo e(url('/normal_user_convert/'.$advertiser->id)); ?>" class="btn btn-info"><i
                                                class="fa fa-user"></i>&nbsp;&nbsp;تحويل لعضو</a>
                                <?php else: ?>
                                    <a href="<?php echo e(url('/super_user_convert/'.$advertiser->id)); ?>" class="btn btn-success"><i
                                                class="fa fa-star"></i>&nbsp;&nbsp;تحويل لمشرف</a>
                                <?php endif; ?>
                            </td>
                            <td>
                                <form action="<?php echo e(url('/advertisers/'.$advertiser->id)); ?>" method="post">
                                    <?php echo e(method_field('PUT')); ?>

                                    <?php echo csrf_field(); ?>
                                    <?php if($advertiser->special == 1): ?>
                                        <input type="hidden" name="is_special" value="0">
                                        <button type="submit" class="btn btn-default"><i class="fa fa-close"></i>&nbsp;&nbsp;ازالة التمييز
                                        </button>
                                    <?php else: ?>
                                        <input type="hidden" name="is_special" value="1">
                                        <button type="submit" class="btn btn-outline-orange"><img src="<?php echo e(asset('public/img/ustar.png')); ?>">&nbsp;&nbsp;تمييز
                                        </button>
                                    <?php endif; ?>
                                </form>
                            </td>
                            <td>
                                <form action="<?php echo e(url('/advertisers/'.$advertiser->id)); ?>" method="post">
                                    <?php echo e(method_field('PUT')); ?>

                                    <?php echo csrf_field(); ?>
                                    <?php if($advertiser->active_code != null and $advertiser->agree == 1): ?>
                                        <input type="hidden" name="is_active" value="1">
                                        <button type="submit" class="btn btn-success"><i class="fa fa-refresh"></i>&nbsp;&nbsp;تفعيل
                                        </button>
                                    <?php else: ?>
                                    <?php endif; ?>
                                </form>
                            </td>
                            <td>
                                <form action="<?php echo e(url('/advertisers/'.$advertiser->id)); ?>" method="post">
                                    <?php echo e(method_field('PUT')); ?>

                                    <?php echo csrf_field(); ?>
                                    <?php if($advertiser->active_code == null or $advertiser->agree == 1): ?>
                                        <input type="hidden" name="status" value="0">
                                        <button type="submit" class="btn btn-warning"><i class="fa fa-ban"></i>&nbsp;&nbsp;ايقاف
                                        </button>
                                    <?php else: ?>
                                        <input type="hidden" name="status" value="1">
                                        <button type="submit" class="btn btn-info"><i class="fa fa-unlock"></i>&nbsp;&nbsp;رفع
                                            الإيقاف
                                        </button>
                                    <?php endif; ?>
                                </form>
                            </td>
                            <td>
                                <form action="<?php echo e(url('/advertisers/'.$advertiser->id)); ?>" method="post">
                                    <?php echo e(method_field('DELETE')); ?>

                                    <?php echo csrf_field(); ?>
                                    <input type="hidden" name="advertiser_id" value="<?php echo e($advertiser->id); ?>">
                                    <button type="button" class="del_ btn btn-danger"><i class="fa fa-trash"></i>&nbsp;&nbsp;حذف
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php else: ?>
                    <tr>
                        <td colspan="11" class="text-center"><h2>لا توجد بيانات حتى الأن ...</h2></td>
                    </tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!--Pagination -->
        <div class="col-sm-12 text-center">
            <?php echo e($advertisers->onEachSide(1)->appends(Request::capture()->except('page'))->render()); ?>

        </div>

    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('footer'); ?>
    <script>
        $(function () {
            $('.del_').click(function () {
                if (confirm('سوف يتم حذف جميع ما يتعلق بهذا المستخدم ... الاستمرار ؟')) {
                    this.form.submit();
                } else {
                    // Do nothing!
                }

            });
        });
    </script>
    </body>
    </html>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dash-header', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>