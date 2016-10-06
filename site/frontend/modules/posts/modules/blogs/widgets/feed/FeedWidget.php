<?php

namespace site\frontend\modules\posts\modules\blogs\widgets\feed;

use site\frontend\modules\posts\models\Content;
use site\frontend\modules\posts\models\Label;

use site\frontend\modules\som\modules\activity\models\Activity;

/**
 * @author Sergey Gubarev
 */
class FeedWidget extends \CWidget
{

    const TAB_NEW      = 'new';
    const TAB_HOT      = 'hot';
    const TAB_DISCUSS  = 'discuss';
    const TAB_COMMENTS = 'comments';

    //-----------------------------------------------------------------------------------------------------------

    /**
     * Текущая вкладка
     *
     * @var string
     */
    public $tab;

    /**
     * Вкладка по умолчанию
     *
     * @var string
     */
    public $defaultTab = self::TAB_NEW;

    /**
     * Используемые вкладки
     *
     * @var array
     */
    private $_tabs = [
        self::TAB_NEW      => 'Новые',
        self::TAB_HOT      => 'Горячие',
        self::TAB_DISCUSS  => 'Обсудить',
        self::TAB_COMMENTS => 'Комментарии',
    ];

    //-----------------------------------------------------------------------------------------------------------

    /**
     * {@inheritDoc}
     * @see CWidget::init()
     */
    public function init()
    {
        parent::init();

        if (is_null($this->tab))
        {
            $this->tab = $this->defaultTab;
        }
        else
        {
            if (! isset($this->_tabs[$this->tab]))
            {
                throw new \CHttpException(404,'Некорректный запрос');
            }
        }
    }

    /**
     * {@inheritDoc}
     * @see CWidget::run()
     */
    public function run()
    {
        if ($this->tab === self::TAB_COMMENTS)
        {
            $criteria = Activity::model()
                ->onlyComments()
                ->getDbCriteria()
            ;

            $perPage = $this->controller->module->getConfig('commentsPerPage');

            $this->render('comments', compact('criteria', 'perPage'));
        }
        else
        {
            $maxTextLength = $this->controller->module->getConfig('maxTextLength');

            $this->render('posts', compact('maxTextLength'));
        }
    }

    /**
     * Вкладки
     *
     * @return CMenu
     */
    public function getMenuWidget()
    {
        $items = [];

        foreach ($this->_tabs as $tab => $label)
        {
            $items[] = [
                'label'       => $label,
                'url'         => $this->getUrl($tab),
                'linkOptions' => [
                    'class' => $this->tab == $tab ? 'active' : NULL
                ],
            ];
        }

        return \Yii::app()->controller->createWidget('zii.widgets.CMenu', [
            'items'       => $items,
            'htmlOptions' => [
                'class' => 'b-filter',
            ],
            'itemCssClass' => 'b-filter_item',
        ]);
    }

    /**
     * URL для каждой вкладки
     *
     * @param string $tab
     * @return string
     */
    public function getUrl($tab)
    {
        return \Yii::app()->controller->createUrl('/blogs/' . $tab);
    }

    /**
     * @return \CActiveDataProvider
     */
    public function getListDataProvider()
    {
        $dependency = new \CDbCacheDependency('SELECT MAX(dtimePublication) FROM ' . Content::model()->tableName());

        $model = Content::model()
            ->cache(60, $dependency, 2)
            ->byLabels([
                Label::LABEL_BLOG
            ])
        ;

        switch ($this->tab)
        {
            case self::TAB_NEW:
                $model->orderDesc();
                break;

            case self::TAB_HOT:
                $model->orderHotRate();
                break;

            case self::TAB_DISCUSS:
                $model
                    ->orderDesc()
                    ->uncommentedBlogs()
                ;
                break;
        }

        $criteria = $model->getDbCriteria();

        $model->resetScope(false);

        $perPage = $this->controller->module->getConfig('postsPerPage');

        return new \CActiveDataProvider($model, [
            'criteria'   => $criteria,
            'pagination' => [
                'pageSize' => $perPage,
                'pageVar'  => 'page'
            ],
        ]);
    }

}