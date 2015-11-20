<?php
/**
 * @author Никита
 * @date 19/11/15
 */

namespace site\frontend\modules\som\modules\qa\widgets\categories;


use site\frontend\modules\som\modules\qa\models\QaAnswer;
use site\frontend\modules\som\modules\qa\models\QaCategory;
use site\frontend\modules\som\modules\qa\models\QaQuestion;

class MyAnswersMenu extends CategoriesMenu
{
    public $userId;

    private $_counters;

    public function init()
    {
        $criteria = clone QaAnswer::model()->user($this->userId)->getDbCriteria();
        $criteria->select = 'categoryId, COUNT(*) c';
        $criteria->join = 'JOIN ' . QaQuestion::model()->tableName() . ' q ON q.id = t.questionId';
        $criteria->group = 'categoryId';
        $command = \Yii::app()->db->getCommandBuilder()->createFindCommand(QaAnswer::model()->tableName(), $criteria);
        $counters = $command->queryAll();
        foreach ($counters as $row) {
            $this->_counters[$row['categoryId']] = $row['c'];
        }
        parent::init();
    }

    protected function getFirstItem()
    {
        $count = QaAnswer::model()->user($this->userId)->notConsultation()->count();
        return $this->getItem('Все', $count, array('/som/qa/my/answers/'));
    }

    protected function getCountByCategory(QaCategory $category)
    {
        return isset($this->_counters[$category->id]) ? $this->_counters[$category->id] : 0;
    }

    protected function getUrlByCategory(QaCategory $category)
    {
        return array(
            '/som/qa/my/answers/',
            'categoryId' => $category->id,
        );
    }

    protected function getCategories()
    {
        return QaCategory::model()->findAll();
    }
}