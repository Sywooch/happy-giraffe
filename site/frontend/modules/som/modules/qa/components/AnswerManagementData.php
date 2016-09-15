<?php
/**
 * @author Никита
 * @date 15/09/16
 */

namespace site\frontend\modules\som\modules\qa\components;


use site\frontend\modules\som\modules\qa\models\QaAnswerVote;

class AnswerManagementData
{
    public static function process($answers)
    {
        $votes = QaAnswerVote::model()->answers($answers)->user(\Yii::app()->user->id)->findAll(array('index' => 'answerId'));
        $_answers = array();
        foreach ($answers as $answer) {
            $_answer = $answer->toJSON();
            $_answer['canEdit'] = \Yii::app()->user->checkAccess('updateQaAnswer', array('entity' => $answer));
            $_answer['canRemove'] = \Yii::app()->user->checkAccess('removeQaAnswer', array('entity' => $answer));
            $_answer['canVote'] = \Yii::app()->user->checkAccess('voteAnswer', array('entity' => $answer));
            $_answer['isVoted'] = isset($votes[$answer->id]);
            $_answers[] = $_answer;
        }
        return $_answers;
    }
}