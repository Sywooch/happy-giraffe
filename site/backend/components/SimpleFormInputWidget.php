<?php

class SimpleFormInputWidget extends CWidget
{
    public $model;
    public $attribute;

    public function run()
    {
        $this->render('SimpleFormInputWidget', array(
            'model' => $this->model,
            'attribute' => $this->attribute,
        ));
    }
}