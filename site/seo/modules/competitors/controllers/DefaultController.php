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
            case 10:
                $this->layout = '//layouts/writing';
                break;
        }
        if (empty($site_id))
            $site_id = SeoUserAttributes::getAttribute('last_competitor_site_id_section_' . $section);
        else
            SeoUserAttributes::setAttribute('last_competitor_site_id_section_' . $section, $site_id);

        $current_site = Site::model()->findByPk($site_id);
        if ($current_site === null)
            $current_site = Site::model()->findByPk(1);

        $sites = Site::model()->findAllByAttributes(array('section' => $section));
        $nav = array();
        foreach ($sites as $site)
            if (!$site->isPartOfGroup()) {
                $nav [] = array(
                    'label' => $site->name,
                    'url' => $this->createUrl('default/index', array('site_id' => $site->id, 'section' => $section)),
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

        $this->render('competitors', compact('model', 'site_id', 'year', 'freq', 'section'));
    }
}