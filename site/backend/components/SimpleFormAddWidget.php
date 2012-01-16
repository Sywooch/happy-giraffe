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

    public function run()
    {
        $this->render('SimpleFormAddWidget', array(
            'url' => $this->url,
            'model_id' => $this->model_id,
        ));
    }
}