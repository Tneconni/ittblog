<?php
session_start();
$url = $this->createUrl('attachment/upload');
?>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/swfupload/swfupload.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/swfupload/swfupload.queue.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/swfupload/fileprogress.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/swfupload/handlers.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/swfupload/upload.css"/>

<style type="text/css">
    #photo-upload{
        width: 800px;
        min-height: 600px;
        padding: 3px;
        /*border-top: 1px solid #f7953e;*/
        /*border-left: 1px solid #f7953e;*/
    }
    #photo-upload-header{
        color: white;
        margin: 3px;
        height: auto;
        min-height: 800px;
    }

    #fsUploadProgress img {
        width: 180px;
        height: 200px;
        margin-top: 5px;
        margin-right: 10px;
        z-index: 5000;
    }

    #fsUploadProgress {
        width: 777px;
        padding-left: 10px;
    }

    .progressContainer {
        width: 180px;
    }

    .progressContainer div {
        width: 180px;
    }

    .progressContainer a {
        width: 180px;
    }

    .progressWrapper {
        width: 180px;
        color: blue;
        margin-right: 10px;
    }

    .progressWrapper div {
        width: 180px;
    }
</style>
<div id="photo-upload" align="left">
    <div id="photo-upload-header">
    <span>
          上传到：
    </span>
    <span id="photo-box-dropList">
          <select name="pic">
              <option value="">--请选择相册--</option>
              <option value="">--测试相册1--</option>
              <option value="">--测试相册2--</option>
              <option value="new-photo-box" style="background: gray;color: blue;">
                  ----新建相册----
              </option>
          </select>
    </span>
        <span id="spanButtonPlaceholder"></span>
        <input id="btnCancel" type="button" value="取消上传" onclick="cancelQueue(upload);"
               style="margin-left: 2px; height: 22px;width: 61px; font-size: 8pt;"/>
        <a href="<?=$this->createUrl('photo/photoList')?>">返回相册列表</a>
        <br>
        <div id="fsUploadProgress">
            <span id='preview'></span><br>
        </div>
    </div>
</div>
<script type="text/javascript">
    var upload;
    $(function () {
        upload = new SWFUpload({
            // Backend Settings
            upload_url:"<?php echo $url;?>",
            post_params:{"PHPSESSID":"<?php echo session_id(); ?>"},
            file_post_name:"Filedata",

            // File Upload Settings
            file_size_limit:"5 MB", // 10MB
            file_types:"*.png;*.jpg;*.gif;",
            file_types_description:"File Type",
            file_upload_limit:"1000",
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
            button_text_left_padding:18,

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

    function myUploadSuccess(file, serverData) {
        try {
            var progress = new FileProgress(file, this.customSettings.progressTarget);
            progress.setComplete();
            progress.setStatus("上传成功.");
            progress.toggleCancel(false);

            var img = document.createElement("img");
            img.setAttribute("alt", "图片预览");
            if (serverData.substring(0, 7) === "FILEID:") {
                img.setAttribute("src", serverData.substring(7));
            }
            else {
                img.setAttribute("value", "");
            }
            document.getElementById("preview").appendChild(img);


        } catch (ex) {
            this.debug(ex);
        }
    }

</script>
