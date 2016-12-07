<?php

namespace site\frontend\modules\som\modules\qa\models;

use site\frontend\modules\som\modules\qa\components\BaseAnswerManager;
use site\frontend\modules\som\modules\qa\components\QaManager;
use site\frontend\modules\specialists\models\SpecialistGroup;

class DefaultAnswerManager extends BaseAnswerManager
{
    public function createAnswer($authorId, $content, $subject)
    {
        /** @var \site\frontend\modules\som\modules\qa\models\QaAnswer $answer */
        $answer = new QaAnswer();
        $answer->attributes = [
            'questionId' => $subject->id,
            'text' => $content,
        ];
        
        if ($answer->validate()) {
            // Если ответил специалист то не нужно сразу отсылать оповещение и показывать ответ, т.к. на этой дело висит таймаут
            if ($subject->category->isPediatrician() && $answer->author->isSpecialistOfGroup(SpecialistGroup::DOCTORS)) {
                $answer->isPublished = false;
            }
        }
        
        return $answer->save() ? $answer : null;
        
        //if (!is_null($answerId) && QaAnswer::model()->exists('id=' . $answerId)) {
            //$answer->setAttribute('root_id', $answerId);
        //}
    }
    
    public function getAnswers()
    {
        $sql = <<<SQL
          SELECT * FROM qa__answers
            WHERE
            qa__answers.questionId = {$this->question->id}
              AND
            qa__answers.isRemoved = 0
              AND
            qa__answers.isPublished = 1
SQL;
        
        return QaAnswer::model()->findAllBySql($sql);
    }
    
    public function getAnswersCount()
    {
        $sql = <<<SQL
          SELECT COUNT(1) FROM qa__answers
            WHERE
            qa__answers.questionId = {$this->question->id}
              AND
            qa__answers.isRemoved = 0
              AND
            qa__answers.isPublished = 1
SQL;

        return \Yii::app()->db->createCommand($sql)->queryColumn()[0];
    }
    
    
}