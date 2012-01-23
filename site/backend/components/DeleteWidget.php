<?php

class DeleteWidget extends CWidget
{
    public $model;
    public $modelPk;
    public $modelName;
    public $modelAccusativeName;
    public $modelIsTree = false;
    public $selector = 'tr';
    public $onSuccess = '';

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
        ));
    }
}
