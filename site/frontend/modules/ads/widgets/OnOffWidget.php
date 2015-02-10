<?php
namespace site\frontend\modules\ads\widgets\OnOffWidget;
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
        $ad = Ad::model()->line($this->line)->entity($this->model)->find();
        $this->render('OnOffWidget', array('on' => ($ad != null)));
    }
}