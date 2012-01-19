<?php

class OnOffWidget extends CWidget
{
    /**
     * @var CActiveRecord Model to switch on/off
     */
    public $model;

    public function run()
    {
        $this->render('OnOffWidget', array(
            'model' => $this->model,
        ));
    }
}
