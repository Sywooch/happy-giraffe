<?php

class EditDeleteWidget extends CWidget
{
    public $model;
    public $attribute;
    public $deleteButton = true;
    public $editButton = true;
    /**
     * @var bool only register script
     */
    public $init = false;

    public $options = array();

    public function run()
    {
        $this->render('EditDeleteWidget', array(
            'model' => $this->model,
            'attribute' => $this->attribute,
            'deleteButton' => $this->deleteButton,
            'editButton' => $this->editButton,
            'init'=>$this->init,
            'options'=>$this->options
        ));
    }
}