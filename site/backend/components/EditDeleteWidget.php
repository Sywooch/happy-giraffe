<?php

class EditDeleteWidget extends CWidget
{
    /**
     * @var CActiveRecord
     */
    public $model;
    public $attribute;
    public $deleteButton = true;
    public $editButton = true;
    public $modelName;
    public $modelPk;
    public $attributeValue;

    /**
     * @var bool only register script
     */
    public $init = false;

    public $options = array();

    public function run()
    {
        if ($this->model instanceof CActiveRecord)
        {
            $this->modelName = get_class($this->model);
            $this->modelPk = $this->model->primaryKey;
            $this->attributeValue = $this->model->getAttribute($this->attribute);
        }

        $this->render('EditDeleteWidget', array(
            'modelName' => $this->modelName,
            'modelPk' => $this->modelPk,
            'attribute' => $this->attribute,
            'attributeValue'=>$this->attributeValue,
            'deleteButton' => $this->deleteButton,
            'editButton' => $this->editButton,
            'init'=>$this->init,
            'options'=>$this->options,
        ));
    }
}