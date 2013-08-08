<?php

class DefaultController extends SController
{
    public $layout = '//layouts/writing';

    public function actionIndex($group_id = null, $site_id = null, $year = 2013, $freq = null, $type = SiteKeywordVisit::FILTER_ALL)
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

        $model = new SiteKeywordVisit;
        $model->attributes = $_GET;
        $model->year = $year;
        $model->sites_id = array(101);
        $model->freq = $freq;

        $this->render('competitors', compact('model', 'site_id', 'year', 'freq', 'group_id', 'groups', 'sites', 'site', 'group', 'type'));
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