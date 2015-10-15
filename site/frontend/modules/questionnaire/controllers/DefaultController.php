<?php

namespace site\frontend\modules\questionnaire\controllers;

use site\frontend\modules\questionnaire\models\Questionnaire;
use site\frontend\modules\questionnaire\models\QuestionnaireForm;
use site\frontend\modules\questionnaire\models\QuestionnaireQuestions;
use site\frontend\modules\questionnaire\models\QuestionnaireAnswers;
use site\frontend\modules\questionnaire\models\QuestionnaireResults;
use site\frontend\modules\photo\models\Photo;

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

            if (isset($_FILES['image-0'])){
                foreach ($_FILES as $file){
                    $photo_id = $this->transaction(Photo::model(), function($context) use ($file) {
                        $photo = new Photo();
                        $photo->setImage(file_get_contents($file['tmp_name']));
                        $photo->original_name = $file['name'];

                        return $context->saveModel($photo);
                    });

                    $this->transaction(QuestionnaireResults::model(), function($context) use ($photo_id, $questionnaire_id){
                        $result = new QuestionnaireResults();

                        $result->questionnaire_id = $questionnaire_id;
                        $result->type = 1;
                        $result->value = $photo_id;

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

        $questionnaire = Questionnaire::model()->findByPk($questionnaire_id);

        return $this->render('add2', array(
            'id' => $questionnaire_id,
            'questionnaire' => $questionnaire,
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

        return $this->render('edit', array(
            'questionnaire' => $questionnaire,
        ));
    }

    public function actionSaveQuestionnaire($questionnaire_id)
    {
        if (isset($_POST['name'])) {
            $this->transaction(Questionnaire::model(), function($context) use ($questionnaire_id){
                $questionnaire = Questionnaire::model()->findByPk($questionnaire_id);

                $questionnaire->name = $_POST['name'];

                return $context->saveModel($questionnaire);
            });
        }
    }

    public function actionSaveResult($result_id)
    {
        if(isset($_POST['text'])){
            $this->transaction(QuestionnaireResults::model(), function($context) use ($result_id){
                $result = QuestionnaireResults::model()->findByPk($result_id);

                $result->value = $_POST['text'];

                return $context->saveModel($result);
            });
        }
    }

    public function actionDeleteResult($result_id)
    {
        QuestionnaireResults::model()->deleteByPk($result_id);

        foreach (QuestionnaireAnswers::model()->findAll('result_id = :id', array(':id' => $result_id)) as $answer){
            $this->transaction(QuestionnaireAnswers::model(), function($context) use ($answer){
                $answer->result_id = 0;

                return $context->saveModel($answer);
            });
        }
    }

    public function actionEdit2($questionnaire_id)
    {
        //$questions = QuestionnaireQuestions::model()->findAll("questionnaire_id = :id", array(':id' => $questionnaire_id));
        $questionnaire = Questionnaire::model()->findByPk($questionnaire_id);

        return $this->render('edit2', array(
            //'questions' => $questions,
            'questionnaire' => $questionnaire
        ));
    }

    public function actionSaveQuestion($question_id)
    {
        if (isset($_POST['text'])){
            $this->transaction(QuestionnaireQuestions::model(), function($context) use ($question_id){
                $question = QuestionnaireQuestions::model()->findByPk($question_id);

                $question->text = $_POST['text'];

                return $context->saveModel($question);
            });
        }
    }

    public function actionDeleteQuestion($question_id)
    {
        $question = QuestionnaireQuestions::model()->findByPk($question_id);

        foreach ($question->answers as $answer){
            $answer->delete();
        }

        $question->delete();
    }

    public function actionSaveAnswer($answer_id)
    {
        if (isset($_POST['text'])){
            $this->transaction(QuestionnaireAnswers::model(), function($context) use ($answer_id){
                $answer = QuestionnaireAnswers::model()->findByPk($answer_id);

                $answer->text = $_POST['text'];

                return $context->saveModel($answer);
            });
        }
    }

    public function actionDeleteAnswer($answer_id)
    {
        QuestionnaireAnswers::model()->deleteByPk($answer_id);
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