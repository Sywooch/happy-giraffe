<?php

class RegionController extends BController
{
    public $defaultAction = 'admin';
    //public $section = 'club';
    public $layout = '//layouts/club';
    public $_class = 'GeoRegion';
    public $authItem = 'routes';//     <------ Insert AuthItem here

    public function actions()
    {
        return array(
            'update' => 'application.components.actions.Update',
            'delete' => 'application.components.actions.Delete',
            'admin' => 'application.components.actions.Admin'
        );
    }

    public function actionChecked(){
        $id = Yii::app()->request->getPost('id');
        $model = $this->loadModel($id);
        $model->auto_created = 0;
        $model->save();
    }

    /**
     * @param int $id model id
     * @return GeoRegion
     * @throws CHttpException
     */
    public function loadModel($id){
        $model = GeoRegion::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');
        return $model;
    }
}
