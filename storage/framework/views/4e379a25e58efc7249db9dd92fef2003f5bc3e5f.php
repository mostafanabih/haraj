<?php $__env->startSection('content'); ?>
</section>
<!--End Header-->

<div class="container my-4">
    <div class="row">
        <div class="col-sm-12">
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
        <div class="col-xs-12 bg-color-silver border-all">
            <h3 class="color-silver-darker"><a href="<?php echo e(url('/')); ?>" class="color-silver-darker">الرئيسية</a> / <a href="<?php echo e(url('/ContactUs')); ?>" class="color-black">اتصل بنا</a></h3>
        </div>

        <div class="col-md-12 col-xs-12 bg-color-silver mt-3 p-3">
            <div class="col-md-6 col-xs-12">
                <div class="col-md-12 col-xs-12 bg-color-orange color-light-blue">
                    <h3>اتصل بنا</h3>
                </div>
                <div class="col-md-12 col-xs-12 bg-color-white">
                    <div class="m-4 border-all text-center">
                        <ul class="list-inline list-unstyled">
                            <li>
                                <img alt="logo" src="<?php if(is_null($info->logo)): ?> <?php echo e(asset('public/img/logo.png')); ?> <?php else: ?> <?php echo e(asset('public/img/'.$info->logo)); ?> <?php endif; ?>">
                            </li>
                            <li class="">
                                <h3 class="color-gold">حراج واحد</h3>
                                <h5 class="color-gold">كل المطلوب بين يديك</h5>
                            </li>
                        </ul>
                    </div>

                    <div class="pt-4 m-4">
                        <h4 class="color-gold pb-4 border-bottom">العنوان : <span class="color-black"><?php echo e($info->address); ?></span></h4>
                        <h4 class="color-gold pb-4 pt-4 border-bottom">الهاتف : <span class="color-black"><?php echo e($info->mobile); ?></span></h4>
                        <h4 class="color-gold pb-4 pt-4 border-bottom">فاكس : <span class="color-black"><?php echo e($info->fax); ?></span></h4>
                        <h4 class="color-gold pt-4">البريد : <span class="color-black"><?php echo e($info->e_mail); ?></span></h4>
                        
                        
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-xs-12">
                <div class="col-md-12 col-xs-12 bg-color-orange color-light-blue">
                    <h3>تواصل معنا</h3>
                </div>
                <div class="col-md-12 col-xs-12 bg-color-white p-4">
                    <form action="<?php echo e(route('ContactUsSend')); ?>" method="post" class="form-group">
                        <?php echo csrf_field(); ?>
                        <div class="col-xs-12"><input type="text" name="name" class="form-control input-lg mb-4" placeholder="الاسم ..." required></div>
                        <div class="col-xs-12"><input type="email" name="e_mail" class="form-control input-lg mb-4" placeholder="البريد الإلكترونى ..." required></div>
                        <div class="col-xs-12"><input type="tel" name="mobile" class="form-control input-lg mb-4" placeholder="الهاتف ..." required></div>
                        

                        <div class="col-xs-12"><textarea rows="6" name="msg" class="form-control input-lg mb-5" placeholder="ادخل نص الرسالة هنا ..." required></textarea></div>

                        <div class="col-xs-12">
                            <button type="submit" class="btn btn-orange btn-block border-r-0">إرسال</button>
                        </div>
                    </form>
                </div>
            </div>
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