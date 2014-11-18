<?php
/**
 * Created by PhpStorm.
 * User: mikita
 * Date: 21/07/14
 * Time: 16:30
 */

class AdsWidget extends CWidget
{
    public $width;
    public $height;
    public $mediaQuery;
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
            $this->registerLazyLoad();
            $contents = $this->prepareContents($contents);
            $this->render('AdsWidget', compact('contents'));
        } elseif ($this->dummyTag !== null) {
            echo CHtml::tag($this->dummyTag);
        }
    }

    protected function registerLazyLoad()
    {
        if (Yii::app()->clientScript->useAMD) {
            Yii::app()->clientScript->registerAMDFile(array(), '/new/javascript/modules/lazyad-loader.js');
        } else {
            Yii::app()->clientScript->registerScriptFile('/new/javascript/modules/lazyad-loader.js');
        }
    }

    protected function prepareContents($contents)
    {
        $contents = preg_replace('#<!--(.*?)-->#', '', $contents);
        $contents = str_replace('<!--', '', $contents);
        $contents = str_replace('// -->', '', $contents);
        $contents = str_replace('<script', '<!-- <script', $contents);
        $contents = str_replace('</script>', '</script> -->', $contents);
        return $contents;
    }
} 