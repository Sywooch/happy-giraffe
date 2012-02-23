<?php

class DefaultController extends Controller
{
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
        $tests = Test::model()->findAll(array(
            'select' => array('id', 'name', 'slug')
        ));
        $this->render('index', array(
            'tests' => $tests
        ));
    }

    public function actionView($slug)
    {
        $test = $this->LoadModel($slug);
        $this->pageTitle = $test->name;

        $this->render('view', array(
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
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');
        return $model;
    }

    public function actionTitles()
    {
        $test = $this->LoadModel('hair-type');
        $test->name = 'Какие типы волос бывают? Определить тип волос';
        $test->save(false);

        $test = $this->LoadModel('prikorm');
        $test->name = 'Первый прикорм ребенка. Как вводить прикорм грудных детей? ';
        $test->save(false);
    }
}