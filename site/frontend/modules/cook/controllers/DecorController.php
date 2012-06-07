<?php
class DecorController extends HController
{
    public function actionIndex($id = false)
    {
        $category = ($id) ? CookDecorationCategory::model()->findByPk($id) : null;

        $this->pageTitle = ($id) ? 'Оформление блюд: ' . $category->title : 'Оформление блюд';

        $dataProvider = new CActiveDataProvider('CookDecoration', array(
            'criteria' => array(
                'order' => 'photo.created DESC',
                'condition' => ($id) ? 'category_id=:category_id' : '',
                'params' => array(':category_id' => $id),
                'with' => array('category', 'photo'),
            ),
            'pagination' => array(
                'pageSize' => 6,
            ),
        ));

        $this->render('index', array(
            'id' => $id,
            'category' => $category,
            'dataProvider' => $dataProvider
        ));
    }
}