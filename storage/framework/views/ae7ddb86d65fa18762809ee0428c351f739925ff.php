
<?php $__env->startSection('style'); ?>
    <style>
        /*Copied from bootstrap to handle input file multiple*/
        .btn {
            display: inline-block;
            padding: 6px 12px;
            margin-bottom: 0;
            font-size: 14px;
            font-weight: normal;
            line-height: 1.42857143;
            text-align: center;
            white-space: nowrap;
            vertical-align: middle;
            cursor: pointer;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
            background-image: none;
            border: 1px solid transparent;
            border-radius: 4px;
        }

        /*Also */
        .btn-success {
            border: 1px solid #c5dbec;
            background: #D0E5F5;
            font-weight: bold;
            color: #2e6e9e;
        }

        /* This is copied from https://github.com/blueimp/jQuery-File-Upload/blob/master/css/jquery.fileupload.css */
        .fileinput-button {
            position: relative;
            overflow: hidden;
        }

        .fileinput-button input {
            position: absolute;
            top: 0;
            right: 0;
            margin: 0;
            opacity: 0;
            -ms-filter: 'alpha(opacity=0)';
            font-size: 200px;
            direction: ltr;
            cursor: pointer;
        }

        .thumb {
            height: 80px;
            width: 100px;
            /*border: 1px solid #000;*/
            border-radius: 5px !important;
        }

        ul.thumb-Images li {
            width: 120px;
            float: right;
            display: inline-block;
            vertical-align: top;
            height: 120px;
        }

        .img-wrap {
            position: relative;
            display: inline-block;
            font-size: 0;
            float: right;
        }

        .img-wrap .close {
            position: absolute;
            top: 2px;
            right: 2px;
            z-index: 100;
            background-color: #D0E5F5;
            padding: 5px 2px 2px;
            color: #000;
            font-weight: bolder;
            cursor: pointer;
            opacity: .5;
            font-size: 23px;
            line-height: 10px;
            border-radius: 50%;
        }

        .img-wrap:hover .close {
            opacity: 1;
            background-color: #ff0000;
        }

        .FileNameCaptionStyle {
            font-size: 12px;
        }


    </style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
</section>
<!--End Header-->

