<?php

class CityDeclensionController extends BController
{
    public $defaultAction = 'admin';
    //public $section = 'club';
    public $layout = '//layouts/club';
    public $_class = 'GeoCity';
    public $authItem = 'routes';//     <------ Insert AuthItem here

    public function actions()
    {
        return array(
            'create' => 'application.components.actions.Create',
            'update' => 'application.components.actions.Update',
            'delete' => 'application.components.actions.Delete',
            'admin' => 'application.components.actions.Admin'
        );
    }

    public function actionChecked(){
        $id = Yii::app()->request->getPost('id');
        $city = $this->loadModel($id);
        $city->declension_checked = 1;
        $city->save();
    }

    /**
     * @param int $id model id
     * @return GeoCity
     * @throws CHttpException
     */
    public function loadModel($id){
        $model = GeoCity::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');
        return $model;
    }
}
