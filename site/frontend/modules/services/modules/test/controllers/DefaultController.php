<?php

class DefaultController extends HController
{
    /**
     * @todo добавить в sitemap
     */
    public $layout = '//layouts/new';

    public function filters()
    {
        return array(
//            array(
//                'COutputCache + view',
//                'duration' => 10,
//                'varyByParam' => array('slug'),
//            ),
//            array(
//                'COutputCache + index',
//                'duration' => 10,
//            ),
        );
    }

    public function actionIndex()
    {
        $this->pageTitle = 'Тесты';
        $tests = Test::model()->findAll(array(
            'select' => array('id', 'title', 'slug')
        ));
        $this->render('index', array(
            'tests' => $tests
        ));
    }

    /**
     * @sitemap dataSource=getModelsUrls
     */
    public function actionView($slug)
    {
        $test = $this->LoadModel($slug);
        $this->pageTitle = strip_tags($test->title);

        $basePath = Yii::getPathOfAlias('test') . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'assets';
        $baseUrl = Yii::app()->getAssetManager()->publish($basePath, false, 1, YII_DEBUG);
        Yii::app()->clientScript->registerScriptFile($baseUrl . "/" . $test->getTypeName() . ".js?3", CClientScript::POS_HEAD);
        $this->meta_description = $test->meta_description;

        $this->render($test->getTypeName() . '_' . $test->slug, array(
            'test' => $test
        ));
    }

    /**
     * @param $slug
     * @return Test
     * @throws CHttpException
     */
    public function LoadModel($slug)
    {
        $model = Test::model()->findByAttributes(array('slug' => $slug));
        if ($model === null)
            throw new CHttpException(404, 'Такого теста не существует.');

        $orderBy = ($model->type == Test::TYPE_POINTS) ? 'testResults.points DESC' : 'testResults.number';

        $model = Test::model()->with(array(
            'testQuestions' => array('order' => 'testQuestions.number'),
            'testQuestions.testQuestionAnswers' => array('order' => 'testQuestionAnswers.number'),
            'testResults' => array('order' => $orderBy),
            'questionsCount'
        ))->findByAttributes(array('slug' => $slug));

        return $model;
    }

    public function getModelsUrls()
    {
        Yii::import('application.modules.services.modules.test.models.*');

        $models = Test::model()->findAll();
        $data = array();
        foreach ($models as $model)
            $data[] = array(
                'params' => array('slug' => $model->slug),
            );
        return $data;
    }
}
