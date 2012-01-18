<?php

class SimpleFormAddWidget extends CWidget
{
    /**
     * @var string Url where send ajax request
     */
    public $url;
    /**
     * @var int id of model which child we add
     */
    public $model_id;
    /**
     * @var bool only register script
     */
    public $init = false;

    public function run()
    {
        $this->render('SimpleFormAddWidget', array(
            'url' => $this->url,
            'model_id' => $this->model_id,
            'init'=>$this->init
        ));
    }
}