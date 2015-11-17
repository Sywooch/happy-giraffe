<?php
/**
 * @author Никита
 * @date 09/11/15
 */

namespace site\frontend\modules\som\modules\qa\controllers;


use site\frontend\modules\som\modules\qa\components\VotesManager;
use site\frontend\modules\som\modules\qa\models\QaConsultation;
use site\frontend\modules\som\modules\qa\models\QaQuestion;
use site\frontend\modules\som\modules\qa\models\QaUserRating;

class ApiController extends \site\frontend\components\api\ApiController
{
    public static $answerModel = '\site\frontend\modules\som\modules\qa\models\QaAnswer';

    public function actionVote($answerId)
    {
        $this->success = VotesManager::changeVote(\Yii::app()->user->id, $answerId);
    }

    public function actionCreateAnswer($questionId, $text)
    {
        $answer = new self::$answerModel;
        $answer->attributes = array(
            'questionId' => $questionId,
            'text' => $text,
        );
    }

    public function actionGetUsersRatingLeaders($type, $limit)
    {
        $this->data = QaUserRating::model()->orderRating()->type($type)->findAll(array(
            'limit' => $limit,
        ));
        $this->success = true;
    }
}