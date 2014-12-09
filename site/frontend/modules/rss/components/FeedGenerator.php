<?php
/**
 * @author Никита
 * @date 03/12/14
 */

namespace site\frontend\modules\rss\components;

\Yii::import('ext.EFeed.*');

class FeedGenerator
{
    public static function fill(\EFeed &$feed, \CActiveDataProvider $dataProvider, $page = 0)
    {
        $dataProvider->pagination->setCurrentPage($page);
        $data = $dataProvider->data;
        foreach ($data as $model) {
            $item = self::getItemByModel($feed, $model);
            $feed->addItem($item);
        }
    }

    /** @todo исправить формирование ссылки на комментарии */
    protected static function getItemByModel(\EFeed $feed, \CActiveRecord $model)
    {
        if ($model->asa('RssBehavior') === null) {
            throw new \Exception('Model must have rss behavior attached');
        }

        $item = $feed->createNewItem();
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