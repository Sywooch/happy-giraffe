<?php
/**
 * Author: alexk984
 * Date: 30.08.12
 */
class PostsWithoutCommentsCommentator extends PostForCommentator
{
    const CACHE_ID = 'posts-without-comments';

    public static function getPost()
    {
        Yii::import('site.seo.models.*');
        Yii::import('site.seo.modules.promotion.models.*');
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
            return array('CommunityContent', $not_commented_yet[0]->id);
        }
    }

    public static function getPostIds()
    {
        $result = array();
        $posts = Yii::app()->cache->get(self::CACHE_ID);

        if (empty($posts))
            $posts = self::getNewPosts();

        if (!empty($posts))
            foreach ($posts as $post) {
                $model = CommunityContent::model()->active()->findByPk($post);
                if ($model !== null && $model->commentsCount < CommentsLimit::getLimit('CommunityContent', $post, 3, 6))
                    $result [] = $post;
            }

        if (empty($result)) {
            self::getNewPosts();
            return self::getPostIds();
        }

        return $result;
    }

    public static function getNewPosts()
    {
        $value = array();
        $criteria = new CDbCriteria(array(
            'condition' => 'comments.id IS NULL',
            'with' => array(
                'comments'=>array(
                    'select'=>'id',
                    'together'=>true,
                ),
                'rubric' => array(
                    'select'=>'id',
                    'condition' => 'user_id IS NULL',
                    'with' => array(
                        'community' => array(
                            'select' => 'id',
                        )
                    ),
                ),
            ),
            'limit' => 30,
            'order'=>'rand()'
        ));
        $posts = CommunityContent::model()->findAll($criteria);

        foreach($posts as $post){
            $criteria = new CDbCriteria;
            $criteria->compare('entity', $post->isFromBlog?'BlogContent':'CommunityContent');
            $criteria->compare('entity_id', $post->id);
            $page = Page::model()->with('phrases')->find($criteria);
            if ($page === null || empty($page->phrases))
                $value[] = $post->id;
        }

        Yii::app()->cache->set(self::CACHE_ID, $value);

        return $value;
    }
}
