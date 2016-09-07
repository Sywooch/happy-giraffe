<?php
/**
 * @author Никита
 * @date 18/11/15
 */

namespace site\frontend\modules\som\modules\qa\widgets\categories;


use site\frontend\modules\som\modules\qa\controllers\DefaultController;
use site\frontend\modules\som\modules\qa\models\QaCategory;
use site\frontend\modules\som\modules\qa\models\QaQuestion;

class MainCategoriesMenu extends CategoriesMenu
{

    /**
     * {@inheritDoc}
     * @see \site\frontend\modules\som\modules\qa\widgets\SidebarMenu::getItem()
     */
    protected function getItem($title, $count, $url, $categoryId = NULL)
    {
        $result = parent::getItem($title, $count, $url);

        if ($categoryId == QaCategory::PEDIATRICIAN_ID)
        {
            $result['linkOptions']['class'] .= ' questions-categories_pediator';
        }

        return $result;
    }

    protected function getFirstItem()
    {
        $count = QaQuestion::model()->notConsultation()->count();
        return $this->getItem('Все вопросы', $count, $this->augmentUrl(array('/som/qa/default/index/')));
    }

    protected function getCountByCategory(QaCategory $category)
    {
        return $category->questionsCount;
    }

    protected function getUrlByCategory(QaCategory $category)
    {
        return $this->augmentUrl(array(
            '/som/qa/default/index/',
            'categoryId' => $category->id,
        ));
    }

    protected function getCategories()
    {
        return QaCategory::model()->with('questionsCount')->sorted()->findAll();
    }

    protected function augmentUrl($url)
    {
        if (\Yii::app()->controller instanceof DefaultController && \Yii::app()->controller->action->id == 'index') {
            $url['tab'] = \Yii::app()->request->getQuery('tab');
        }
        return $url;
    }
}