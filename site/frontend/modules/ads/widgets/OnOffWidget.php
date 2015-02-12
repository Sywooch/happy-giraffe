<?php
namespace site\frontend\modules\ads\widgets;
use site\frontend\modules\ads\models\Ad;

/**
 * @author Никита
 * @date 10/02/15
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
        $ad = Ad::model()->preset($this->preset)->line(\Yii::app()->getModule('ads')->lines[$this->line]['lineId'])->entity($this->model)->find();
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