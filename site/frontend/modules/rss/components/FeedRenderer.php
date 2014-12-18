<?php
/**
 * @author Никита
 * @date 03/12/14
 */

namespace site\frontend\modules\rss\components;

use site\frontend\modules\rss\components\channels\RssChannelAbstract;

\Yii::import('ext.EFeed.*');

class FeedRenderer
{
    /** @var \site\frontend\modules\rss\components\channels\RssChannelAbstract */
    protected $channel;

    public function __construct(RssChannelAbstract $channel)
    {
        $this->channel = $channel;
    }

    public function run($page)
    {
        $feed = new \EFeed();
        if ($title = $this->channel->getTitle()) {
            $feed->setTitle($title);
        }
        if ($description = $this->channel->getDescription()) {
            $feed->setDescription($description);
        }
        if ($link = $this->channel->getLink()) {
            $feed->setLink($this->channel->getUrl());
        }
        foreach ($this->channel->getChannelTags() as $tag => $content) {
            $feed->addChannelTag($tag, $content);
        }
        if ($this->channel->dataProvider->pagination->pageCount > ($page + 1)) {
            $feed->addChannelTag('ya:more', $this->channel->getUrl($page + 1));
        }
        $this->fill($feed, $this->channel->dataProvider, $page);
        $feed->generateFeed();
    }

    public function fill(\EFeed &$feed, \CActiveDataProvider $dataProvider, $page = 0)
    {
        $dataProvider->pagination->setCurrentPage($page);
        $data = $dataProvider->data;
        foreach ($data as $model) {
            $item = $feed->createNewItem();
            $this->fillItemByModel($item, $model);
            $feed->addItem($item);
        }
    }

    /** @todo исправить формирование ссылки на комментарии */
    protected function fillItemByModel(\EFeedItemAbstract &$item, \CActiveRecord $model)
    {
        if ($model->asa('RssBehavior') === null) {
            throw new \Exception('Model must have rss behavior attached');
        }

        $item->addTag('guid', $model->getRssUrl(), array('isPermaLink' => 'true'));
        $item->addTag('author', \Yii::app()->controller->createAbsoluteUrl('/blog/default/index', array('user_id' => $model->getRssAuthor()->id)));
        $item->setDate($model->getRssDate());
        $item->setLink($model->getRssUrl(true));
        $item->setTitle($model->getRssTitle());
        $item->setDescription($model->getRssDescription());
        $item->addTag('comments', $model->getRssUrl() . '#comment_list');
    }
} 