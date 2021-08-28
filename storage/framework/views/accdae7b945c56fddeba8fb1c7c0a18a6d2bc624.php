<?php $__env->startSection('content'); ?>
    <div class="container " style="background: #F0F3F8;">
        <div class="col-md-12 col-xs-12" style="margin-top: 10px;">
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

        <div>
            <h3>الاعلانات :</h3>
        </div>

        <?php if(count($advs) > 0): ?>
            <?php $__currentLoopData = $advs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $adv): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <a style="color: #000" href="<?php echo e(url('/adv/'.$adv->id)); ?>">
                    <div class="col-md-10 col-md-offset-1 col-xs-12 bg-color-white mb-3">
                        <div class="row">
                            <div class="col-xs-2 p-2">
                                <img style="height: 150px;width: 100%" src="<?php echo e(url($adv->image)); ?>"
                                     class="img-responsive img-rounded" alt="adv image">
                            </div>
                            <div class="col-xs-10">
                                <div class="row">
                                    <div class="col-md-6 col-xs-12"><h3 class="string_limit2" style="margin-top: 10px;">
                                            <a class="btn btn-primary"
                                               href="<?php echo e(url("/notification/create?id=".$adv->id)); ?>"><i
                                                    class="fa fa-bell"></i></a>&nbsp;
                                            <?php echo e($adv->title); ?>

                                        </h3>
                                    </div>
                                    <div class="col-md-6 col-xs-12" style="padding-top: 10px;">
                                        <?php if($adv->agree == 0): ?>
                                            <form
                                                onsubmit="return confirm('هل تريد الموافقة على نشر هذا الإعلان بالفعل ؟');"
                                                action="<?php echo e(url('/adv_confirm/'.$adv->id)); ?>" method="post">
                                                <?php echo e(method_field('PUT')); ?>

                                                <?php echo csrf_field(); ?>
                                                <button class="btn btn-success btn-block col-xs-4 m-1" type="submit">
                                                    <i class="fa fa-check-square-o"></i><span class="hidden-xs">&nbsp; تأكيد النشر</span>
                                                </button>
                                            </form>
                                        <?php endif; ?>

                                        <a href="<?php echo e(url('/adv_action/'.$adv->id.'/edit')); ?>"
                                           class="btn btn-primary btn-block col-xs-4 m-1">
                                            <i class="fa fa-pencil"></i><span class="hidden-xs">&nbsp;&nbsp;تعديل</span>
                                        </a>

                                        <form action="<?php echo e(url('/adv_action/'.$adv->id)); ?>" method="post">
                                            <?php echo e(method_field('DELETE')); ?>

                                            <?php echo csrf_field(); ?>
                                            <button type="button" class="del_ btn btn-danger btn-block col-xs-3 m-1">
                                                <i class="fa fa-trash"></i><span
                                                    class="hidden-xs">&nbsp;&nbsp;حذف</span>
                                            </button>
                                        </form>
                                    </div>
                                    <div class="clearfix">
                                        <hr>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="col-xs-6 small_font" style="float: right">

                                        <div class="">
                                            <label for="">
                                                <i class="fa fa-eye"></i> <span><?php echo e($adv->views.' مشاهدة'); ?></span>
                                            </label>
                                        </div>
                                        <div class="">
                                            <label for="">
                                                <i class="fa fa-map-marker" style="color: black"></i>
                                                <?php if($adv->city): ?>
                                                    <?php echo e(($adv->City->Area) ? $adv->City->Area->name : 'بدون منطقة'); ?>

                                                    <?php echo e(' , '); ?>

                                                    <?php echo e(($adv->City) ? $adv->City->name : 'بدون مدينة'); ?>

                                                <?php else: ?>
                                                    <?php echo e('بدون عنوان'); ?>

                                                <?php endif; ?>
                                            </label>
                                        </div>
                                        <div class="">
                                            <label for="">
                                                <i class="fa fa-hashtag" style="color: black"></i>
                                              كود الاعلان : <?php echo e($adv->id); ?>

                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-xs-6 small_font" style="float: left">
                                        <div class="">
                                            <label for="">
                                                <i class="fa fa-check-circle"></i> منذ <?php echo e($adv->time); ?> يوم
                                            </label>
                                        </div>
                                        <div class="">
                                            <label for="">
                                                <i class="fa fa-user"></i>
                                                <?php echo e($adv->advertiser->name); ?>

                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php else: ?>
            <div class="col-md-12 col-xs-12 text-center"><h3>لا توجد إعلانات حتى الأن ...</h3></div>
        <?php endif; ?>

        <div class="col-md-12 col-xs-12 text-center">
            <?php echo e($advs->onEachSide(1)->appends(Request::capture()->except('page'))->render()); ?>

        </div>

    </div>

    <div class="col-md-12 col-xs-12 clearfix"><br></div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('footer'); ?>
    <script>
        $(function () {
            $('.del_').click(function () {
                if (confirm('هل تريد الحذف بالتأكيد ؟')) {
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