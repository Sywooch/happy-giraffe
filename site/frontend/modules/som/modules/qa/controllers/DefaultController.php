<?php

/**
 * @author Никита
 * @date 09/11/15
 */

namespace site\frontend\modules\som\modules\qa\controllers;

use site\common\components\SphinxDataProvider;
use site\frontend\modules\notifications\behaviors\ContentBehavior;
use site\frontend\modules\som\modules\qa\components\QaController;
use site\frontend\modules\som\modules\qa\models\QaCategory;
use site\frontend\modules\som\modules\qa\models\QaConsultation;
use site\frontend\modules\som\modules\qa\models\QaQuestion;
use site\frontend\modules\som\modules\qa\models\QaAnswer;

class DefaultController extends QaController
{

    const TAB_NEW = 'new';
    const TAB_POPULAR = 'popular';
    const TAB_UNANSWERED = 'unanswered';

    /**
     * Открыт ли отдельный вопрос
     *
     * @var bool isQuestion
     */
    public $isQuestion = FALSE;

    public $litePackage = 'qa';

    public function filters()
    {
        return array(
            'accessControl',
        );
    }

    public function accessRules()
    {
        return array(
            array('deny',
                'users' => array('?'),
                'actions' => array('questionAddForm', 'questionEditForm'),
            ),
        );
    }

    public function actionIndex($tab, $categoryId = null, $tagId = null)
    {
        $dp = $this->getDataProvider($tab, $categoryId, $tagId);

        if ($categoryId === null)
        {
            $category = null;
        }
        else
        {
            $category = QaCategory::model()->findByPk($categoryId);
            if ($category === null)
            {
                throw new \CHttpException(404);
            }
        }

        $this->render('index', compact('dp', 'tab', 'categoryId', 'category'));
    }

    public function actionView($id, $tab = null, $category = null)
    {
        $this->isQuestion = TRUE;

        ContentBehavior::$active = true;
        $question = $this->getModel($id);
        ContentBehavior::$active = false;
        $this->render('view', compact('question', 'tab', 'category'));
    }

    public function actionSearch($query = '', $categoryId = null)
    {
        $dp = new SphinxDataProvider(QaQuestion::model()->apiWith('user')->with('category'), array(
            'sphinxCriteria' => array(
                'select' => '*',
                'query' => $query,
                'from' => 'qa',
                'filters' => array('categoryid' => $categoryId),
            ),
            'pagination' => array(
                'pageVar' => 'page',
            ),
        ));

        $this->render('search', compact('dp', 'query', 'categoryId'));
    }

    protected function getDataProvider($tab, $categoryId, $tagId = null)
    {
        $model = $this->_sortByTabAndCategory($tab, $categoryId, $tagId);

        return new \CActiveDataProvider($model, array(
            'pagination' => array(
                'pageVar' => 'page',
            ),
        ));
    }

    public function actionQuestionAddForm($consultationId = null, $redirectUrl = null)
    {
        $this->layout = '//layouts/lite/common';

        $question = new QaQuestion();
        $this->performAjaxValidation($question);
        if ($consultationId !== null) {
            $consultation = QaConsultation::model()->findByPk($consultationId);
            if ($consultation === null) {
                throw new \CHttpException(404);
            }
            $question->consultationId = $consultationId;
            $question->scenario = 'consultation';
        }

        if (isset($_POST[\CHtml::modelName($question)])) {
            $params = $_POST[\CHtml::modelName($question)];

            $question->attributes = $params;

            if ($question->category && count($question->category->tags) > 0) {
                $question->setScenario('tag');
                $question->tag_id = isset($params['tag_id']) ? $params['tag_id'] : null;
            } else {
                $question->tag_id = null;
            }

            if ($question->save()) {
                $url = $redirectUrl ?: $question->url;
                $this->redirect($url);
            }
        }

        $this->render('form', array(
            'model' => $question,
            'categories' => QaCategory::model()->sorted()->with('tags')->findAll(),
            ));
    }

    public function actionQuestionEditForm($questionId)
    {
        $question = $this->getModel($questionId);
        if (! \Yii::app()->user->checkAccess('manageQaQuestion', array('entity' => $question)))  {
            throw new \CHttpException(403);
        }

        $this->layout = '//layouts/lite/common';
        $this->performAjaxValidation($question);

        if ($question->consultationId !== null)  {
            $question->scenario = 'consultation';
        }

        if (isset($_POST[\CHtml::modelName($question)])) {
            $params = $_POST[\CHtml::modelName($question)];

            $question->attributes = $params;
            $category = QaCategory::model()->with('tags')->findByPk($question->categoryId);

            if ($category && count($category->tags) > 0) {
                $question->setScenario('tag');
                $question->tag_id = isset($params['tag_id']) ? $params['tag_id'] : null;
            } else {
                $question->tag_id = null;
            }

            if ($question->save()) {
                $this->redirect($question->url);
            }
        }

        $this->render('form', array(
            'model' => $question,
            'categories' => QaCategory::model()->sorted()->with('tags')->findAll(),
        ));
    }

    /**
     * @param QaQuestion $question
     * @return QaQuestion|null
     */
    public function getLeftQuestion(QaQuestion $question)
    {
        return $question->previous()->category($question->categoryId)->find();
    }

    /**
     * @param QaQuestion $question
     * @return QaQuestion|null
     */
    public function getRightQuestion(QaQuestion $question)
    {
        return $question->next()->category($question->categoryId)->find();
    }

    /**
     * @param string $tab
     * @param integer $categoryId
     * @param integer $tagId
     * @return \site\frontend\modules\som\modules\qa\models\QaQuestion
     */
    private function _sortByTabAndCategory($tab, $categoryId, $tagId = null)
    {
        $model = clone QaQuestion::model();

        $model->apiWith('user')->with('category');

        if ($categoryId !== null)
        {
            $model->category($categoryId);

            if (!is_null($tagId))
            {
                $model->byTag($tagId);
            }
        }
        else
        {
            $model->notConsultation();
        }

        switch ($tab)
        {
            case self::TAB_NEW:
                $model->orderDesc();
                break;
            case self::TAB_POPULAR;
                $model->orderRating();
                break;
            case self::TAB_UNANSWERED:
                $model
                    ->unanswered()
                    ->orderDesc()
                ;
                break;
        }

        return $model;
    }

    /**
     * @param integer $pk
     * @throws \CHttpException
     * @return QaQuestion
     */
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
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'question-form') {
           echo \CActiveForm::validate($model);
            \Yii::app()->end();
        }
    }

}
