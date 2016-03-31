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
    public $categoryId;

    public function init()
    {
        $firstItem = $this->getFirstItem();
        $firstItem['active'] = $this->categoryId === null;
        $this->items[] = $firstItem;

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
        $item = $this->getItem($category->title, $this->getCountByCategory($category), $this->getUrlByCategory($category));
        $item['active'] = $category->id == $this->categoryId;
        return $item;
    }

    abstract protected function getFirstItem();
    abstract protected function getCountByCategory(QaCategory $category);
    abstract protected function getUrlByCategory(QaCategory $category);
    abstract protected function getCategories();
}