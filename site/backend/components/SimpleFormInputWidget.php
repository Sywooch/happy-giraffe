<?php

class SimpleFormInputWidget extends CWidget
{
    public $model;
    public $attribute;
    public $onlyDelete = false;
    /**
     * @var bool only register script
     */
    public $init = false;

    public function run()
    {
        $this->render('SimpleFormInputWidget', array(
            'model' => $this->model,
            'attribute' => $this->attribute,
            'onlyDelete' => $this->onlyDelete,
            'init'=>$this->init
        ));
    }
}