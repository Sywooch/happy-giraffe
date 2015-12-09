<?php
/**
 * @author Никита
 * @date 09/11/15
 */

namespace site\frontend\modules\som\modules\qa\controllers;


use site\common\components\SphinxDataProvider;
use site\frontend\modules\som\modules\qa\components\QaController;
use site\frontend\modules\som\modules\qa\components\QuestionsDataProvider;
use site\frontend\modules\som\modules\qa\models\QaAnswer;
use site\frontend\modules\som\modules\qa\models\QaConsultation;
use site\frontend\modules\som\modules\qa\models\QaQuestion;
use site\frontend\modules\som\modules\qa\models\QaUserRating;

class DefaultController extends QaController
{
    const TAB_NEW = 'new';
    const TAB_POPULAR = 'popular';
    const TAB_UNANSWERED = 'unanswered';

    public function actionIndex($tab, $categoryId = null)
    {
        $dp = $this->getDataProvider($tab, $categoryId);
        $this->render('index', compact('dp', 'tab'));
    }

    public function actionView($id)
    {
        $question = $this->getModel($id);
        $this->render('view', compact('question'));
    }

    public function actionSearch($query = '')
    {
        $dp = new SphinxDataProvider(QaQuestion::model()->apiWith('user')->with('category'), array(
            'sphinxCriteria' => array(
                'select' => '*',
                'query' => $query,
                'from' => 'qa',
            ),
            'pagination' => array(
                'pageVar' => 'page',
            ),
        ));

        $this->render('search', compact('dp', 'query'));
    }

    protected function getDataProvider($tab, $categoryId)
    {
        $model = clone QaQuestion::model();
        $model->apiWith('user')->with('category');
        if ($categoryId !== null) {
            $model->category($categoryId);
        } else {
            $model->notConsultation();
        }
        switch ($tab) {
            case self::TAB_NEW:
                $model->orderDesc();
                break;
            case self::TAB_POPULAR;
                $model->orderRating();
                break;
            case self::TAB_UNANSWERED:
                $model->unanswered();
                break;
        }

        return new \CActiveDataProvider($model, array(
            'pagination' => array(
                'pageVar' => 'page',
            ),
        ));
    }

    public function actionQuestionAddForm($consultationId = null)
    {
        $this->layout = '//layouts/lite/common';

        $question = new QaQuestion();
        $this->performAjaxValidation($question);
        if ($consultationId !== null) {
            $consultation = QaConsultation::model()->with('category')->findByPk($consultationId);
            if ($consultation === null) {
                throw new \CHttpException(404);
            }
            $question->categoryId = $consultation->category->id;
            $question->scenario = 'consultation';
        }

        if (isset($_POST[\CHtml::modelName($question)])) {
            $question->attributes = $_POST[\CHtml::modelName($question)];
            if ($question->save()) {
                $this->redirect($question->url);
            }
        }

        $this->render('form', array('model' => $question));
    }

    public function actionQuestionEditForm($questionId)
    {
        $question = $this->getModel($questionId);
        $this->performAjaxValidation($question);
        if ($question->category->consultationId !== null) {
            $question->scenario = 'consultation';
        }

        if (isset($_POST[\CHtml::modelName($question)])) {
            $question->attributes = $_POST[\CHtml::modelName($question)];
            if ($question->save()) {
                $this->redirect($question->url);
            }
        }
    }

    protected function getModel($pk)
    {
        $question = QaQuestion::model()->with('category')->findByPk($pk);
        if ($question === null) {
            throw new \CHttpException(404);
        }
        return $question;
    }

    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'question-form')
        {
            echo \CActiveForm::validate($model);
            \Yii::app()->end();
        }
    }
}