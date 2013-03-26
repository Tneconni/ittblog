<?php
$url = $this->createUrl('attachment/upload');
?>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/swfupload/swfupload.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/swfupload/swfupload.queue.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/swfupload/fileprogress.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/swfupload/handlers.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/swfupload/upload.css"/>


<script type="text/javascript">
    var upload;
    $(function () {
        upload = new SWFUpload({

            // Backend Settings
            upload_url:"<?php echo $url; ?>",
            post_params:{"PHPSESSID":"<?php echo session_id(); ?>"},
            file_post_name:"Filedata",

            // File Upload Settings
            file_size_limit:"10240", // 10MB
            file_types:"*.png;*.jpg;*.git;",
            file_types_description:"File Type",
            file_upload_limit:"100",
            file_queue_limit:"0",

            // Event Handler Settings (all my handlers are in the Handler.js file)
            file_dialog_start_handler:fileDialogStart,
            file_queued_handler:fileQueued,
            file_queue_error_handler:fileQueueError,
            file_dialog_complete_handler:fileDialogComplete,
            upload_start_handler:uploadStart,
            upload_progress_handler:uploadProgress,
            upload_error_handler:uploadError,
            upload_success_handler:myUploadSuccess,
            upload_complete_handler:uploadComplete,

            // Button Settings
            button_image_url:"<?php echo Yii::app()->request->baseUrl; ?>/swfupload/XPButtonNoText_61x22.png",
            button_placeholder_id:"spanButtonPlaceholder",
            button_height:true,
            button_text:'浏览',
            button_width:61,
            button_height:22,
            button_text_left_padding: 18,

            // Flash Settings
            flash_url:"<?php echo Yii::app()->request->baseUrl; ?>/swfupload/swfupload.swf",
            custom_settings:{
                progressTarget:"fsUploadProgress",
                cancelButtonId:"btnCancel"
            },
            // Debug Settings
            debug:false
        });
    });
</script>

