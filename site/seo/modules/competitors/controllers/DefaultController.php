<?php

class DefaultController extends SController
{
    public $layout = '//layouts/writing';

    public function actionIndex($group_id = null, $site_id = null, $year = 2013, $freq = null)
    {
        if (!Yii::app()->user->checkAccess('main-editor') && !Yii::app()->user->checkAccess('admin'))
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');

        if ($group_id !== null) {
            $group = SitesGroup::model()->findByPk($group_id);
            if ($group === null)
                throw new CHttpException(400);
            $site = null;
        } elseif ($site_id !== null) {
            $site = Site::model()->with('group')->findByPk($site_id);
            if ($site === null)
                throw new CHttpException(400);
            $group = $site->group;
        } else {
            $site = null;
            $group = null;
        }

        $groups = SitesGroup::model()->findAll();
        $criteria = new CDbCriteria();
        $criteria->compare('group_id', $group_id);
        $sites = Site::model()->findAll($criteria);

//        if (empty($site_id))
//            $site_id = SeoUserAttributes::getAttribute('last_competitor_site_id_section');
//        else
//            SeoUserAttributes::setAttribute('last_competitor_site_id_section', $site_id);

//        $current_site = Site::model()->findByPk($site_id);
//        if ($current_site === null)
//            $current_site = Site::model()->findByPk(81);

//        $sites = Site::model()->findAll();
//        $nav = array();
//        foreach ($sites as $site)
//            if (!$site->isPartOfGroup()) {
//                $nav [] = array(
//                    'label' => $site->name,
//                    'url' => $this->createUrl('default/index', array('site_id' => $site->id)),
//                    'active' => $site_id == $site->id
//                );
//
//                if (count($nav) == 6) {
//                    $this->fast_nav [] = $nav;
//                    $nav = array();
//                }
//            }
//
//        if (!empty($nav))
//            $this->fast_nav [] = $nav;

        $model = new SiteKeywordVisit;
        $model->attributes = $_GET;
        $model->year = $year;
        $model->sites_id = array(101);
        $model->freq = $freq;

        $this->render('competitors', compact('model', 'site_id', 'year', 'freq', 'group_id', 'groups', 'sites', 'site', 'group'));
    }

    public function actionSetGroup()
    {
        $site_id = Yii::app()->request->getPost('site_id');
        $group_id = Yii::app()->request->getPost('group_id');
        $success = Site::model()->updateByPk($site_id, array('group_id' => $group_id)) > 0;
        $response = compact('success');
        if ($success)
            $response['href'] = $this->createUrl('index', array('site_id' => $site_id, 'group_id' => $group_id));

        echo CJSON::encode($response);
    }
}