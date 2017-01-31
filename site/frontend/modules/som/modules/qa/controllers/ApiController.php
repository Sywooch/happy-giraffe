<?php
/**
 * @author Никита
 * @date 09/11/15
 */

namespace site\frontend\modules\som\modules\qa\controllers;

use site\frontend\modules\notifications\behaviors\ContentBehavior;
use site\frontend\modules\som\modules\qa\components\CTAnswerManager;
use site\frontend\modules\som\modules\qa\components\VotesManager;
use site\frontend\modules\som\modules\qa\models\QaAnswer;
use site\frontend\modules\som\modules\qa\models\QaAnswerVote;
use site\frontend\modules\som\modules\qa\models\QaCTAnswer;
use site\frontend\modules\som\modules\qa\models\QaQuestion;
use site\frontend\modules\som\modules\qa\models\QaRating;
use site\frontend\modules\som\modules\qa\widgets\answers\AnswersWidget;
use site\frontend\modules\specialists\models\SpecialistGroup;
use site\frontend\modules\som\modules\qa\models\QaTag;
use site\frontend\modules\som\modules\qa\models\QaCategory;
use site\frontend\modules\som\modules\qa\components\QaManager;

class ApiController extends \site\frontend\components\api\ApiController
{
    public static $answerModel = QaAnswer::class;
    public static $questionModel = QaQuestion::class;

    protected function beforeAction($action)
    {
        \TimeLogger::model()->startTimer(date('j D в H:i:s') . ' [ACTION] ' . $action->id);

        return parent::beforeAction($action);
    }

    public function actions()
    {
        return \CMap::mergeArray(parent::actions(), [
            // QaAnswer
            'editAnswer' => [
                'class' => 'site\frontend\components\api\EditAction',
                'modelName' => self::$answerModel,
                'checkAccess' => 'updateQaAnswer',
            ],
            'removeAnswer' => [
                'class' => 'site\frontend\components\api\SoftDeleteAction',
                'modelName' => self::$answerModel,
                'checkAccess' => 'removeQaAnswer',
            ],
            'restoreAnswer' => [
                'class' => 'site\frontend\components\api\SoftRestoreAction',
                'modelName' => self::$answerModel,
                'checkAccess' => 'restoreQaAnswer',
            ],

            // QaQuestion
            'removeQuestion' => [
                'class' => 'site\frontend\components\api\SoftDeleteAction',
                'modelName' => self::$questionModel,
                'checkAccess' => 'removeQaQuestion',
            ],
            'restoreQuestion' => [
                'class' => 'site\frontend\components\api\SoftRestoreAction',
                'modelName' => self::$questionModel,
                'checkAccess' => 'restoreQaQuestion',
            ],
        ]);
    }

    public function actionCreateAnswer($questionId, $text, $answerId = null)
    {
        /** @var $user \WebUser */
        $user = \Yii::app()->user;

        /** @var $question QaQuestion */
        $question = QaQuestion::model()->findByPk($questionId);

        if (is_null($question) || !(new QaManager)->canCreateAnswer($question, $answerId)) {
            throw new \CHttpException(403, 'Access Denied');
        }

        /** @var \site\frontend\modules\som\modules\qa\models\QaAnswer $answer */
        $answer = new self::$answerModel();
        $answer->attributes = [
            'questionId'    => $questionId,
            'text'          => $text,
        ];

        if ($answer->validate())
        {
            // Если ответил специалист то не нужно сразу отсылать оповещение и показывать ответ, т.к. на этой дело висит таймаут
            if ($question->category->isPediatrician() && $answer->author->isSpecialistOfGroup(SpecialistGroup::DOCTORS)) {
                $answer->isPublished = false;
            }
        }

        if (!is_null($answerId))
        {
            $answer->setAttribute('root_id', $answerId);
        }

        $this->success  = $answer->save();
        $this->data     = $answer;
    }

    public function actionGetTags()
    {
        $tags = QaTag::model()->byCategory(QaCategory::PEDIATRICIAN_ID)->findAll();

        if (is_null($tags))
        {
            $this->success = FALSE;
            return;
        }

        $result = [];
        foreach ($tags as $tag)
        {
            $result[] = [
                'id' => $tag->id,
                'name' => $tag->name,
                'title' => $tag->getTitle(),

            ];
        }

        $this->success = !empty($result);
        $this->data = $result;
    }

    /**
     * Опубликовать/обновить вопрос
     *
     * @param integer|null  $id         ID вопроса (если нужно обновить)
     * @param string        $title      Заголовок
     * @param string        $text       Текст
     * @param integer|null  $tagId      ID тэга
     * @param integer|null  $childId    ID ребенка
     * @param integer|null  $categoryId ID категории
     * @throws \CHttpException
     */
    public function actionCreateQuestion($id = null, $title, $text, $tagId = NULL, $childId = NULL, $categoryId = NULL)
    {
        if (!\Yii::app()->user->checkAccess('createQaQuestion')) {
            throw new \CHttpException(403);
        }

        if (is_null($tagId) && is_null($childId))
        {
            throw new \CHttpException(400, 'tagId or childId must be passed');
        }

        if (is_null($id))
        {
            $question = new QaQuestion();
        }
        else
        {
            $question = QaManager::getQuestion($id);
        }

        if (!is_null($tagId))
        {
            $question->setScenario('tag');
            $question->tag_id = $tagId;
            $question->attachedChild = null;
        }

        if (!is_null($childId))
        {
            $question->setScenario('attachedChild');
            $question->attachedChild = $childId;
            $question->tag_id = null;
        }

        $question->title                = $title;
        $question->text                 = $text;
        $question->attachedChild        = $childId;
        $question->sendNotifications    = 1;//@todo Emil Vililyaev: hardCode! хз по какому условию ставить значение
        $question->categoryId           = is_null($categoryId) ? QaCategory::PEDIATRICIAN_ID : $categoryId;

        $this->success = $question->save();
        $this->data = $question;
    }

