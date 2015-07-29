<?php
namespace site\frontend\modules\posts\modules\photoAds\components;
use site\frontend\modules\photo\models\PhotoCollection;
use site\frontend\modules\posts\models\Content;

/**
 * @author Никита
 * @date 28/07/15
 */

class PhotoAdsManager
{
    public function getPosts($clubId, $limit = -1)
    {
        $posts = $this->getPostsInternal($clubId, $limit);
        $data = array();
        foreach ($posts as $post) {
            $collection = PhotoCollection::model()->findByAttributes(array(
                'entity' => $post->originEntity,
                'entity_id' => $post->originEntityId,
            ));
            $data[] = array(
                'post' => $post,
                'collection' => $collection,
            );
        }
        return $data;
    }

    protected function getPostsInternal($url, $limit)
    {
        if (! preg_match('#community\/(\d+)\/forum\/\w+\/(\d+)#', $url, $matches)) {
            return array();
        }

        $postId = $matches[2];
        $forumId = $matches[1];

        $forum = \Community::model()->findByPk($forumId);
        $club = $forum->club;
        $label = 'Клуб: ' . $club->title;

        $criteria = new \CDbCriteria();
        $criteria->limit = $limit;
        $criteria->addSearchCondition('url', 'photoPost');
        $criteria->compare('t.id', '<>' . $postId);
        return Content::model()->byLabels(array($label))->findAll($criteria);
    }
}