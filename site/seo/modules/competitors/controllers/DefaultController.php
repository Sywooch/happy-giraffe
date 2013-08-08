<?php

class DefaultController extends SController
{
    public $layout = '//layouts/writing';

    public function actionIndex($site_id = null, $year = 2013, $freq = null)
    {
        if (!Yii::app()->user->checkAccess('main-editor') && !Yii::app()->user->checkAccess('admin'))
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');

        if (empty($site_id))
            $site_id = SeoUserAttributes::getAttribute('last_competitor_site_id_section');
        else
            SeoUserAttributes::setAttribute('last_competitor_site_id_section', $site_id);

        $current_site = Site::model()->findByPk($site_id);
        if ($current_site === null)
            $current_site = Site::model()->findByPk(81);

        $sites = Site::model()->findAll();
        $nav = array();
        foreach ($sites as $site)
            if (!$site->isPartOfGroup()) {
                $nav [] = array(
                    'label' => $site->name,
                    'url' => $this->createUrl('default/index', array('site_id' => $site->id)),
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
        $model->sites_id = $current_site->getGroupSiteIds();
        $model->freq = $freq;

        $this->render('competitors', compact('model', 'site_id', 'year', 'freq'));
    }
}