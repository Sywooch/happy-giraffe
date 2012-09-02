<?php
/**
 * Author: alexk984
 * Date: 30.08.12
 */
class SocialPostForCommentator extends PostForCommentator
{
    public static function getPost()
    {
        $posts = self::getPosts();

        if (empty($posts)) {
            return UserPostForCommentator::getPost();
        } else {
            return array('CommunityContent', $posts[0]->id);
        }
    }

    public static function getPosts()
    {
        $result = array();
        $criteria = self::getSimpleCriteria();
        $ids = array_merge(Favourites::getIdList(Favourites::SOCIAL_NETWORKS));
        if (empty($ids))
            return array();

        $criteria->compare('id', $ids);
        $posts = CommunityContent::model()->findAll($criteria);

        foreach ($posts as $post)
            if ($post->commentsCount < CommentsLimit::getLimit('CommunityContent', $post->id, 40))
                if (!self::recentlyCommented('CommunityContent', $post->id))
                    $result [] = $post;

        if (count($result) == 0) {
            //check if all posts count is 0
            $criteria = self::getSimpleCriteria();
            $criteria->condition = self::maxTimeCondition();
            $criteria->compare('id', $ids);
            $posts = CommunityContent::model()->findAll($criteria);
            if (count($posts) == 0)
                return array();
            else
                return self::getPosts();
        }

        return $result;
    }
}
