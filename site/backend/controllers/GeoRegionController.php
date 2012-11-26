<?php

class GeoRegionController extends BController
{
    public $defaultAction = 'admin';
    //public $section = 'club';
    public $layout = '//layouts/club';
    public $_class = 'GeoRegion';
    public $authItem = 'geo';//     <------ Insert AuthItem here

    public function actions()
    {
        return array(
            'create' => 'application.components.actions.Create',
            'update' => 'application.components.actions.Update',
            'delete' => 'application.components.actions.Delete',
            'admin' => 'application.components.actions.Admin'
        );
    }

    public function actionAutoComplete($region_id, $term){
        $criteria = new CDbCriteria;
        $criteria->compare('name', $term, true);
        $criteria->compare('region_id', $region_id);
        $criteria->limit = 20;

        $models = GeoCity::model()->findAll($criteria);
        $result = array();
        foreach($models as $model)
            $result[] = array('id'=>$model->id,'label'=>$model->fullName);
        echo CJSON::encode($result);
    }
}