<div class="container-fluid padding-r-l-50 my-4">
    <div class="row">
        <!-- start of content -->
        <div class="col-sm-12 bg-color-silver border-all">
            <h3 class="color-silver-darker"><a href="<?php echo e(url('/')); ?>" class="color-silver-darker">الرئيسية</a> / <a href="<?php echo e(url('/add_adv/create')); ?>" class="color-black">اضف اعلان</a></h3>
        </div>
        <div class="col-sm-12">
            <br>
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

        <div class="col-md-12 bg-color-white border-all p-5">
            <form id="my_form" action="<?php echo e(url('/add_adv')); ?>" method="post" enctype="multipart/form-data" class="form-group">
                <?php echo csrf_field(); ?>

                <div class="row">
                    <div class="form-group col-md-10 col-md-offset-1">
                        <h5 class="col-md-2"><i class="fa fa-image"></i>&nbsp;&nbsp;اضف صور الاعلان</h5>
                        <div class="col-md-10">
                            <div>
                                <label class="help-block">يمكنك رفع صور من نوع : png - jpeg - gif</label>
                                <!--To give the control a modern look, I have applied a stylesheet in the parent span.-->
                                <span class="btn btn-success fileinput-button btn-add-image">
                                            <span class="">+</span>
                                            <input type="file" accept="image/*" name="images[]" id="files" multiple ><br/>
                                        </span>
                                <output id="Filelist"></output>
                            </div>
                        </div>
                        
                            
                                
                                    
                                        
                                            
                                        
                                        
                                    
                                
                                
                                    
                                    
                                
                                
                            
                        
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-md-10 col-md-offset-1">
                        <h5 class="col-md-2"><i class="fa fa-link"></i>&nbsp;&nbsp;رابط الفيديو</h5>
                        <input name="link" value="<?php echo e(old('link')); ?>" type="url" class="form-control col-md-10" placeholder="ضع رابط الفيديو هنا ..." >
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-md-10 col-md-offset-1">
                        <h5 class="col-md-2"><i class="fa fa-flag-o"></i>&nbsp;&nbsp;اسم الإعلان</h5>
                        <input name="title" value="<?php echo e(old('title')); ?>" type="text" class="form-control col-md-10" placeholder="ضع اسم إعلانك هنا ..." required>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-md-10 col-md-offset-1">
                        <h5 class="col-md-2"><i class="fa fa-map-marker"></i>&nbsp;&nbsp;منطقة الإعلان</h5>
                        <select class="form-control col-md-5 m-b selectpicker" name="area" id="area" data-live-search="true" required>
                            <option value="">اختر المنطقة</option>
                            <?php $__currentLoopData = $area; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $area_): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($area_->id); ?>" <?php if(old('area') == $area_->id): ?> selected <?php endif; ?>><?php echo e($area_->name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <select class="form-control col-md-4 col-md-push-1 br_ m-b selectpicker" name="city" id="city" data-live-search="true" required title="اختر المدينة">
                           
                            <?php if(old('city')): ?>
                                <?php $__currentLoopData = \App\Http\Controllers\AddAdvController::get_cities(old('area')); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $city): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($city->id); ?>" <?php if(old('city') == $city->id): ?> selected <?php endif; ?>><?php echo e($city->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endif; ?>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-md-10 col-md-offset-1">
                        <h5 class="col-md-2"><i class="fa fa-bookmark"></i>&nbsp;&nbsp;التصنيف الرئيسى</h5>
                        <select class="form-control m-b col-md-10 selectpicker" name="main_section" id="main_section" data-live-search="true" required>
                            <option value="">اختر القسم الرئيسى ...</option>
                            <?php $__currentLoopData = $main_sections; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $main): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($main->id); ?>" <?php if(old('main_section') == $main->id): ?> selected <?php endif; ?>><?php echo e($main->name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-md-10 col-md-offset-1">
                        <h5 class="col-md-2"><i class="fa fa-bookmark-o"></i>&nbsp;&nbsp;التصنيف الفرعى</h5>
                        <select class="form-control col-md-10 selectpicker" name="sub_section" id="sub_section" data-live-search="true" required>
                            <option value="">اختر القسم الفرعى ...</option>
                            <?php if(old('sub_section')): ?>
                                <?php $__currentLoopData = \App\Http\Controllers\AddAdvController::get_sub_sections(old('main_section')); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sub): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($sub->id); ?>" <?php if(old('sub_section') == $sub->id): ?> selected <?php endif; ?>><?php echo e($sub->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endif; ?>
                        </select>
                    </div>
                </div>

                
                <div class="row">
                    <div class="form-group col-md-10 col-md-offset-1">
                        <h5 class="col-md-2"><i class="fa fa-bookmark-o"></i>&nbsp;&nbsp;التصنيف الداخلى</h5>
                        <select class="form-control col-md-10 selectpicker" name="internal_section" id="internal_section" data-live-search="true">
                            <option value="0">اختر القسم الداخلى ...</option>
                            <?php if(old('internal_section')): ?>
                                <?php $__currentLoopData = \App\Http\Controllers\AddAdvController::get_internal_sections(old('sub_section')); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $internal): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($internal->id); ?>" <?php if(old('internal_section') == $internal->id): ?> selected <?php endif; ?>><?php echo e($internal->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endif; ?>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-md-10 col-md-offset-1">
                        <h5 class="col-md-2"></h5>
                        <div class="form-group col-md-10" id="years">
                            <?php if(old('main_section') == 1): ?>
                            <select class="form-control selectpicker" name="car_year" data-live-search="true" required>
                                <option value="">اختر موديل السيارة ...</option>
                                <?php for($y = \Carbon\Carbon::now()->year; $y > 1969; $y--): ?>
                                <option value="<?php echo e($y); ?>" <?php if(old('car_year') == $y): ?> selected <?php endif; ?>><?php echo e($y); ?></option>
                                <?php endfor; ?>
                            </select>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-md-10 col-md-offset-1">
                        <h5 class="col-md-2"><i class="fa fa-mobile"></i>&nbsp;&nbsp;رقم الجوال</h5>
                        <input name="mobile" value="<?php echo e((old('mobile')) ? old('mobile') : \App\Http\Controllers\AdvsController::get_advertiser(auth()->user()->id)->mobile); ?>" type="text" class="col-md-10 form-control" placeholder="ضع رقم جوالك هنا ..." required>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-md-10 col-md-offset-1">
                        <h5 class="col-md-2"><i class="fa fa-map-marker"></i>&nbsp;&nbsp;موقع الاعلان</h5>
                        <input id="autocomplete_search" name="location" value="<?php echo e(old('location')); ?>" type="text"
                               class="form-control col-md-10" placeholder="ابحث هنا عن موقعك ..." >

                        <div class="clearfix"></div>
                        <div class="col-md-10 col-md-push-2">
                            <input readonly class="form-control col-md-5" type="hidden" name="lat" value="<?php echo e(old('lat')); ?>" id="lat"
                                   placeholder="خط الطول هنا ..." >
                            <input readonly class="form-control col-md-5 col-md-push-2" type="hidden" name="lon" value="<?php echo e(old('lon')); ?>" id="long"
                                   placeholder="خط العرض هنا ..." >
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-md-10 col-md-offset-1">
                        <h5 class="col-md-2"><i class="fa fa-file-text-o"></i>&nbsp;&nbsp;التفاصيل</h5>
                        <textarea name="details" rows="5" class="form-control col-md-10" placeholder="نص الإعلان ..."required><?php echo e(old('details')); ?></textarea>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-md-5 col-md-offset-1">
                        <label class="col-md-12 font-large-bold">
                            <input type="checkbox" name="rules1" <?php if(old('rules1') == 1): ?> checked <?php endif; ?> value="1" required>&nbsp;&nbsp;أوافق على جميع <a href="<?php echo e(url('/page/1')); ?>" target="_blank" class="color-gold" style="text-decoration: underline;">الشروط و الأحكام</a>
                        </label>
                        <label class="col-md-12 font-large-bold">
                            <input type="checkbox" name="rules2" <?php if(old('rules2') == 1): ?> checked <?php endif; ?> value="1" required>&nbsp;&nbsp;أوافق على <a href="<?php echo e(url('/page/2')); ?>" target="_blank" class="color-gold" style="text-decoration: underline;">القسم والتعهد لدفع العمولة</a>
                        </label>
                    </div>

                    <div class="form-group col-md-6">
                        <div class="col-md-5"><label>التعليقات على الإعلان</label></div>
                        <div class="col-md-3">
                            <label><input type="radio" class="form-group" name="allow_comment" value="1" checked>&nbsp;مسموح</label>
                        </div>
                        <div class="col-md-4">
                            <label><input type="radio" class="form-group" name="allow_comment" value="0">&nbsp;غير مسموح</label>
                        </div>
                    </div>
                </div>

                <input type="hidden" name="advertiser_id" value="<?php echo e(auth()->user()->id); ?>">
                <input type="hidden" name="all_images" id="all_images">

                <div class="row">
                    <div class="col-md-12 text-center">
                        
                        <a href="javascript:void(0)" class="btn btn-green btn-block col-md-4 col-md-offset-4 col-xs-12"
                           id="my_form_btn"><h5>إنشاء</h5></a>
                    </div>
                </div>
            </form>
        </div>
        <!-- end of content -->
    </div>
