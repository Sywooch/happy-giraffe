<?php

class DefaultController extends SController
{
    public $layout = '//layouts/writing';

    public function actionIndex($section = 1, $site_id = null, $year = 2012, $freq = null)
    {
        switch ($section) {
            case 1:
                $this->layout = '//layouts/writing';
                break;
            case 2:
                $this->layout = '//layouts/cook';
                break;
        }
        if (empty($site_id))
            $site_id = SeoUserAttributes::getAttribute(Yii::app()->user->id, 'last_competitor_site_id_section_' . $section);
        else
            SeoUserAttributes::setAttribute(Yii::app()->user->id, 'last_competitor_site_id_section_' . $section, $site_id);

        $sites = Site::model()->findAllByAttributes(array('section' => $section));
        $nav = array();
        foreach ($sites as $site) {
            $nav [] = array(
                'label' => $site->name,
                'url' => $this->createUrl('default/index', array('site_id' => $site->id, 'section'=>$section)),
                'active' => $site_id == $site->id
            );

            if (count($nav) == 6) {
                $this->fast_nav [] = $nav;
                $nav = array();
            }
        }

        if (!empty($nav))
            $this->fast_nav [] = $nav;

        $model = new SiteKeywordVisit;
        $model->attributes = $_GET;
        $model->year = $year;
        $model->site_id = $site_id;
        $model->freq = $freq;

        $this->render('competitors', compact('model', 'site_id', 'year', 'freq', 'section'));
    }
}