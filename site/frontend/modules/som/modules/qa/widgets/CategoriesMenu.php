<?php
/**
 * @author Никита
 * @date 12/11/15
 */

namespace site\frontend\modules\som\modules\qa\widgets;

use site\frontend\modules\som\modules\qa\models\QaCategory;



class CategoriesMenu extends SidebarMenu
{
    public function init()
    {
        $this->items = array_map(function(QaCategory $category) {
            $url = array(
                '/som/qa/default/index/',
                'categoryId' => $category->id,
            );
            if (isset(\Yii::app()->controller->actionParams['tab'])) {
                $url['tab'] = \Yii::app()->controller->actionParams['tab'];
            }
            return array(
                'label' => $category->title . '<span class="questions-categories_count">' . $category->questionsCount . '</span>',
                'url' => $url,
                'linkOptions' => array('class' => 'questions-categories_link'),
            );
        }, $this->getCategories());
        parent::init();
    }

    protected function getCategories()
    {
        return QaCategory::model()->with('questionsCount')->findAll();
    }
}