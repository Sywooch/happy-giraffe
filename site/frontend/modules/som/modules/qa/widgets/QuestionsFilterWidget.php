<?php
/**
 * @author Никита
 * @date 24/03/16
 */

namespace site\frontend\modules\som\modules\qa\widgets;

use site\frontend\modules\som\modules\qa\controllers\DefaultController;

\Yii::import('zii.widgets.CMenu');

class QuestionsFilterWidget extends \CMenu
{
    public $tab;
    public $categoryId;
    public $htmlOptions = array(
        'class' => 'filter-menu',
    );
    public $itemCssClass = 'filter-menu_item';

    protected $tabs = array(
        DefaultController::TAB_NEW => 'Новые',
        DefaultController::TAB_POPULAR => 'Популярные',
        DefaultController::TAB_UNANSWERED => 'Без ответа',
    );

    public function init()
    {
        foreach ($this->tabs as $id => $label) {
            $url = array('/som/qa/default/index', 'tab' => $id);
            if ($this->categoryId !== null) {
                $url['categoryId'] = $this->categoryId;
            }
            $this->items[] = array(
                'label' => $label,
                'linkOptions' => array('class' => 'filter-menu_item_link'),
                'url' => $url,
            );
        }
        parent::init();
    }
}