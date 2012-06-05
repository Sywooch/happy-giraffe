<?php
class DecorController extends HController
{
    public function actionIndex()
    {
        $this->pageTitle = 'Оформление блюд';

        $dataProvider = new CActiveDataProvider('CookDecoration', array(
            'criteria' => array(
                'order' => 'photo.created DESC',
                'with' => array('category','photo'),
            ),
            'pagination' => array(
                'pageSize' => 6,
            ),
        ));

        $this->render('index', array('dataProvider' => $dataProvider));
    }
}