    public function actionGetAnswers($questionId)
    {
        $question = QaQuestion::model()->findByPk($questionId);

        ContentBehavior::$active = true;

        // $answers = QaManager::getAnswers($question);

        $answers = $question->answerManager->getAnswers($question);

        ContentBehavior::$active = false;

        $_answers = [];

        if ($question->answerManager instanceof CTAnswerManager) {
            $voteManager = QaCTAnswer::createVoteManager();

            $voteManager->loadAnswerData($answers, \Yii::app()->user->id);

            $_answers = array_map(function (QaCTAnswer $answer) use ($question, $voteManager) {
                return [
                    'user' => \CMap::mergeArray($answer->user->toJSON(), [
                        'answersCount' => QaRating::model()->byUser($answer->user->id)->find()->answers_count,
                        'votesCount' => QaRating::model()->byUser($answer->user->id)->find()->votes_count,
                    ]),
                    'dtimeCreate' => $answer->dtimeCreate,
                    'text' => $answer->purified->text,
                    'votesCount' => $answer->votes_count,
                    'canEdit' => false,
                    'canRemove' => false,
                    'canVote' => false,
                    'isVoted' => $voteManager->isVoted($answer->id, \Yii::app()->user->id),
                    'isAdditional' => false,
                    'isAnswerToAdditional' => false,
                    'isSpecialistAnswer' => false,
                    'root_id' => null,
                    'can_answer' => $question->answerManager->canAnswer($answer, \Yii::app()->user->getModel()),
                ];
            }, $answers);
        } else {
            $votes = QaAnswerVote::model()->answers($answers)->user(\Yii::app()->user->id)->findAll(['index' => 'answerId']);

            foreach ($answers as $answer) {
                /** @var $answer QaAnswer */
                $_answer = $answer->toJSON();
                $_answer['canEdit'] = \Yii::app()->user->checkAccess('updateQaAnswer', ['entity' => $answer]);
                $_answer['canRemove'] = \Yii::app()->user->checkAccess('removeQaAnswer', ['entity' => $answer]);
                $_answer['canVote'] = \Yii::app()->user->checkAccess('voteAnswer', ['entity' => $answer]);
                $_answer['isVoted'] = isset($votes[$answer->id]);
                $_answer['isAdditional'] = $answer->isAdditional();
                $_answer['isAnswerToAdditional'] = $answer->isAnswerToAdditional();
                $_answer['isSpecialistAnswer'] = $answer->authorIsSpecialist();
                $_answer['root_id'] = $answer->root_id;
                $_answers[] = $_answer;
            }
        }

        $this->data = [
            'answers' => $_answers,
            'question' => $question->toJSON(),
            'canAnswer' => \Yii::app()->user->checkAccess('createQaAnswer', ['question' => $this->getModel(self::$questionModel, $questionId)]),
        ];
        $this->success = true;
    }

    public function actionGetChildAnswer($answerId)
    {
        $this->data = QaAnswer::model()->apiWith('user')->findAll('root_id=' . $answerId);
        $this->success = true;
    }

    public function actionVote($answerId)
    {
        $answer = $this->getModel(self::$answerModel, $answerId);
        if (!\Yii::app()->user->checkAccess('voteAnswer', ['entity' => $answer])) {
            throw new \CHttpException(403);
        }
        $this->data = VotesManager::changeVote(\Yii::app()->user->id, $answerId);
        $this->success = $this->data !== false;
    }

    /**
     * @param \CAction $action
     * @todo переделать в поведение
     */
    public function afterAction($action)
    {
        $types = [
            'vote'          => \CometModel::QA_VOTE,
            'createAnswer'  => \CometModel::QA_NEW_ANSWER,
            'removeAnswer'  => \CometModel::QA_REMOVE_ANSWER,
            'restoreAnswer' => \CometModel::QA_RESTORE_ANSWER,
            'editAnswer'    => \CometModel::QA_EDIT_ANSWER,
        ];

        if ($this->success == true && array_key_exists($action->id, $types))
        {
            if ($action->id == 'createAnswer' && $this->data->author->isSpecialist)
            {
                return parent::afterAction($action);
            }

            $data = ($this->data instanceof \IHToJSON) ? $this->data->toJSON() : $this->data;

            if ($this->data instanceof QaAnswer)
            {
                $questionChannelId = QaManager::getQuestionChannelId($this->data->question->id);

                if ($action->id == 'createAnswer' || $action->id == 'removeAnswer' || $action->id == 'restoreAnswer')
                {
                    $count = $this->data->question->getAnswersCount();

                    $response = [
                        'count'     => $count,
                        'countText' => \Yii::t('app', 'ответ|ответа|ответов|ответа', $count)
                    ];

                    $this->send($questionChannelId, $response, \CometModel::MP_QUESTION_UPDATE_ANSWERS_COUNT);
                }

                if ($this->data->question->category->isPediatrician())
                {
                    $chanelId = $questionChannelId;

                }
                else
                {
                    $chanelId = AnswersWidget::getChannelIdByQuestion($this->data->questionId);
                }

                $this->send($chanelId, $data, $types[$action->id]);
            }
        }

        parent::afterAction($action);
    }
}