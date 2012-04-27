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

    public function actionView($slug)
    {
        $test = $this->LoadModel($slug);
        $this->pageTitle = strip_tags($test->title). ', бесплатные тесты на сайте Веселый Жираф';

        $basePath = Yii::getPathOfAlias('test') . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'assets';
        $baseUrl = Yii::app()->getAssetManager()->publish($basePath, false, 1, YII_DEBUG);
        Yii::app()->clientScript->registerScriptFile($baseUrl . "/" . $test->getTypeName() . ".js", CClientScript::POS_HEAD);

        $this->render($test->getTypeName(), array(
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

        if ($model->type == Test::TYPE_POINTS)
            $model = Test::model()->with(array(
                'testQuestions' => array('order' => 'testQuestions.number'),
                'testQuestions.testQuestionAnswers' => array('order' => 'testQuestionAnswers.number'),
                'testResults' => array('order' => 'testResults.points DESC'),
                'questionsCount'
            ))->findByAttributes(array('slug' => $slug));
        else
            $model = Test::model()->with(array(
                'testQuestions' => array('order' => 'testQuestions.number'),
                'testQuestions.testQuestionAnswers' => array('order' => 'testQuestionAnswers.number'),
                'testResults' => array('order' => 'testResults.number'),
                'questionsCount'
            ))->findByAttributes(array('slug' => $slug));
        return $model;
    }
}