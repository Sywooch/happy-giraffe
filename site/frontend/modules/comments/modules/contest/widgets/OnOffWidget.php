<?php

namespace site\frontend\modules\ads\widgets;

/**
 * @author crocodile
 * 
 */
class OnOffWidget extends \CWidget
{

    public $model;
    public $preset;
    public $line;
    public $title;

    public function run()
    {
        $this->render('OnOffWidget');
    }

    public function getIsActive()
    {
        return false;
        $ad = Ad::model()->active()->preset($this->preset)->line(\Yii::app()->getModule('ads')->lines[$this->line]['lineId'])->entity($this->model)->find();
        return $ad !== null;
    }

    public function getParams()
    {
        return array(
            'preset' => $this->preset,
            'line' => $this->line,
            'modelPk' => $this->model->id,
        );
    }

}
