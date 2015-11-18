<?php
/**
 * @author Никита
 * @date 12/11/15
 */

namespace site\frontend\modules\som\modules\qa\widgets;

use site\frontend\modules\som\modules\qa\models\QaCategory;
use site\frontend\modules\som\modules\qa\models\QaQuestion;


class CategoriesMenu extends SidebarMenu
{
    public function init()
    {
        $this->items[] = array(
            'label' => 'Все вопросы'  . '<span class="questions-categories_count">' . $this->getTotalCount() . '</span>',
            'url' => $this->augmentUrl(array('/som/qa/default/index/')),
        );

        $categories = $this->getCategories();
        foreach ($categories as $category) {
            $this->items[] = array(
                'label' => $category->title . '<span class="questions-categories_count">' . $category->questionsCount . '</span>',
                'url' => $this->augmentUrl(array(
                    '/som/qa/default/index/',
                    'categoryId' => $category->id,
                )),
                'linkOptions' => array('class' => 'questions-categories_link'),
            );
        }

        parent::init();
    }

    protected function augmentUrl($url)
    {
        if (isset(\Yii::app()->controller->actionParams['tab'])) {
            $url['tab'] = \Yii::app()->controller->actionParams['tab'];
        }
        return $url;
    }

    protected function getTotalCount()
    {
        return QaQuestion::model()->notConsultation()->count();
    }

    protected function getCategories()
    {
        return QaCategory::model()->with('questionsCount')->findAll();
    }
}