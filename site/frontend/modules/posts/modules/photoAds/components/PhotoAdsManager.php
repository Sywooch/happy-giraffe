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
    public function getPosts($url, $onlyFavourite = false, $limit = -1, $exclude = array())
    {
        $posts = $this->getPostsInternal($url, $onlyFavourite, $limit, $exclude);
        $data = array();
        foreach ($posts as $post) {
            $collection = PhotoCollection::model()->findByAttributes(array(
                'entity' => $post->originEntity,
                'entity_id' => $post->originEntityId,
            ));
            preg_match('#community\/(\d+)\/forum\/\w+\/(\d+)#', $post->url, $matches);
            $forumId = $matches[1];
            $forum = \Community::model()->findByPk($forumId);
            $postData = $post->toJSON();
            $postData['sectionId'] = $forum->club->section_id;
            $data[] = array(
                'post' => $post,
                'collection' => $collection,
            );
        }
        return $data;
    }

    protected function getPostsInternal($url, $onlyFavourite, $limit, $exclude)
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
        $criteria->order = 'RAND()';
        $criteria->limit = $limit;
        $criteria->addSearchCondition('url', 'photoPost');
        $exclude[] = $postId;
        $criteria->addNotInCondition('t.id', $exclude);
        if ($onlyFavourite) {
            $this->onlyFavourite($criteria);
        }
        return Content::model()->byLabels(array($label))->findAll($criteria);
    }

    protected function onlyFavourite(\CDbCriteria &$criteria)
    {
        $favourites = \Favourites::model()->block(\Favourites::BLOCK_PHOTO_ADS)->findAll();
        $ids = array_map(function($f) {
            return $f->entity_id;
        }, $favourites);
        $criteria->addInCondition('t.id', $ids);
    }
}