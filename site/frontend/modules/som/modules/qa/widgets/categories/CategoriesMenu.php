<?php
/**
 * @author Никита
 * @date 12/11/15
 */

namespace site\frontend\modules\som\modules\qa\widgets\categories;

use site\frontend\modules\som\modules\qa\models\QaCategory;
use site\frontend\modules\som\modules\qa\models\QaQuestion;
use site\frontend\modules\som\modules\qa\widgets\SidebarMenu;


abstract class CategoriesMenu extends SidebarMenu
{
    public function init()
    {
        $this->items[] = $this->getFirstItem();

        $categories = $this->getCategories();
        foreach ($categories as $category) {
            if ($this->getCountByCategory($category) > 0) {
                $this->items[] = $this->getItemByCategory($category);
            }
        }

        parent::init();
    }

    protected function getItemByCategory(QaCategory $category)
    {
        return $this->getItem($category->title, $this->getCountByCategory($category), $this->getUrlByCategory($category));
    }

    protected function getItem($title, $count, $url)
    {
        return array(
            'label' => $title . \CHtml::tag('span', array('class' => 'questions-categories_count'), $count),
            'url' => $url,
            'linkOptions' => array('class' => 'questions-categories_link'),
        );
    }

    abstract protected function getFirstItem();
    abstract protected function getCountByCategory(QaCategory $category);
    abstract protected function getUrlByCategory(QaCategory $category);
    abstract protected function getCategories();
}