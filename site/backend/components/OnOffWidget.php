<?php

class OnOffWidget extends CWidget
{
    public $model;
    public $modelName;
    public $modelPk;
    public $modelActive;

    public function run()
    {
        if ($this->model instanceof CActiveRecord)
        {
            $this->modelName = get_class($this->model);
            $this->modelPk = $this->model->primaryKey;
            $this->modelActive = $this->model->active;
        }

        $this->render('OnOffWidget', array(
            'modelName' => $this->modelName,
            'modelPk' => $this->modelPk,
            'modelActive' => $this->modelActive,
        ));
    }
}
