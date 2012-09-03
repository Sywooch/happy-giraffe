<?php
/**
 * Author: alexk984
 * Date: 30.08.12
 */
class CoWorkersPostCommentator extends PostForCommentator
{
    public static function getPost()
    {
        $criteria = self::getCriteria(false);
        $posts = self::getPosts($criteria);
        $recipes = self::getRecipes($criteria);

        $all_count = count($recipes) + count($posts);
        if ($all_count == 0) {

            if (self::isCategoryEmpty())
                return TrafficPostForCommentator::getPost();
            else
                return self::getPost();
        } else {

            if ((rand(1, $all_count) < count($recipes)) && count($recipes) > 0) {
                return array('CookRecipe', $recipes[0]->id);
            } else {
                return array('CommunityContent', $posts[0]->id);
            }
        }
    }

    public static function getPosts($criteria)
    {
        $result = array();

        $posts = CommunityContent::model()->findAll($criteria);
        foreach ($posts as $post)
            if ($post->commentsCount < CommentsLimit::getLimit('CommunityContent', $post->id, 50)) {
                $entity = $post->isFromBlog ? 'BlogContent' : 'CommunityContent';
                if (!self::recentlyCommented($entity, $post->id))
                    $result [] = $post;
            }

        return $result;
    }

    public static function getRecipes($criteria)
    {
        $result = array();

        $posts = CookRecipe::model()->findAll($criteria);
        foreach ($posts as $post)
            if ($post->commentsCount < CommentsLimit::getLimit('CookRecipe', $post->id, 2, 3))
                if (!self::recentlyCommented('CookRecipe', $post->id))
                    $result [] = $post;

        return $result;
    }

    public static function isCategoryEmpty()
    {
        $criteria = self::getCriteria(false);
        $criteria->condition = self::maxTimeCondition();

        $posts = self::getPosts($criteria);
        $recipes = self::getRecipes($criteria);

        if (count($posts) + count($recipes) == 0)
            return true;

        return false;
    }
}
