<?php

class DeleteWidget extends CWidget
{
    /**
     * @var CActiveRecord Model to delete
     */
    public $model;

    public function run()
    {
        $this->render('DeleteWidget', array(
            'model' => $this->model,
        ));
    }
}
