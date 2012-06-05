<?php
class DecorController extends HController
{
    public function actionIndex()
    {
        $this->pageTitle = 'Оформление блюд';

        $dataProvider = new CActiveDataProvider('CookDecoration', array(
            'criteria' => array(
                'join' => '',
                //'condition' => 'status=1',
                //'order' => 'create_time DESC',
                'with' => array('category'),
            ),
            'pagination' => array(
                'pageSize' => 3,
            ),
        ));

        $this->render('index', array('dataProvider' => $dataProvider));
    }
}