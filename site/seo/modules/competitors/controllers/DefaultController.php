<?php

class DefaultController extends SController
{
    public $layout = '//layouts/writing';

    public function actionIndex($site_id = null, $year = 2012, $freq = null)
    {
        if (empty($site_id))
            $site_id = SeoUserAttributes::getAttribute(Yii::app()->user->id, 'last_competitor_site_id');
        else
            SeoUserAttributes::setAttribute(Yii::app()->user->id, 'last_competitor_site_id', $site_id);

        $sites = Site::model()->findAll();
        foreach ($sites as $site)
            $this->fast_nav [] = array(
                'label' => $site->name,
                'url' => $this->createUrl('default/index', array('site_id' => $site->id)),
                'active' => $site_id == $site->id
            );

        $model = new SiteKeywordVisit;
        $model->attributes = $_GET;
        $model->year = $year;
        $model->site_id = $site_id;
        $model->freq = $freq;

        $this->render('competitors', compact('model', 'site_id', 'year', 'freq'));
    }
}