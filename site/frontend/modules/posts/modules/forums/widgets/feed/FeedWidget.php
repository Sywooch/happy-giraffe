<?php

namespace site\frontend\modules\posts\modules\forums\widgets\feed;
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
     * @var string
     */
    public $tab;

    protected $tabs = [
        self::TAB_NEW => 'Новые',
        self::TAB_HOT => 'Горячие',
        self::TAB_DISCUSS => 'Обсудить',
    ];

    public function init()
    {
        parent::init();
        if ($this->tab === null) {
            $this->tab = self::TAB_NEW;
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
                'url' => ['/posts/forums/default/club', 'club' => $this->club->slug, 'tab' => $tab],
                'active' => $this->tab == $tab,
            ];
        }
        return $items;
    }

    public function getListDataProvider()
    {
        $model = clone \site\frontend\modules\posts\models\Content::model();
        switch ($this->tab) {
            case self::TAB_NEW:
                $model->orderDesc();
                break;
            case self::TAB_HOT:
                $model->orderHotRate();
                break;
            case self::TAB_DISCUSS:
                $model->uncommented();
                break;
        }
        $model
            ->byLabels([$this->club->toLabel()])
            ->with('commentsCount', 'commentatorsCount')
            ->apiWith('user')
        ;
        return new \CActiveDataProvider('\site\frontend\modules\posts\models\Content', [
            'criteria' => $model->getDbCriteria(),
        ]);
    }
}