<?php
/**
 * Author: choo
 * Date: 27.06.2012
 */
class SeoContentWidget extends CWidget
{
    public function init()
    {
        ob_start();
    }

    public function run()
    {
        $contents = ob_get_clean();
        $hashString = md5($contents);
        echo CHtml::tag('span', array('data-type' => 'content', 'data-key' => md5($contents)));
        Yii::app()->controller->seoContent[$hashString] = base64_encode($contents);
    }
}
