<?php

class ReportWidget extends CWidget
{

    public $source_data = array();
    public $model = null;

    public function run()
    {
        if($this->model)
        {
            $this->source_data = array(
                'model' => get_class($this->model),
                'object_id' => $this->model->primaryKey,
            );
        }
    }

    public function button()
    {
        $this->render('button', array(

        ));
    }

    public function form()
    {
        $report = new Report;
        $this->render('form', array(
            'report' => $report,
            'source_data' => $this->source_data,
        ));
    }

}