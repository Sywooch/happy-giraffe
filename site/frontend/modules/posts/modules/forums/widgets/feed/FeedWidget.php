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

    /**
     * @var integer
     */
    public $labelId;

    protected $tabs = [
        self::TAB_NEW => 'Новые',
        self::TAB_HOT => 'Горячие',
        self::TAB_DISCUSS => 'Обсудить',
    ];

    public function init()
    {
        parent::init();
        if ($this->tab === null) {
            $this->tab = $this->defaultTab;
        }
    }

    public function run()
    {
        $this->render('index');
    }

    public function getMenuItems()
    {
        $items = [];
        foreach ($this->tabs as $tab => $label) {
            $items[] = [
                'label' => $label,
                'url' => $this->getUrl(['feedTab' => $tab]),
                'active' => $this->tab == $tab,
            ];
        }
        return $items;
    }

    public function getFilterItems()
    {
        $items = [
            [
                'label' => 'Все',
                'url' => $this->getUrl(['feedForumId' => null]),
                'active' => $this->forum == null,
            ],
        ];
        foreach ($this->club->communities as $forum) {
            $items[] = [
                'label' => $forum->title,
                'url' => $this->getUrl(['feedForumId' => $forum->id]),
                'active' => $this->forum->id == $forum->id,
            ];
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
    
    public function getTag(Content $post)
    {
        $rubricLabel = $post->getLabelByPrefix('Рубрика');

        if ($rubricLabel) {
            return [
                'text' => str_replace('Рубрика: ', '', $rubricLabel->text),
                //'url' => \Yii::app()->controller->createUrl('/posts/forums/default/club', ['club' => $this->club, 'label' => $rubricLabel->id]),
            ];
        }
        return null;
    }
    
    protected function applyLabelScopes(Content $model)
    {
        if ($this->labelId) {
            $model->byTags([$this->labelId]);
        } else {
            $labels = [$this->club->toLabel(), Label::LABEL_FORUMS];
            if ($this->forum) {
                $labels[] = $this->forum->toLabel();
            }
            $model->byLabels($labels);
        }
    }
}