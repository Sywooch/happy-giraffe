<?php
class FileUploadWidget extends CWidget
{
    protected $input_id;

    public function init()
    {
        parent::init();
        $this->registerScripts();
        $this->render('index');
    }

    public function registerScripts()
    {
        $basePath = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR;
        $baseUrl = Yii::app()->getAssetManager()->publish($basePath, false, 1, YII_DEBUG);

        $js = "var upload_ajax_url = '" . Yii::app()->createUrl('/ajax/savePhoto') . "';";
        $swfupload = 'var swfu;
        function initSwfUpoad(fileInput, form) {
            form.append(\'<div class="fieldset flash" id="fsUploadProgress"><span class="legend">Upload Queue</span></div><div id="divStatus">0 Files Uploaded</div><div><span id="spanButtonPlaceHolder"></span><input id="btnCancel" type="button" value="Cancel All Uploads" onclick="swfu.cancelQueue();" disabled="disabled" style="margin-left: 2px; font-size: 8pt; height: 29px;" /></div>\');
            var settings = {
                flash_url : "'.$baseUrl.'/swfupload.swf",
                upload_url: "'.Yii::app()->createUrl('/ajax/savePhoto').'",
                post_params: {"PHPSESSID" : ""},
                file_size_limit : "100 MB",
                file_types : "*.*",
                file_types_description : "All Files",
                file_upload_limit : 100,
                file_queue_limit : 0,

                debug: false,

                // Button settings
                button_image_url: "'.$baseUrl.'/TestImageNoText_65x29.png",
                button_width: "65",
                button_height: "29",
                button_placeholder_id: "spanButtonPlaceHolder",
                button_text: "<span class=\"theFont\">Hello</span>",
                button_text_style: ".theFont { font-size: 16; }",
                button_text_left_padding: 12,
                button_text_top_padding: 3,

                // The event handler functions are defined in handlers.js
                file_queued_handler : fileQueued,
                file_queue_error_handler : fileQueueError,
                file_dialog_complete_handler : fileDialogComplete,
                upload_start_handler : uploadStart,
                upload_progress_handler : uploadProgress,
                upload_error_handler : uploadError,
                upload_success_handler : uploadSuccess,
                upload_complete_handler : uploadComplete,
                queue_complete_handler : queueComplete	// Queue plugin event
            };

            swfu = new SWFUpload(settings);
        }';

        $cs = Yii::app()->clientScript;
        $cs->registerCoreScript('jquery')
            ->registerScriptFile($baseUrl . '/' . 'html5upload.js')
            ->registerScriptFile($baseUrl . '/' . 'file_upload.js')
            ->registerCssFile($baseUrl . '/' . 'file_upload.css')
            //->registerScript('upload_ajax_url', $js, CClientScript::POS_HEAD)
            /*->registerScriptFile($baseUrl . '/' . 'swfupload.js')
            ->registerScriptFile($baseUrl . '/' . 'swfupload.queue.js')
            ->registerScriptFile($baseUrl . '/' . 'fileprogress.js')
            ->registerScriptFile($baseUrl . '/' . 'swfupload.handlers.js')*/
            //->registerScript('init_swf_upload', $swfupload, CClientScript::POS_HEAD)
        ;
    }
}
