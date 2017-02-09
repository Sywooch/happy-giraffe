<?php

/**
 * @author Никита
 * @date 09/11/15
 */

namespace site\frontend\modules\som\modules\qa\controllers;

use site\common\components\SphinxDataProvider;
use site\frontend\components\HCollection;
use site\frontend\modules\family\components\FamilyManager;
use site\frontend\modules\family\models\FamilyMember;
use site\frontend\modules\notifications\behaviors\ContentBehavior;
use site\frontend\modules\som\modules\qa\components\QaController;
use site\frontend\modules\som\modules\qa\components\QaManager;
use site\frontend\modules\som\modules\qa\models\QaCategory;
use site\frontend\modules\som\modules\qa\models\QaConsultation;
use site\frontend\modules\som\modules\qa\models\QaQuestion;
use site\frontend\modules\som\modules\qa\models\QaAnswer;
use site\frontend\modules\som\modules\qa\models\QaCTAnswer;
use site\frontend\modules\som\modules\qa\models\QaAnswerVote;
use site\frontend\modules\som\modules\qa\components\QaObjectList;
use site\frontend\modules\som\modules\qa\models\QaQuestionEditing;
use site\frontend\modules\som\modules\qa\models\QaTag;
use site\frontend\modules\som\modules\qa\models\qaTag\QaTagManager;

class DefaultController extends QaController
{
    const TAB_NEW = 'new';
    const TAB_POPULAR = 'popular';
    const TAB_UNANSWERED = 'unanswered';
    const TAB_All = 'all';

    /**
     * Открыт ли отдельный вопрос
     *
     * @var bool isQuestion
     */
    public $isQuestion = false;

    public $litePackage = 'qa';

    public function filters()
    {
        return [
            'accessControl',
        ];
    }

    public function accessRules()
    {
        return [
            ['deny',
                'users' => ['?'],
                'actions' => ['questionAddForm', 'questionEditForm'],
            ],
        ];
    }

    public function actionIndex($tab, $categoryId = null, $tagId = null)
    {
        $dp = $this->getDataProvider($tab, $categoryId, $tagId);

        if ($categoryId === null) {
            $category = null;
        } else {
            $category = QaCategory::model()->findByPk($categoryId);
            if ($category === null) {
                throw new \CHttpException(404);
            }
        }

        $this->render('index', compact('dp', 'tab', 'categoryId', 'category'));
    }

    public function actionPediatrician($tab, $tagId = null)
    {
        if ($tab == self::TAB_All)
        {
            $dp = new \CActiveDataProvider(QaAnswer::model()->roots()->orderDesc(), [
                'pagination' => [
                    'pageVar' => 'page',
                ]
            ]);

            if (!\Yii::app()->user->isGuest)
            {
                $votesList = new QaObjectList(QaAnswerVote::model()->user(\Yii::app()->user->id)->findAll());
            }

        } else {
            $dp = $this->getDataProvider($tab, QaCategory::PEDIATRICIAN_ID, $tagId);
        }

        $this->render('pediatrician', compact('dp', 'tab', 'votesList'));
    }

    /**
     * @inheritdoc
     * @param \CAction $action
     */
    protected function afterAction($action)
    {
        if ($action->id == 'pediatricianEditForm')
        {
            $questionId = (int) \Yii::app()->request->getParam('questionId');

            (new \CometModel())->send(QaManager::getQuestionChannelId($questionId), null, \CometModel::MP_QUESTION_EDITED_BY_OWNER);

            $findObject = QaManager::isQuestionEditing($questionId);

            if (!$findObject)
            {
                $object = new QaQuestionEditing();
                $object->questionId = $questionId;
                $object->save();
            }
        }

        parent::afterAction($action);
    }

    /**
     * {@inheritDoc}
     * @param \CAction $action
     * @see LiteController::beforeAction()
     */
    protected function beforeAction($action)
    {
        $newDesigneActions = [
            'pediatrician',
            'pediatricianSearch',
            'pediatricianAddForm',
            'pediatricianEditForm',
            'view'
        ];

        /* костыль для старой верстки */
        if (false !== mb_strpos(\Yii::app()->request->getPathInfo(), 'questions', 0, 'UTF-8'))
        {
            return parent::beforeAction($action);
        }

        if (in_array($action->id, $newDesigneActions))
        {
            $this->layout       = '/layouts/pediatrician';
            $this->litePackage  = 'new_pediatrician';
        }

        return parent::beforeAction($action);
    }

