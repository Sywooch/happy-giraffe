<?php
/**
 * Created by PhpStorm.
 * User: mikita
 * Date: 21/07/14
 * Time: 16:30
 */

class AdsWidget extends CWidget
{
    public $show;
    public $dummyTag;

    public function init()
    {
        if ($this->show === null) {
            $this->show = Yii::app()->ads->showAds;
        }

        ob_start();
    }

    public function run()
    {
        Yii::app()->clientScript->registerAMDFile(array(), '/new/javascript/modules/lazyad-loader.js');
        $contents = ob_get_clean();
        if ($this->show) {
            $contents = str_replace('<script', '<!--<script', $contents);
            $contents = str_replace('</script>', '</script>-->', $contents);
            $this->render('AdsWidget', compact('contents'));
        } elseif ($this->dummyTag !== null) {
            echo CHtml::tag($this->dummyTag);
        }
    }
} 