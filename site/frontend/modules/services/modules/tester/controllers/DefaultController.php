<?php

class DefaultController extends HController
{

    public $layout = '//layouts/new';

    public function actionIndex()
    {
        $this->render('index');
    }

    public function actionView($slug)
    {
        $test = Test::model()->findByAttributes(array('slug' => $slug));

        if ($test === null)
            throw new CHttpException(404, 'Такого теста не существует.');


        if (!Yii::app()->request->isPostRequest) {
            Yii::app()->user->setState('tester', array());
            $this->render($test->slug . '_start', array('test' => $test));
        } else {
            $stepMethod = 'step_' . $test->getTypeName();
            $step = $this->$stepMethod($test);
            $this->render($test->slug . $step['template'], $step);
        }


    }

    private function step_points($test)
    {
        $template = '_step';

        // process answer

        if (isset($_POST['question'])) {
            $answer = TestQuestionAnswer::model()->findByPk($_POST['question']['answer_id']);
            $tester = Yii::app()->user->getState('tester');
            $tester['points'] = $tester['points'] + $answer->points;
            Yii::app()->user->setState('tester', $tester);

            if ($answer->islast)
                return $this->result_points($test);
        }

        // get question

        $lastNumber = (isset($_POST['question']['number'])) ? $_POST['question']['number'] : 0;

        $criteria = new CDbCriteria;
        $criteria->limit = 1;
        $criteria->condition = 'test_id = ' . $test->id . ' AND number > ' . $lastNumber;
        $criteria->order = 't.number';
        $criteria->with = array(
            'testQuestionAnswers' => array('order' => 'testQuestionAnswers.number')
        );
        $question = TestQuestion::model()->find($criteria);

        if ($question == null) {
            return $this->result_points($test);
        }


        return compact('template', 'question', 'test');
    }

    private function result_points($test)
    {
        $template = '_result';

        $tester = Yii::app()->user->getState('tester');

        $criteria = new CDbCriteria;
        $criteria->limit = 1;
        $criteria->condition = 'points  <= ' . $tester['points'];
        $criteria->order = 'points DESC';

        $result = TestResult::model()->find($criteria);

        return compact('template', 'test', 'result');
    }
}