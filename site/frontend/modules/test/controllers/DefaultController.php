<?php

class DefaultController extends HController
{
    /**
     * @todo добавить в sitemap
     */
    public $layout = '//layouts/new2';

    public function filters()
    {
        return array(
            array(
                'COutputCache + view',
                'duration' => 10,
                'varyByParam' => array('slug'),
            ),
            array(
                'COutputCache + index',
                'duration' => 10,
            ),
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

    public function actionView($slug)
    {
        $test = $this->LoadModel($slug);
        $this->pageTitle = $test->title;

        $this->render('view', array(
            'test' => $test
        ));
    }

    public function actionView2($slug)
    {

        $basePath = Yii::getPathOfAlias('test') . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'assets';
        $baseUrl = Yii::app()->getAssetManager()->publish($basePath, false, 1, YII_DEBUG);
        //echo $baseUrl;
        Yii::app()->clientScript->registerScriptFile($baseUrl . '/points.js', CClientScript::POS_HEAD);

        $test = $this->LoadModelPoint($slug);
        $this->pageTitle = $test->title;

        $this->render('points', array(
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
        $model = Test::model()->with(array(
            'testQuestions' => array('order' => 'testQuestions.number'),
            'testQuestions.testQuestionAnswers' => array('order' => 'testQuestionAnswers.number'),
            'testResults' => array('order' => 'testResults.number'),
            'questionsCount'
        ))->findByAttributes(array('slug' => $slug));
        if ($model === null)
            throw new CHttpException(404, 'Такого теста не существует.');
        return $model;
    }

    public function LoadModelPoint($slug)
    {
        $model = Test::model()->with(array(
            'testQuestions' => array('order' => 'testQuestions.number'),
            'testQuestions.testQuestionAnswers' => array('order' => 'testQuestionAnswers.number'),
            'testResults' => array('order' => 'testResults.points DESC'),
            'questionsCount'
        ))->findByAttributes(array('slug' => $slug));
        if ($model === null)
            throw new CHttpException(404, 'Такого теста не существует.');
        return $model;
    }
}