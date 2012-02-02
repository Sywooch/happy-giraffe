<?php

class DeleteWidget extends CWidget
{
    public $model;
    public $modelPk;
    public $modelName;
    public $modelAccusativeName;
    public $modelIsTree = false;
    /**
     * selector of html-element that contains delete link and will be deleted when object deleted
     * @var string
     */
    public $selector = '';
    /**
     * js-code that execute after success delete
     * @var string
     */
    public $onSuccess = '';
    public $init = false;

    public function run()
    {
        if ($this->model instanceof CActiveRecord)
        {
            $this->modelName = get_class($this->model);
            $this->modelPk = $this->model->primaryKey;
            $this->modelAccusativeName = $this->model->accusativeName;
            $this->modelIsTree = $this->model->asa('tree') instanceof NestedSetBehavior;
        }

        $this->render('DeleteWidget', array(
            'modelName' => $this->modelName,
            'modelPk' => $this->modelPk,
            'modelAccusativeName' => $this->modelAccusativeName,
            'modelIsTree' => $this->modelIsTree,
            'selector' => $this->selector,
            'onSuccess' => $this->onSuccess,
            'init'=>$this->init,
        ));
    }
}
