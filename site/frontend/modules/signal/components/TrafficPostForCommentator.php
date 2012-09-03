<?php
/**
 * Author: alexk984
 * Date: 30.08.12
 */
class TrafficPostForCommentator extends PostForCommentator
{
    const CACHE_ID = 'traffic-posts-for-comments';

    public static function getPost()
    {
        $ids = self::getPostIds();

        $criteria = new CDbCriteria;
        $criteria->compare('id', $ids);
        $criteria->order = 'rand()';
        $posts = CommunityContent::model()->findAll($criteria);

        $not_commented_yet = array();
        foreach($posts as $post)
            if (!self::recentlyCommented('CommunityContent', $post->id))
                $not_commented_yet [] = $post;

        if (count($not_commented_yet) == 0) {
            return UserPostForCommentator::getPost();
        } else {
            return array('CommunityContent', $posts[0]->id);
        }
    }

    public static function getPostIds()
    {
        $posts = Yii::app()->cache->get(self::CACHE_ID);
        if (empty($posts))
            $posts = self::getNewPosts();

        $result = array();
        while (empty($result)) {
            $result = array();
            foreach ($posts as $post) {
                $model = CommunityContent::model()->active()->findByPk($post);
                if ($model !== null && $model->commentsCount < CommentsLimit::getLimit('CommunityContent', $post, 25))
                    $result [] = $post;
            }
            if (empty($result))
                $posts = self::getNewPosts();
        }

        return $result;
    }

    public static function getNewPosts()
    {
        $value = array();
        $date = strtotime('-1 month');

        if (date('Y', $date) != date('Y'))
            $phrases = Yii::app()->db_seo->createCommand()
                ->selectDistinct('search_phrase_id')
                ->from('pages_search_phrases_visits')
                ->where('week >= ' . date('W', $date) . ' AND year = ' . date('Y', $date) . ' OR year = ' . date('Y'))
                ->order('rand()')
                ->limit(100)
                ->queryColumn();
        else
            $phrases = Yii::app()->db_seo->createCommand()
                ->selectDistinct('search_phrase_id')
                ->from('pages_search_phrases_visits')
                ->where('week >= ' . date('W', $date) . ' AND year = ' . date('Y', $date))
                ->queryColumn();

        if (empty($phrases))
            return array();

        $pageIds = Yii::app()->db_seo->createCommand()
            ->selectDistinct('page_id')
            ->from('pages_search_phrases')
            ->where('id IN (' . implode(',', $phrases) . ')')
            ->queryColumn();

        if (empty($pageIds))
            return array();

        $pages = Yii::app()->db_seo->createCommand()
            ->select(array('entity', 'entity_id'))
            ->from('pages')
            ->where('id IN (' . implode(',', $pageIds) . ')')
            ->queryAll();

        foreach ($pages as $row) {
            if ($row['entity'] == 'CommunityContent' || $row['entity'] == 'BlogContent') {
                $model = CActiveRecord::model($row['entity'])->active()->findByPk($row['entity_id']);
                if ($model !== null && $model->commentsCount < CommentsLimit::getLimit('CommunityContent', $model->id, 25))
                    $value [] = $row['entity_id'];

                if (count($value) > 10)
                    break;
            }
        }

        Yii::app()->cache->set(self::CACHE_ID, $value);

        return $value;
    }
}
