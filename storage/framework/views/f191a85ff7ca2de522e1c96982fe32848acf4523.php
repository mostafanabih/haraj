<?php $__env->startSection('content'); ?>
    <div class="container-fluid padding-r-l-50" style="background-color: #F0F3F8">
        <div class="row">
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
        <div class="row">
            <div class="col-md-4 col-xs-12 label label-success" style="font-size: 16px !important;margin-bottom: 10px;margin-top:30px;">
                <div class="row">
                    <div>
                        <label>عدد طلبات الاشتراك </label>
                    </div>
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-4" style="float: right;">
                                <label for="" class="badge"><?php echo e($requests->count()); ?></label>
                            </div>
                            <div class="col-md-4 " style="float: left;">
                                <label for=""> طلب</label>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="col-md-4 col-xs-12 label label-primary" style="font-size: 16px !important;margin-bottom: 10px;margin-top:30px;">
                <div class="row">
                    
                    <div>
                        <label>عدد الاعلانات</label>
                    </div>
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-4" style="float: right;">
                                <label for="" class="badge"><?php echo e($advs); ?></label>
                            </div>
                            <div class="col-md-4 " style="float: left;">
                                <label for=""> اعلان</label>
                            </div>
                        </div>

                        
                    </div>
                </div>

            </div>

            <div class="col-md-4 col-xs-12 label label-info" style="font-size: 16px !important;margin-bottom: 10px;margin-top:30px;">
                <div class="row">
                    
                    <div>
                        <label>عدد الزوار </label>
                    </div>
                    <div class="col-md-12 ">
                        <div class="row">
                            <div class="col-md-4" style="float: right;">
                                <label for="" class="badge"><?php echo e($visits); ?></label>
                            </div>
                            <div class="col-md-4 " style="float: left;">
                                <label for=""> زائر</label>
                            </div>
                        </div>
                    </div>
                    
                </div>

            </div>
        </div>
    </div>
        <div class="col-md-12 col-xs-12" style="margin-top: 30px;">
            <div class="row">
                <div class="col-md-4 col-xs-12 left-cont"
                     style="padding-left: 35px; border-radius: 5px; margin-bottom: 20px;">
                    <div class="row box_one" style="border-bottom:3px solid #2D9AF5 ;">
                        <div class="col-md-12 col-xs-12" style="background-color: #2D9AF5; border-radius: 10px;">
                            <label for="" class="text-center  btn-block col-md-12" style="color: white">اخر طلبات الاشتراك</label>
                        </div>

                        <?php if(\App\Advertiser::can_me(6)): ?>
                            <div class="">
                                
                                <?php if(count($requests_) > 0): ?>
                                    <?php $__currentLoopData = $requests_; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $req): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>  
                                    <?php if($req->package): ?>
                                        <div class="col-md-12 col-xs-12" style=" background-color:#ffffff">
                                            <div class="row">
                                                <div class="col-md-12 col-xs-12 show_details" id="<?php echo e($loop->iteration); ?>">
                                                    <div class="row">
                                                        <div class="col-md-6 col-xs-6 pull-right">
                                                            <label class="col-md-12" for=""><span
                                                                        class="glyphicon glyphicon-triangle-bottom"></span><?php echo e($req->advertiser->name); ?>

                                                            </label>
                                                        </div>
                                                        <div class="col-md-6 col-xs-6 pull-left">
                                                            <div class="col-md-6 col-xs-6">
                                                              
                                                                <form onsubmit="return confirm('هل تريد الموافقة على طلب الاشتراك بالفعل ؟');" action="<?php echo e(url('/add_subscription/'.$req->id)); ?>"
                                                                      method="post" class="form-group">
                                                                    <?php echo e(method_field('PUT')); ?>

                                                                    <?php echo csrf_field(); ?>
                                                                    <input type="hidden" name="duration"
                                                                           value="<?php echo e($req->package->duration); ?>">
                                                                    <input type="hidden" name="advertiser_id"
                                                                           value="<?php echo e($req->advertiser_id); ?>">
                                                                    <button type="submit" class="btn btn-primary"><i
                                                                                class="fa fa-thumbs-up"></i></button>
                                                                </form>
                                                               
                                                            </div>
                                                            <div class="col-md-6 col-xs-6">
                                                                <form onsubmit="return confirm('هل تريد الإلغاء بالفعل؟');" action="<?php echo e(url('/add_subscription/'.$req->id)); ?>"
                                                                      method="post">
                                                                    <?php echo e(method_field('DELETE')); ?>

                                                                    <?php echo csrf_field(); ?>
                                                                    <button type="submit" class="btn btn-danger"><i
                                                                                class="fa fa-trash"></i></button>
                                                                </form>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                                <div class="col-md-12 col-xs-12 hidden p_details" id="<?php echo e('b'.$loop->iteration); ?>">
                                                    <div class="row">
                                                        <div class="col-md-12 col-xs-12">
                                                            <label>تاريخ الطلب :</label>
                                                            <label><?php echo e(date('Y-m-d', strtotime($req->updated_at))); ?></label>
                                                        </div>
                                                        <div class="col-md-12 col-xs-12">
                                                            <label>الباقة :</label>
                                                            <label><?php echo e($req->package->name ?? ''); ?></label>
                                                        </div>
                                                        
                                                            
                                                        
                                                    </div>
                                                    <hr>
                                                </div>
                                            </div>
                                        </div>
                                         <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php else: ?>
                                    <div class="col-md-12 col-xs-12 text-center" style="background: white; "><h3>لا توجد طلبات حتى الأن ...</h3></div>
                                <?php endif; ?>
                                
                            </div>
                        <?php else: ?>
                            <div class="col-xs-12 text-center">
                                <h3>ليس لديك صلاحية طلبات الإشتراك ...</h3>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="col-md-8 col-xs-12 last-cont"
                     style="padding-right: 25px; border-radius: 5px;   margin-bottom: 20px; ">
                    <div class="row box_two" style="border-bottom:3px solid #2D9AF5 ; background: white;">
                        <div class="col-md-12 col-xs-12" style="background-color: #2D9AF5; border-radius: 10px;">
                            <label for="" class="text-center  btn-block col-md-12 col-xs-12" style="color: white">اخر
                                الاعلانات</label>
                        </div>

                        <?php if(\App\Advertiser::can_me(1)): ?>
                            <div class="col-md-12 col-xs-12">
                                <?php if(count($advs_) > 0): ?>
                                    <?php $__currentLoopData = $advs_; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $adv): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <a style="color: #000" href="<?php echo e(url('/adv/'.$adv->id)); ?>">
                                            <div class="col-md-10 col-md-offset-1 col-xs-12">
                                                <div class="row">
                                                    <div class="col-md-3 col-xs-3" style="padding: 10px;">
                                                        <img src="<?php echo e(asset($adv->image)); ?>" class="small_img img-responsive img-rounded" alt="image">
                                                    </div>
                                                    <div class="col-md-9 col-xs-9" >
                                                        <div class="row">
                                                            <div class="col-md-7 col-xs-12">
                                                                <h3 class="string_limit2" style="margin-top: 10px;"><?php echo e($adv->title); ?></h3>
                                                            </div>
                                                            <div class="col-md-5 col-xs-12 pt-3">
                                                                <a href="<?php echo e(url('/adv_action/'.$adv->id.'/edit')); ?>"
                                                                   class="btn btn-primary pull-left"><i class="fa fa-pencil"></i>&nbsp;&nbsp;تعديل</a>

                                                                <form action="<?php echo e(url('/adv_action/'.$adv->id)); ?>" method="post">
                                                                    <?php echo e(method_field('DELETE')); ?>

                                                                    <?php echo csrf_field(); ?>
                                                                    <button type="button" class="del_ btn btn-danger"><i
                                                                                class="fa fa-trash"></i>&nbsp;&nbsp;حذف
                                                                    </button>
                                                                </form>
                                                            </div>
                                                            <div class="col-md-12 col-xs-12">
                                                                <hr>
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-6 small_font">
                                                            <div class="">
                                                                <?php if($adv->agree == 0): ?>
                                                                    <form onsubmit="return confirm('هل تريد الموافقة على نشر هذا الإعلان بالفعل ؟');" action="<?php echo e(url('/adv_confirm/'.$adv->id)); ?>" method="post">
                                                                        <?php echo e(method_field('PUT')); ?>

                                                                        <?php echo csrf_field(); ?>
                                                                        <button class="btn btn-success pt-1 pb-1" type="submit">
                                                                            <i class="fa fa-check-square-o"></i><span class="hidden-xs">&nbsp; تأكيد النشر</span>
                                                                        </button>
                                                                    </form>
                                                                    <?php else: ?>
                                                                    <label for="">
                                                                        <i class="fa fa-eye"></i> <span><?php echo e($adv->views.' مشاهدة'); ?></span>
                                                                    </label>
                                                                <?php endif; ?>
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
                                                        </div>
                                                        <div class="col-xs-6 small_font">
                                                            <div class="">
                                                                <label for="">
                                                                    <i class="fa fa-check-circle"></i> منذ <?php echo e($adv->time); ?>

                                                                    يوم
                                                                </label>
                                                            </div>
                                                            <div class="">
                                                                <label class="string_limit" for="">
                                                                    <i class="fa fa-user"></i>
                                                                    <?php echo e($adv->advertiser->name); ?>

                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                        <div class="col-md-12 col-xs-12">
                                            <hr style="height: 1px;background-color: #000B11">
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php else: ?>
                                    <div class="col-md-12 col-xs-12 text-center"><h3>لا توجد إعلانات حتى الأن ...</h3></div>
                                <?php endif; ?>
                            </div>
                        <?php else: ?>
                            <div class="col-xs-12 text-center">
                                <h3>ليس لديك صلاحية الإعلانات ...</h3>
                            </div>
                        <?php endif; ?>

                    </div>
                </div>

            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('footer'); ?>
    <script>
        $(document).on('click', ".show_details", function () {
            var id = $(this).attr('id');
            $(".p_details").addClass('hidden');

            $("#b" + id).removeClass('hidden');
        });

//        $(document).ready(function () {
//            var hBox = $(".box_one").height();
//            var hBox2 = $(".box_two").height();
//            if (hBox > hBox2) {
//                $(".box_two").css("height", hBox + 3 + "px");
//            } else {
//                $(".box_one").css("height", hBox2 + 3 + "px");
//            }
//        });


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