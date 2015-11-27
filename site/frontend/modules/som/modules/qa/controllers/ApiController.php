<?php
/**
 * @author Никита
 * @date 09/11/15
 */

namespace site\frontend\modules\som\modules\qa\controllers;


use site\frontend\modules\som\modules\qa\components\VotesManager;
use site\frontend\modules\som\modules\qa\models\QaAnswer;
use site\frontend\modules\som\modules\qa\models\QaAnswerVote;
use site\frontend\modules\som\modules\qa\models\QaConsultation;
use site\frontend\modules\som\modules\qa\models\QaQuestion;
use site\frontend\modules\som\modules\qa\models\QaUserRating;
use site\frontend\modules\som\modules\qa\widgets\answers\AnswersWidget;

class ApiController extends \site\frontend\components\api\ApiController
{
    public static $answerModel = '\site\frontend\modules\som\modules\qa\models\QaAnswer';

    public function actions()
    {
        return \CMap::mergeArray(parent::actions(), array(
            'editAnswer' => array(
                'class' => 'site\frontend\components\api\EditAction',
                'modelName' => self::$answerModel,
                'checkAccess' => 'editQaAnswer',
            ),
            'removeAnswer' => array(
                'class' => 'site\frontend\components\api\SoftDeleteAction',
                'modelName' => self::$answerModel,
                'checkAccess' => 'removeQaAnswer',
            ),
            'restoreAnswer' => array(
                'class' => 'site\frontend\components\api\SoftRestoreAction',
                'modelName' => self::$answerModel,
                'checkAccess' => 'restoreQaAnswer',
            ),
        ));
    }

    public function actionCreateAnswer($questionId, $text)
    {
        if (! \Yii::app()->user->checkAccess('createQaAnswer')) {
            throw new \CHttpException(403);
        }

        /** @var \site\frontend\modules\som\modules\qa\models\QaAnswer $answer */
        $answer = new self::$answerModel();
        $answer->attributes = array(
            'questionId' => $questionId,
            'text' => $text,
        );
        $this->success = $answer->save();
        $this->data = $answer->toJSON();
    }

    public function actionGetAnswers($questionId)
    {
        $answers = QaAnswer::model()->question($questionId)->apiWith('user')->findAll();
        $votes = array_map(function(QaAnswerVote $vote) {
            return (int) $vote->answerId;
        }, QaAnswerVote::model()->answers($answers)->user(\Yii::app()->user->id)->findAll());
        $this->data = array(
            'answers' => QaAnswer::model()->question($questionId)->apiWith('user')->findAll(),
            'votes' => $votes,
        );
        $this->success = true;
    }

    public function actionVote($answerId)
    {
        $this->data = VotesManager::changeVote(\Yii::app()->user->id, $answerId)->toJSON();
        $this->success = $this->data !== false;
    }

    /**
     * @param \CAction $action
     * @todo переделать в поведение
     */
    public function afterAction($action)
    {
        $types = array(
            'vote' => \CometModel::QA_VOTE,
            'createAnswer' => \CometModel::QA_NEW_ANSWER,
            'removeAnswer' => \CometModel::QA_REMOVE_ANSWER,
            'restoreAnswer' => \CometModel::QA_RESTORE_ANSWER,
            'editAnswer' => \CometModel::QA_EDIT_ANSWER,
        );
        if ($this->success == true && in_array($action->id, array_keys($types)))
        {
            $data = ($this->data instanceof \IHToJSON) ? $this->data->toJSON() : $this->data;
            $this->send(AnswersWidget::getChannelIdByAnswer($this->data), $data, $types[$action->id]);
        }
        parent::afterAction($action);
    }
}