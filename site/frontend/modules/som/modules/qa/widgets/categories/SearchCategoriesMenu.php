<?php
/**
 * @author Никита
 * @date 28/03/16
 */

namespace site\frontend\modules\som\modules\qa\widgets\categories;


use site\frontend\modules\som\modules\qa\models\QaCategory;

class SearchCategoriesMenu extends CategoriesMenu
{
    public $query;

    private $_counters;

    protected function getFirstItem()
    {
        $total = array_sum($this->counters);
        return $this->getItem('Все вопросы', $total, array('/som/qa/default/search/', 'query' => $this->query));
    }

    protected function getCountByCategory(QaCategory $category)
    {
        return isset($this->counters[$category->id]) ? $this->counters[$category->id] : 0;
    }

    protected function getUrlByCategory(QaCategory $category)
    {
        return array(
            '/som/qa/default/search/',
            'categoryId' => $category->id,
            'query' => $this->query,
        );
    }

    protected function getCategories()
    {
        return QaCategory::model()->sorted()->findAll();
    }

    public function getCounters()
    {
        if ($this->_counters === null) {
            $searchCriteria = new \stdClass();
            $searchCriteria->select = 'categoryId, @count';
            $searchCriteria->paginator = new \CPagination();
            $searchCriteria->query = $this->query;
            $searchCriteria->groupby = array('field' => 'categoryId', 'mode' => 4, 'order' => "@group desc");
            $searchCriteria->from = 'qa';
            $result = \Yii::app()->search->searchRaw($searchCriteria);
            $_result = array();
            foreach ($result['matches'] as $row) {
                $_result[$row['attrs']['categoryid']] = $row['attrs']['@count'];
            }
            $this->_counters = $_result;
        }
        return $this->_counters;
    }

}