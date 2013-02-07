<?php

class DefaultController extends SController
{
    public $pageTitle = 'Ключевые слова';
    public $layout = '//layouts/writing';

    public function beforeAction($action)
    {
        if (!Yii::app()->user->checkAccess('admin'))
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');

        Yii::app()->clientScript->registerScriptFile('/js/key-ok.js');
        return true;
    }

    public function actionIndex()
    {
        $this->render('index');
    }

    public function actionSearchKeywords()
    {
        $term = $_POST['term'];
        if (!empty($term)) {
            $model = Keyword::GetKeyword($term, 2);
            StatisticUserSearch::addKeyword($model->id);

            $dataProvider = $model->search();
            $criteria = $dataProvider->criteria;

            $count = Keyword::model()->count($dataProvider->criteria);
            if ($count <= 1)
                ParsingKeyword::addNewKeyword($model->id, 10);

            $pages = new CPagination($count);
            $pages->pageSize = 100;
            $pages->currentPage = Yii::app()->request->getPost('page');
            $pages->applyLimit($dataProvider->criteria);

            $criteria2 = clone $criteria;
            $models = Keyword::model()->findAll($criteria2);

            $response = array(
                'status' => true,
                'count' => '',
                'table' => $this->renderPartial('_find_result_table', compact('models'), true),
                'pagination' => $this->renderPartial('_find_result_pagination', compact('pages'), true)
            );
            echo CJSON::encode($response);
        }
    }

    public function actionFavourites()
    {
        echo CJSON::encode(array(
            'status' => true,
            'keywords' => array(
                array('id' => 1, 'name' => 'привет', 'wordstat' => 245, 'folder' => ''),
                array('id' => 2, 'name' => 'привет2', 'wordstat' => 34, 'folder' => ''),
                array('id' => 3, 'name' => 'привет2', 'wordstat' => 45, 'folder' => ''),
                array('id' => 4, 'name' => 'привет2', 'wordstat' => 33, 'folder' => ''),
                array('id' => 5, 'name' => 'привет2', 'wordstat' => 23, 'folder' => ''),
                array('id' => 6, 'name' => 'привет2', 'wordstat' => 22, 'folder' => ''),
            )));
    }

    public function actionTest()
    {

        Yii::import('site.seo.extensions.ExportDataExcel');
        SeoExport::txt(array(
            array('23525', '22222', '33333'),
            array('23525', '22222', '33333'),
            array('23525', '22222', '33333'),
            array('23525', '22222', '33333'),
            array('23525', '22222', '33333'),
            array('23525', '22222', '33333'),
        ));
    }
}