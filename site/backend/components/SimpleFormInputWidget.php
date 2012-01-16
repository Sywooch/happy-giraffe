<?php

class SimpleFormInputWidget extends CWidget
{
    public $model;
    public $attribute;
    public $onlyDelete = false;

    public function run()
    {
        $this->render('SimpleFormInputWidget', array(
            'model' => $this->model,
            'attribute' => $this->attribute,
            'onlyDelete' => $this->onlyDelete
        ));
    }
}