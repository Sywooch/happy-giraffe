<?php
/**
 * Created by JetBrains PhpStorm.
 * User: mikita
 * Date: 11/11/13
 * Time: 16:05
 * To change this template use File | Settings | File Templates.
 */

class CommunityQuestionWidget extends CWidget
{
    public $forumId;

    public function run()
    {
        if ($this->forumId == 2) {
            $rubric = $this->getRubric();
            if ($rubric !== null) {
                $model = new CommunityContent();
                $model->type_id = CommunityContentType::TYPE_QUESTION;
                $model->rubric_id = $rubric->id;
                $slaveModel = new CommunityQuestion();
                $this->render('CommunityQuestionWidget', compact('model', 'slaveModel'));
            }
        }
    }

    protected function getRubric()
    {
        $criteria = new CDbCriteria();
        $criteria->compare('title', 'Вопросы будущих мам');
        $criteria->compare('community_id', $this->forumId);

        $rubric = CommunityRubric::model()->find($criteria);
        if ($rubric !== null)
            return $rubric;

        $rubric = new CommunityRubric();
        $rubric->title = 'Вопросы будущих мам';
        $rubric->community_id = $this->forumId;
        return $rubric->save() ? $rubric : null;
    }
}