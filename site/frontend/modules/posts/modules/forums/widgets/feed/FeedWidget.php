<?php

namespace site\frontend\modules\posts\modules\forums\widgets\feed;
use site\frontend\modules\posts\models\Content;
use site\frontend\modules\posts\models\Label;
use site\frontend\modules\som\modules\community\models\api\CommunityClub;

/**
 * @author Никита
 * @date 07/06/16
 */
class FeedWidget extends \CWidget
{
    const TAB_NEW = 'new';
    const TAB_HOT = 'hot';
    const TAB_DISCUSS = 'discuss';

    /**
     * @var CommunityClub
     */
    public $club;

    /**
     * @var \Community
     */
    public $forum;

    /**
     * @var string
     */
    public $tab;

    /**
     * @var string
     */
    public $defaultTab = self::TAB_NEW;

    protected $tabs = [
        self::TAB_NEW => 'Новые',
        self::TAB_HOT => 'Горячие',
        self::TAB_DISCUSS => 'Обсудить',
    ];

    public function init()
    {
        parent::init();
        if ($this->forum) {
            unset($this->tabs[self::TAB_HOT]);
        }
        if ($this->tab === null || ! isset ($this->tabs[$this->tab])) {
            $this->tab = $this->defaultTab;
        }
    }

    public function run()
    {
        $this->render('index');
    }

    public function getMenuWidget()
    {
        $items = [];
        foreach ($this->tabs as $tab => $label) {
            $items[] = [
                'label' => $label,
                'url' => $this->getUrl(['feedTab' => $tab]),
                'active' => $this->tab == $tab,
                'linkOptions' => ['class' => 'filter-menu_item_link'],
            ];
        }
        return \Yii::app()->controller->createWidget('zii.widgets.CMenu', [
            'items' => $items,
            'htmlOptions' => [
                'class' => 'filter-menu filter-menu_position',
            ],
            'itemCssClass' => 'filter-menu_item',
        ]);
    }
    
    public function getShowFilter()
    {
        return count($this->club->communities) > 1;
    }

    public function getFilterItems()
    {
        $items = [
            $this->getUrl(['feedForumId' => null]) => 'Все',
        ];
        foreach ($this->club->communities as $forum) {
            $items[$this->getUrl(['feedForumId' => $forum->id])] = $forum->title;
        }
        return $items;
    }

    public function getUrl($params)
    {
        $params = \CMap::mergeArray($_GET, $params);
        $params = array_filter($params);
        if (isset($params['feedTab']) && $params['feedTab'] == $this->defaultTab) {
            unset($params['feedTab']);
        }
        return \Yii::app()->controller->createUrl('/posts/forums/default/club', $params);
    }

    public function getListDataProvider()
    {
        $model = \site\frontend\modules\posts\models\Content::model();
        switch ($this->tab) {
            case self::TAB_NEW:
                $model->orderDesc();
                break;
            case self::TAB_HOT:
                $model->orderHotRate();
                break;
            case self::TAB_DISCUSS:
                $model->orderDesc()->uncommented();
                break;
        }
        $model
            ->with('commentsCount', 'commentatorsCount')
        ;
        $this->applyLabelScopes($model);
        $criteria = $model->getDbCriteria();
        $model->resetScope(false);
        return new \CActiveDataProvider($model->apiWith('user'), [
            'criteria' => $criteria,
        ]);
    }
    
    protected function applyLabelScopes(Content $model)
    {
        $labels = [$this->club->toLabel(), Label::LABEL_FORUMS];
        if ($this->forum) {
            $labels[] = $this->forum->toLabel();
        }
        $model->byLabels($labels);
    }
}