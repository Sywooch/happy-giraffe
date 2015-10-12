<?php

namespace site\frontend\modules\questionnaire\controllers;

use site\frontend\modules\questionnaire\models\Questionnaire;
use site\frontend\modules\questionnaire\models\QuestionnaireForm;
use site\frontend\modules\questionnaire\models\QuestionnaireQuestions;
use site\frontend\modules\questionnaire\models\QuestionnaireAnswers;
use site\frontend\modules\questionnaire\models\QuestionnaireResults;

/*
 * Controller for testing.
 * */
class DefaultController extends \HController
{
    public function actionIndex()
    {
        $records = Questionnaire::model()->findAll();

        return $this->render('index', array('records' => $records));
    }

    /*First Step*/
    public function actionAdd()
    {
        $form = new QuestionnaireForm();

        $post_string = 'site_frontend_modules_questionnaire_models_QuestionnaireForm';

        $post = \Yii::app()->request->getPost($post_string);

        if (isset($post)) {
            $questionnaire_id = $this->transaction(Questionnaire::model(), function($context) use ($post){
                $questionnaire = new Questionnaire();

                $questionnaire->name = $post['text'];
                $questionnaire->user_id = \Yii::app()->user->getId();

                return $context->saveModel($questionnaire);
            });

            if (isset($_POST['text-0'])) {
                unset($_POST[$post_string]);
                unset($_POST['yt0']);

                foreach ($_POST as $key => $value) {
                    $this->transaction(QuestionnaireResults::model(), function($context) use ($key, $value, $questionnaire_id) {
                        $result = new QuestionnaireResults();

                        $result->questionnaire_id = $questionnaire_id;
                        $result->type = strpos($key, 'text') !== false ? 0 : 1;
                        $result->value = $value;

                        return $context->saveModel($result);
                    });
                }
            }

            return $this->redirect('?r=questionnaire/default/add2&questionnaire_id='.$questionnaire_id);
        }

        return $this->render('add', array('model' => $form));
    }

    /*Second Step*/
    public function actionAdd2($questionnaire_id)
    {
        if (isset($_POST['result']) && isset($questionnaire_id)){
            $result = json_decode($_POST['result'], true);

            $stage = 0;
            foreach ($result as $r) {
                $question_id = null;

                foreach ($r as $key => $value) {
                    if (!$question_id) {
                        $text = $value['question'];

                        $question_id = $this->transaction(QuestionnaireQuestions::model(), function($context) use ($questionnaire_id, $stage, $text) {
                            $question = new QuestionnaireQuestions();

                            $question->questionnaire_id = $questionnaire_id;
                            $question->stage = $stage;
                            $question->text = $text;

                            return $context->saveModel($question);
                        });
                    }

                    $text = $value['answer'];
                    $result_id = $value['result'];

                    $this->transaction(QuestionnaireAnswers::model(), function($context) use ($questionnaire_id, $question_id, $text, $result_id) {
                        $answer = new QuestionnaireAnswers();

                        $answer->questionnaire_id = $questionnaire_id;
                        $answer->question_id = $question_id;
                        $answer->text = $text;
                        $answer->result_id = $result_id;

                        return $context->saveModel($answer);
                    });
                }
                $stage++;
            }
        }

        $results = QuestionnaireResults::model()->findAll("questionnaire_id = :id", array(':id' => $questionnaire_id));
        $questionnaire = Questionnaire::model()->findByPk($questionnaire_id);

        return $this->render('add2', array(
            'id' => $questionnaire_id,
            'questionnaire' => $questionnaire,
            'results' => $results
        ));
    }

    public function actionDelete($questionnaire_id)
    {
        QuestionnaireAnswers::model()->deleteAll("questionnaire_id = :id", array(':id' => $questionnaire_id));
        QuestionnaireQuestions::model()->deleteAll("questionnaire_id = :id", array(':id' => $questionnaire_id));
        QuestionnaireResults::model()->deleteAll("questionnaire_id = :id", array(':id' => $questionnaire_id));
        Questionnaire::model()->deleteByPk($questionnaire_id);

        $this->redirect('?r=questionnaire/default/index');
    }

    public function actionEdit($questionnaire_id)
    {
        $questionnaire = Questionnaire::model()->findByPk($questionnaire_id);
        $results = QuestionnaireResults::model()->findAll("questionnaire_id = :id", array(':id' => $questionnaire_id));

        return $this->render('edit', array(
            'questionnaire' => $questionnaire,
            'results' => $results
        ));
    }

    public function actionSaveQuestionnaire($questionnaire_id)
    {
        if (isset($_POST['name'])) {
            $questionnaire = Questionnaire::model()->findByPk($questionnaire_id);

            $questionnaire->name = $_POST['name'];

            $questionnaire->save();
        }
    }

    public function actionSaveResult($result_id)
    {
        if(isset($_POST['text'])){
            $result = QuestionnaireResults::model()->findByPk($result_id);

            $result->value = $_POST['text'];

            $result->save();
        }
    }

    public function actionEdit2($questionnaire_id)
    {
        $questions = QuestionnaireQuestions::model()->findAll("questionnaire_id = :id", array(':id' => $questionnaire_id));
        /*$answers = QuestionnaireAnswers::model()->findAll("questionnaire_id = :id", array(':id' => $questionnaire_id));

        foreach ($questions as $question){
            foreach ($answers as $answer){
                if ($question ->id == $answer->question_id){
                    $answer->question_id = $question;
                }
            }
        }*/

        return $this->render('edit2', array('questions' => $questions));
    }

    private function transaction($model, $action)
    {
        $transaction = $model->dbConnection->beginTransaction();

        try {
            if ($id = $action($this)) {
                $transaction->commit();
                return $id;
            }
            else {
                $transaction->rollback();
            }
        }
        catch (Exception $e) {
            $transaction->rollback();
            throw $e;
        }
    }

    public function saveModel($model)
    {
        if ($model->save()) {
            return $model->id;
        }
        return false;
    }
}