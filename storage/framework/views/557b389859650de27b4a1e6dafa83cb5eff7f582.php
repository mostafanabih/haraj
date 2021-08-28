<?php $__env->startSection('content'); ?>
    <div class="container-fluid " style="background: #F0F3F8;">
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



        <div class="col-sm-12"><h2>تعديل صفحة <span style="color: #ff0000"><?php echo e($page->title); ?></span> :</h2></div>
        <form action="<?php echo e(url('/fixed_pages/'.$page->id)); ?>" method="post" class="form-group">
            <?php echo e(method_field('PUT')); ?>

            <?php echo csrf_field(); ?>
            <div class="col-sm-12">
                <div class="form-group">
                    <label>عنوان الصفحة :</label>
                    <input type="text" name="title" value="<?php echo e($page->title); ?>" class="form-control" placeholder="ضع هنا عنوان الصفحة ..." required>
                </div>
            </div>
            <div class="col-sm-12">
                <div class="form-group">
                    <label>محتوى الصفحة :</label>
                    <textarea id="summernote" name="content_" required><?php echo e($page->content); ?></textarea>
                </div>
            </div>
            <div class="col-sm-12 clearfix"></div>
            <button type="submit" id="my_btn" class="btn btn-primary btn-block"><i class="fa fa-edit"></i>&nbsp;&nbsp;تعديل</button>
        </form>
        <!-- end of content -->


    </div>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('footer'); ?>
    <script>
        $(document).ready(function() {
            $('#summernote').summernote({
                height: 300,                 // set editor height
                minHeight: null,             // set minimum height of editor
                maxHeight: null,             // set maximum height of editor
                focus: true,                // set focus to editable area after initializing summernote
                lang: 'ar-AR'
            });
        });

        $('#my_btn').on('click', function () {
            var summernote_ = $("#summernote").val();
            if(summernote_ == ''){
                alert('يجب أن لا يكون محتوى الصفحة فارغ');
            }else{
            }

        });
    </script>
    </body>
    </html>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dash-header', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>