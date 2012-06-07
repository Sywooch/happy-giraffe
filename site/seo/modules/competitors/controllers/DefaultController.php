<?php

class DefaultController extends SController
{
    public $layout = 'main';

    public function actionIndex($site_id = 1, $year = 2011, $recOnPage = 10)
    {
        $model = new KeyStats;
        $model->site_id = $site_id;
        $model->year = $year;

        $this->render('competitors', compact('model', 'site_id', 'year', 'recOnPage'));
    }
}