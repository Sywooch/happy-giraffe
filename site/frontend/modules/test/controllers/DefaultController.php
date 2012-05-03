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

    public function actionView($slug)
    {
        $test = $this->LoadModel($slug);
        $this->pageTitle = strip_tags($test->title) . ', бесплатные тесты на сайте Веселый Жираф';

        $basePath = Yii::getPathOfAlias('test') . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'assets';
        $baseUrl = Yii::app()->getAssetManager()->publish($basePath, false, 1, YII_DEBUG);
        Yii::app()->clientScript->registerScriptFile($baseUrl . "/" . $test->getTypeName() . ".js", CClientScript::POS_HEAD);

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

    public function actionTestt()
    {
        //$models = TestQuestionAnswer::model()->findAll();
        $models = TestQuestion::model()->findAll('test_id=4');
        foreach ($models as $model) {
            /*$first = mb_substr($model->text,0,1, 'UTF-8');
            $first = mb_strtoupper($first, 'UTF-8');
            $text = $first.mb_substr($model->text,1,mb_strlen($model->text), 'UTF-8');
            echo $text.'<br>';
            $model->text = $text;
            $model->save();*/

            /*$text = trim($model->title);
            $text = trim($text, '?');
            $text .= '?';
            $model->title = $text;
            $model->save();*/
        }
    }
}
