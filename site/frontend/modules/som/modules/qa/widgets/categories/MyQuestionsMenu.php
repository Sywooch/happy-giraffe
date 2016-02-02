<?php
/**
 * @author Никита
 * @date 19/11/15
 */

namespace site\frontend\modules\som\modules\qa\widgets\categories;


use site\frontend\modules\som\modules\qa\models\QaCategory;
use site\frontend\modules\som\modules\qa\models\QaQuestion;

class MyQuestionsMenu extends CategoriesMenu
{
    public $userId;

    protected function getFirstItem()
    {
        $count = QaQuestion::model()->user($this->userId)->notConsultation()->count();
        return $this->getItem('Все', $count, array('/som/qa/my/questions/'));
    }

    protected function getCountByCategory(QaCategory $category)
    {
        return $category->questionsCount;
    }

    protected function getUrlByCategory(QaCategory $category)
    {
        return array(
            '/som/qa/my/questions/',
            'categoryId' => $category->id,
        );
    }

    protected function getCategories()
    {
        return QaCategory::model()->with(array('questionsCount' => array(
            'condition' => 'authorId = :userId',
            'params' => array(':userId' => $this->userId),
        )))->findAll();
    }
}