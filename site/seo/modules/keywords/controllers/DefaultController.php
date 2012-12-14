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
            $model = new Keyword;
            $model->name = $term;

            $dataProvider = $model->search();
            $criteria = $dataProvider->criteria;

            $count = Keyword::model()->count($dataProvider->criteria);

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
}