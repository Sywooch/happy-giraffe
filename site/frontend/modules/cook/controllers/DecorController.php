<?php
class DecorController extends HController
{
    public function actionIndex($id = false)
    {
        $perPage = 3;

        $category = ($id) ? CookDecorationCategory::model()->findByPk($id) : null;

        $this->pageTitle = ($id) ? 'Оформление блюд: ' . $category->title : 'Оформление блюд';

        $dataProvider = CookDecoration::model()->indexDataProvider($id, $perPage);
        $pages = ceil($dataProvider->totalItemCount / $perPage);

        if (Yii::app()->request->isAjaxRequest) {
            $result = array(
                'html' => $this->renderPartial('index', compact('id', 'category', 'dataProvider', 'pages'), true)
            );
            header('Content-type: application/json');
            echo CJSON::encode($result);
        } else {
            $this->render('index', compact('id', 'category', 'dataProvider', 'pages'));
        }

    }
}