</div>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('footer'); ?>
<script>
    $(function() {
// buttom filter
// case 1
        $('#main_section').on('change', function () {
            var main_section_id = $('#main_section option:selected').val();

            $.ajax({
                url: "<?php echo e(url('/bottom_filter1_')); ?>",
                type: "post",
                data: {'main_section_id': main_section_id,
                    '_token': '<?php echo e(csrf_token()); ?>'},
                beforeSend: function () {
                    $(".loading_me").empty().append('<div class="se-pre-con"></div>');
                },
                success: function (data) {
                    $('#sub_section').empty().append(data[0]);
                    $('#internal_section').empty().append(data[1]);
                    $('#years').empty().append(data[2]);
                    $('.selectpicker').selectpicker('refresh');
                },
                complete: function () {
                    $(".loading_me").empty();
                }
            });
        });
// case 2
        $('#sub_section').on('change', function () {
            var main_section_id = $('#main_section option:selected').val();
            var sub_section_id = $('#sub_section option:selected').val();

            $.ajax({
                url: "<?php echo e(url('/bottom_filter2_')); ?>",
                type: "post",
                data: {'main_section_id': main_section_id,
                    'sub_section_id': sub_section_id,
                    '_token': '<?php echo e(csrf_token()); ?>'},
                beforeSend: function () {
                    $(".loading_me").empty().append('<div class="se-pre-con"></div>');
                },
                success: function (data) {
                    $('#sub_section').empty().append(data[0]);
                    $('#internal_section').empty().append(data[1]);
                    $('.selectpicker').selectpicker('refresh');
                },
                complete: function () {
                    $(".loading_me").empty();
                }
            });
        });
// area -> city
        $('#area').on('change', function () {
            var area_id = $('#area option:selected').val();

            $.ajax({
                url: "<?php echo e(url('/bottom_filter3_')); ?>",
                type: "post",
                data: {'area_id': area_id,
                    '_token': '<?php echo e(csrf_token()); ?>'},
                beforeSend: function () {
                    $(".loading_me").empty().append('<div class="se-pre-con"></div>');
                },
                success: function (data) {
                    $('#city').empty().append(data[0]);
                    $('.selectpicker').selectpicker('refresh');
                },
                complete: function () {
                    $(".loading_me").empty();
                }
            });
        });

    });