    public function actionView($id, $tab = null, $category = null)
    {
        $this->isQuestion = true;

        ContentBehavior::$active = true;

        $question = $this->getModel($id);

        ContentBehavior::$active = false;

        if ($question->category->isPediatrician())
        {
            if (false !== mb_strpos(\Yii::app()->request->getPathInfo(), 'questions', 0, 'UTF-8'))
            {
                $redirectUrl = "/mypediatrician/question{$id}";
                $this->redirect($redirectUrl, true, 301);
            }

            $answersTreeList = QaManager::getAnswersTreeByQuestion($question->id);

            $isEditing = QaManager::isQuestionEditing((int) $id);

            $answersCount = $question->getAnswersCount();

            $this->layout = '/layouts/pediatrician';
            $this->render('_view', compact('question', 'tab', 'category', 'answersTreeList', 'isEditing', 'answersCount'));
        }
        else
        {
            $this->render('view', compact('question', 'tab', 'category'));
        }
    }

    public function actionSearch($query = '', $categoryId = null)
    {
        $this->layout       = '/layouts/search_pediatrician';

        $dp = new SphinxDataProvider(QaQuestion::model()->apiWith('user')->with('category')->orderDesc(), [
            'sphinxCriteria' => [
                'select' => '*',
                'query' => $query,
                'from' => 'qa',
                'orders' => 'dtimecreate DESC',
                'filters' => ['categoryid' => $categoryId],
            ],
            'pagination' => [
                'pageVar' => 'page',
            ],
        ]);

        $this->render('search', compact('dp', 'query', 'categoryId'));
    }

    public function actionPediatricianSearch($query = '')
    {
        $this->layout       = '/layouts/search_pediatrician';

        $dp = new SphinxDataProvider(QaQuestion::model()->apiWith('user')->with('category')->orderDesc(), [
            'sphinxCriteria' => [
                'select' => '*',
                'query' => $query,
                'from' => 'qa',
                'orders' => 'dtimecreate DESC',
//                 'filters' => ['categoryid' => (string)QaCategory::PEDIATRICIAN_ID],
            ],
            'pagination' => [
                'pageVar' => 'page',
            ],
        ]);

        $this->render('new_search', compact('dp', 'query'));
    }

    protected function getDataProvider($tab, $categoryId, $tagId = null)
    {
        $model = $this->_sortByTabAndCategory($tab, $categoryId, $tagId);

        return new \CActiveDataProvider($model, [
            'pagination' => [
                'pageVar' => 'page',
            ],
        ]);
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

        $this->render('form', [
            'model' => $question,
            'categories' => QaCategory::model()->sorted()->with('tags')->findAll(),
        ]);
    }

    public function actionPediatricianAddForm()
    {
        if (!\Yii::app()->user->checkAccess('createQaQuestion')) {
            $this->redirect($this->createUrl('/site/index'));
        }

        $tagsData = (new HCollection(QaTagManager::getAllTags()))->toArray();

        $this->layout = '//layouts/lite/new_form';
        $this->render('new_form', [
            'tagsData' => $tagsData
        ]);
    }

    /**
     * Страница редактирования вопроса
     *
     * @param string $questionId ID вопроса
     * @author Sergey Gubarev
     */
    public function actionPediatricianEditForm($questionId)
    {
        if (!\Yii::app()->user->checkAccess('createQaQuestion') || !$question = QaManager::getQuestion($questionId))
        {
            $this->redirect($this->createUrl('/site/index'));
        }

        $tagsData = (new HCollection(QaTagManager::getAllTags()))->toArray();

        $this->layout = '//layouts/lite/new_form';
        $this->render('edit_form', [
            'question' => $question,
            'tagsData' => $tagsData
        ]);
    }

    public function actionQuestionEditForm($questionId)
    {
        $question = $this->getModel($questionId);
        if (!\Yii::app()->user->checkAccess('manageQaQuestion', ['entity' => $question])) {
            throw new \CHttpException(403);
        }

        $this->layout = '//layouts/lite/common';
        $this->performAjaxValidation($question);

        if ($question->consultationId !== null) {
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

        $this->render('form', [
            'model' => $question,
            'categories' => QaCategory::model()->sorted()->with('tags')->findAll(),
        ]);
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

        if ($categoryId !== null) {
            $model->category($categoryId);

            if (!is_null($tagId)) {
                $model->byTag($tagId);
            }
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
                $model
                    ->unanswered()
                    ->orderDesc();
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
