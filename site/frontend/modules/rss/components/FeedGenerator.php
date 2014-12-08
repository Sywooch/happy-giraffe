<?php
/**
 * @author Никита
 * @date 03/12/14
 */

namespace site\frontend\modules\rss\components;

\Yii::import('ext.EFeed.*');

class FeedGenerator
{
    /**
     * @var \CDataProvider
     */
    public $dataProvider;

    /**
     * @var \EFeed
     */
    public $feed;

    public function __construct()
    {
        $this->feed = new \EFeed();
    }

    public function fill(\CActiveDataProvider $dataProvider, $page = 0)
    {
        $dataProvider->pagination->setCurrentPage($page);
        $data = $dataProvider->data;
        foreach ($data as $model) {
            $item = $this->getItemByModel($model);
            $this->feed->addItem($item);
        }
    }

    /** @todo исправить формирование ссылки на комментарии */
    protected function getItemByModel(\CActiveRecord $model)
    {
        if ($model->asa('RssBehavior') === null) {
            throw new \Exception('Model must have rss behavior attached');
        }

        $item = $this->feed->createNewItem();
        $item->addTag('guid', $model->getRssUrl(), array('isPermaLink' => 'true'));
        $item->addTag('author', \Yii::app()->controller->createAbsoluteUrl('/blog/default/index', array('user_id' => $model->getRssAuthor()->id)));
        $item->setDate($model->getRssDate());
        $item->setLink($model->getRssUrl(true));
        $item->setTitle($model->getRssTitle());
        $item->setDescription($model->getRssDescription());
        $item->addTag('comments', $model->getRssUrl() . '#comment_list');

        return $item;
    }
} 