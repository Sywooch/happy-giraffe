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
    protected $feed;

    public function __construct(\CDataProvider $dataProvider)
    {
        $this->dataProvider = $dataProvider;
    }

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

    /** @todo исправить формирование ссылки на комментарии */
    protected function getItemByModel(\CActiveRecord $model)
    {
        if ($model->asa('RssBehavior') === null) {
            throw new \Exception('Model must have rss behavior attached');
        }

        if ($model->asa('UrlBehavior') === null) {
            throw new \Exception('Model must have url behavior attached');
        }

        $item = $this->feed->createNewItem();
        $item->addTag('guid', $model->getUrl(true), array('isPermaLink' => 'true'));
        $item->addTag('author', \Yii::app()->controller->createAbsoluteUrl('/blog/default/index', array('user_id' => $model->getAuthor()->id)));
        $item->setDate($model->getDate());
        $item->setLink($model->getUrl(true));
        $item->setTitle($model->getTitle());
        $item->setDescription($model->getDescription());
        $item->addTag('comments', $model->getUrl(true) . '#comment_list');

        return $item;
    }
} 