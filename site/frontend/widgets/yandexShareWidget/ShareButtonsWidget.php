<?php
/**
 * @author Никита
 * @date 20/07/15
 */

Yii::import('application.widgets.yandexShareWidget.ShareWidget');

class ShareButtonsWidget extends CWidget
{
    public $url;

    public function init()
    {
        $this->registerScripts();
    }

    public function run()
    {
        $this->render('ShareButtonsWidget');
    }

    protected function registerScripts()
    {
        $cs = Yii::app()->clientScript;

        $cs->amd['shim']['ok.share'] = array('exports' => 'OK');
        $cs->amd['paths']['ok.share'] = '//connect.ok.ru/connect';
        $cs->registerAMD('OkShare#' . $this->id, array('OkShare' => 'ok.share', '$' => 'jquery') , 'OK.CONNECT.insertShareWidget("OkShare_' . $this->id . '","' . $this->url . '","{width:100,height:21,st:\'straight\',sz:20,ck:2}");');

        $cs->amd['shim']['vk.share'] = array('exports' => 'VK');
        $cs->amd['paths']['vk.share'] = '//vk.com/js/api/share';
        $cs->registerAMD('VkShare#' . $this->id, array('VkShare' => 'vk.share', '$' => 'jquery') , '$("#VkShare_' . $this->id . '").html(VK.Share.button(false,{type: "round", text: "Поделиться"}));');

        $cs->registerAMD('FbShare', array(), '(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/ru_RU/sdk.js#xfbml=1&version=v2.4&appId=412497558776154";
  fjs.parentNode.insertBefore(js, fjs);
}(document, "script", "facebook-jssdk"));');

        $cs->registerAMD('Events#' . $this->id, array('$' => 'jquery', 'jquery.iframetracker'), '
        jQuery(document).ready(function($){
            setTimeout(function(){
                $("#FbShare_' . $this->id . ' iframe").iframeTracker({
                    blurCallback: function(){
                        dataLayer.push({"event": "fbShare"});
                    }
                });

                $("#OkShare_' . $this->id . ' iframe").iframeTracker({
                    blurCallback: function(){
                        dataLayer.push({"event": "okShare"});
                    }
                });
            }, 5000);
        });
        ');
    }
}