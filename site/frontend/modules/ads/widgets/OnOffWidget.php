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

    public function run()
    {
        $ad = Ad::model()->preset($this->preset)->line($this->line)->entity($this->model)->find();
        $this->render('OnOffWidget', array('on' => ($ad != null)));
    }

    public function getIsActive()
    {
        $ad = Ad::model()->preset($this->preset)->line($this->line)->entity($this->model)->find();
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