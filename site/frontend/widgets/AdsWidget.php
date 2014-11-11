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
        $contents = ob_get_clean();
        if ($this->show) {
            echo $contents;
        } elseif ($this->dummyTag !== null) {
            echo CHtml::tag($this->dummyTag);
        }
    }
} 