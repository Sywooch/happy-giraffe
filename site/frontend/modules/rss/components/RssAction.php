<?php

namespace site\frontend\modules\rss\components;

/**
 * @author Никита
 * @date 28/11/14
 */

use Aws\CloudFront\Exception\Exception;

\Yii::import('ext.EFeed.*');

class RssAction extends \CAction
{
    /**
     * @var \CDataProvider
     */
    public $dataProvider;

    /**
     * @var \EFeed
     */
    protected $feed;

    public function run()
    {
        $this->feed = new \EFeed();
        $data = $this->dataProvider->data;
        foreach ($data as $model) {
            $item = $this->getItemByModel($model);
            $this->feed->addItem($item);
        }
        $this->feed->generateFeed();
    }

    protected function getItemByModel(\CActiveRecord $model)
    {
        if (! ($model instanceof IRss)) {
            throw new Exception('Model must implement IRss interface');
        }

        $item = $this->feed->createNewItem();
        $item->setTitle($model->getTitle());
        $item->setDescription($model->getDescription());
        $item->setDate($model->getDate());
        return $item;
    }
} 