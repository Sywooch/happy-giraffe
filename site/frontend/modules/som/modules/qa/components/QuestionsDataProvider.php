<?php
/**
 * @author Никита
 * @date 12/11/15
 */

namespace site\frontend\modules\som\modules\qa\components;


use site\frontend\modules\som\modules\qa\models\QaCategory;

class QuestionsDataProvider extends \CActiveDataProvider
{

    protected function fetchData()
    {
        $data = parent::fetchData();

        $ids = array();
        /** @var \site\frontend\modules\som\modules\qa\models\QaQuestion $question */
        foreach ($data as $question) {
            $ids[] = $question->categoryId;
        }

        $criteria = new \CDbCriteria();
        $criteria->addInCondition('t.id', $ids);
        $criteria->index = 'id';
        $categories = QaCategory::model()->findAll($criteria);

        /** @var \site\frontend\modules\som\modules\qa\models\QaQuestion $question */
        foreach ($data as &$question) {
            $question->addRelatedRecord('category', $categories[$question->categoryId], false);
        }

        return $data;
    }
}