</script>

<script type="text/javascript">

    //I added event handler for the file upload control to access the files properties.
    document.addEventListener("DOMContentLoaded", init, false);

    //To save an array of attachments
    var AttachmentArray = [];

    //counter for attachment array
    var arrCounter = 0;

    //to make sure the error message for number of files will be shown only one time.
    var filesCounterAlertStatus = false;

    //un ordered list to keep attachments thumbnails
    var ul = document.createElement('ul');
    ul.className = ("thumb-Images");
    ul.id = "imgList";

    function init() {
        //add javascript handlers for the file upload event
        document.querySelector('#files').addEventListener('change', handleFileSelect, false);
    }

    //the handler for file upload event
    function handleFileSelect(e) {
        //to make sure the user select file/files
        if (!e.target.files) return;

        //To obtaine a File reference
        var files = e.target.files;

        // Loop through the FileList and then to render image files as thumbnails.
        for (var i = 0, f; f = files[i]; i++) {

            //instantiate a FileReader object to read its contents into memory
            var fileReader = new FileReader();

            // Closure to capture the file information and apply validation.
            fileReader.onload = (function (readerEvt) {
                return function (e) {

                    //Apply the validation rules for attachments upload
                    ApplyFileValidationRules(readerEvt)

                    //Render attachments thumbnails.
                    RenderThumbnail(e, readerEvt);

                    //Fill the array of attachment
                    FillAttachmentArray(e, readerEvt)
                };
            })(f);

            // Read in the image file as a data URL.
            // readAsDataURL: The result property will contain the file/blob's data encoded as a data URL.
            // More info about Data URI scheme https://en.wikipedia.org/wiki/Data_URI_scheme
            fileReader.readAsDataURL(f);
        }
        document.getElementById('files').addEventListener('change', handleFileSelect, false);
    }

    //To remove attachment once user click on x button
    jQuery(function ($) {
                $('div').on('click', '.img-wrap .close', function () {
                    var id = $(this).closest('.img-wrap').find('img').data('id');

                    //to remove the deleted item from array
                    var elementPos = AttachmentArray.map(function (x) {
                        return x.FileName;
                    }).indexOf(id);
                    if (elementPos !== -1) {
                        AttachmentArray.splice(elementPos, 1);
                    }

                    //to remove image tag
                    $(this).parent().find('img').not().remove();

                    //to remove div tag that contain the image
                    $(this).parent().find('div').not().remove();

                    //to remove div tag that contain caption name
                    $(this).parent().parent().find('div').not().remove();

                    //to remove li tag
                    var lis = document.querySelectorAll('#imgList li');
                    for (var i = 0; li = lis[i]; i++) {
                        if (li.innerHTML == "") {
                            li.parentNode.removeChild(li);
                        }
                    }

                });
            }
    )

    //Apply the validation rules for attachments upload
    function ApplyFileValidationRules(readerEvt) {
        //To check file type according to upload conditions
        if (CheckFileType(readerEvt.type) == false) {
            alert("الملف (" + readerEvt.name + ") لا يتماشى مع شروط الرفع, يمكنك فقط رفع ملفات jpg/png/gif");
            e.preventDefault();
            return;
        }

        //To check file Size according to upload conditions
        // if (CheckFileSize(readerEvt.size) == false) {
        //     alert("The file (" + readerEvt.name + ") does not match the upload conditions, The maximum file size for uploads should not exceed 300 KB");
        //     e.preventDefault();
        //     return;
        // }

        //To check files count according to upload conditions
        if (CheckFilesCount(AttachmentArray) == false) {
            if (!filesCounterAlertStatus) {
                filesCounterAlertStatus = true;
                alert("طبقا لشروط الرفع يمكنك فقط رفع 10 ملفات صور كحد اقصى لا غير");
            }
            e.preventDefault();
            return;
        }
    }

    //To check file type according to upload conditions
    function CheckFileType(fileType) {
        if (fileType == "image/jpeg") {
            return true;
        } else if (fileType == "image/png") {
            return true;
        } else if (fileType == "image/gif") {
            return true;
        } else {
            return false;
        }
        return true;
    }

    //To check file Size according to upload conditions
    function CheckFileSize(fileSize) {
        if (fileSize < 300000) {
            return true;
        } else {
            return false;
        }
        return true;
    }

    //To check files count according to upload conditions
    function CheckFilesCount(AttachmentArray) {
        //Since AttachmentArray.length return the next available index in the array,
        //I have used the loop to get the real length
        var len = 0;
        for (var i = 0; i < AttachmentArray.length; i++) {
            if (AttachmentArray[i] !== undefined) {
                len++;
            }
        }
        //To check the length does not exceed 10 files maximum
        // if (len > 9) {
        //     return false;
        // } else {
        //     return true;
        // }
    }

    //Render attachments thumbnails.
    function RenderThumbnail(e, readerEvt) {
        var li = document.createElement('li');
        ul.appendChild(li);
        li.innerHTML = ['<div class="img-wrap"> <span class="close">&times;</span>' +
        '<img class="thumb" src="', e.target.result, '" title="', escape(readerEvt.name), '" data-id="',
            readerEvt.name, '"/>' + '</div>'].join('');

        var div = document.createElement('div');
        div.className = "FileNameCaptionStyle";
        li.appendChild(div);
//        div.innerHTML = [readerEvt.name].join('');
        document.getElementById('Filelist').insertBefore(ul, null);
    }

    //Fill the array of attachment
    function FillAttachmentArray(e, readerEvt) {
        AttachmentArray[arrCounter] =
        {
            AttachmentType: 1,
            ObjectType: 1,
            FileName: readerEvt.name,
            FileDescription: "Attachment",
            NoteText: "",
            MimeType: readerEvt.type,
            Content: e.target.result.split("base64,")[1],
            FileSizeInBytes: readerEvt.size,
        };
        arrCounter = arrCounter + 1;
    }
</script>


    
        
            
            
            
        
            
        
    

<script>
    $('#my_form_btn').click(function () {
        if (confirm('هل تريد بالفعل نشر الاعلان ؟')) {
            $(this).prop('disabled', true).html('<p class="text-center h4"><i class="fa fa-spinner fa-spin"></i> جاري الحفظ .....</p>');
            var formDataToUpload = new FormData();
            formDataToUpload.append("_token", '<?php echo e(csrf_token()); ?>');

            $.each(AttachmentArray, function (x, file) {
                if(typeof file != "undefined"){
                    formDataToUpload.append("image-" + x, file['Content']);
                }
            });

            $.ajax({
                url: '<?php echo e(url('/get_all_images')); ?>',
                type: 'post',
                contentType: false,
                processData: false,
                cache: false,
                dataType: "json",
                data: formDataToUpload,
                success: function (res) {
//                        console.log(res);
                    $('#all_images').val(res[0]);
                    $('#my_form').submit();
                }
            });
        }
        else {
            return false;
        }
    });
</script>
</body>
</html>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.layouts', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>