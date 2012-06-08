<?php

class DefaultController extends SController
{
    public $layout = 'main';

    public function actionIndex($site_id = 1, $year = 2012, $freq = null)
    {
        $sites = Site::model()->findAll();
        foreach ($sites as $site)
            $this->fast_nav [] = array(
                'label' => $site->name,
                'url' => $this->createUrl('default/index', array('site_id' => $site->id)),
                'active' => $site_id == $site->id
            );

        $model = new KeyStats;
        $model->attributes = $_GET;
        $model->year = $year;
        $model->site_id = $site_id;
        $model->freq = $freq;

        $this->render('competitors', compact('model', 'site_id', 'year', 'freq'));
    }
}