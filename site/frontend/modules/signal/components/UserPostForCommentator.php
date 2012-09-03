<?php
/**
 * Author: alexk984
 * Date: 30.08.12
 */
class UserPostForCommentator extends PostForCommentator
{
    public static function getPost()
    {
        $posts = self::getPosts();
        $recipes = self::getRecipes();

        $all_count = count($recipes) + count($posts);
        if ($all_count == 0) {
            //check if all posts count is 0
            $criteria = self::getCriteria();
            $criteria->condition = self::maxTimeCondition();
            if (CommunityContent::model()->count($criteria) == 0)
                return MainPagePostForCommentator::getPost();
            else
                return self::getPost();
        } else {
            if (count($posts) == 0)
                return array('CookRecipe', $recipes[0]->id);
            if (count($recipes) == 0)
                return array('CommunityContent', $posts[0]->id);

            if ((rand(1, $all_count) < count($recipes)) && count($recipes) > 0) {
                return array('CookRecipe', $recipes[0]->id);
            } else {
                return array('CommunityContent', $posts[0]->id);
            }
        }
    }

    public static function getPosts()
    {
        $result = array();
        $criteria = self::getCriteria();

        $posts = CommunityContent::model()->findAll($criteria);
        foreach ($posts as $post)
            if ($post->commentsCount < CommentsLimit::getLimit('CommunityContent', $post->id, 50, 60))
                if (!self::recentlyCommented('CommunityContent', $post->id))
                    $result [] = $post;

        return $result;
    }

    public static function getRecipes()
    {
        $result = array();
        $criteria = self::getCriteria();

        $posts = CookRecipe::model()->findAll($criteria);
        foreach ($posts as $post)
            if ($post->commentsCount < CommentsLimit::getLimit('CookRecipe', $post->id, 2, 3))
                if (!self::recentlyCommented('CookRecipe', $post->id))
                    $result [] = $post;

        return $result;
    }
}
