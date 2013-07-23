<?php
/**
 * Начисление баллов за действия пользователя. Через компонент проходят те события которые
 * могут породить по несколько начислений, например просто баллы, достижение, трофей
 *
 * @author Alex Kireev <alexk984@gmail.com>
 */
class Scoring
{
    /**
     * Добавляем за новый контент и проверяем достижения
     *
     * @param $content CommunityContent
     */
    public static function contentCreated($content)
    {
        if ($content->getIsFromBlog() && $content->author->blogPostsCount == 1)
            ScoreInputFirstBlogRecord::getInstance()->add($content->author_id);
        else {
            if ($content->type_id == CommunityContent::TYPE_POST) {
                //запись
                ScoreInputNewPost::getInstance()->add($content->author_id, $content);
                if ($content->getIsFromBlog())
                    ScoreAchievement::model()->checkAchieve($content->author_id, ScoreAchievement::TYPE_BLOG);
                else
                    ScoreAchievement::model()->checkAchieve($content->author_id, ScoreAchievement::TYPE_CLUB_POSTS);
            } elseif ($content->type_id == CommunityContent::TYPE_VIDEO) {
                //видео
                ScoreInputNewVideo::getInstance()->add($content->author_id, $content);
                ScoreAchievement::model()->checkAchieve($content->author_id, ScoreAchievement::TYPE_VIDEO);
            }
        }

        //проверяем на выполнение условий достижения
        ScoreAchievement::model()->checkAchieve($content->author_id, ScoreAchievement::TYPE_DAY_POSTS);
    }

    /**
     * Вычитаем баллы за удаление контента
     *
     * @param $content CommunityContent
     */
    public static function contentRemoved($content)
    {
        if ($content->getIsFromBlog() && $content->author->blogPostsCount == 1)
            ScoreInputFirstBlogRecord::getInstance()->remove($content->author_id);
        else {
            if ($content->type_id == CommunityContent::TYPE_POST)
                ScoreInputNewPost::getInstance()->remove($content->author_id, $content);
            elseif ($content->type_id == CommunityContent::TYPE_VIDEO)
                ScoreInputNewVideo::getInstance()->remove($content->author_id, $content);
        }
    }

    /**
     * Добавляем баллы за новый комментарий и проверяем достижения
     *
     * @param $comment Comment
     */
    public static function commentCreated($comment)
    {
        ScoreInputNewComment::getInstance()->add($comment->author_id, $comment->id);
        ScoreAchievement::model()->checkAchieve($comment->author_id, ScoreAchievement::TYPE_COMMENTS);
    }

    /**
     * Добавляем баллы за новый комментарий и проверяем достижения
     *
     * @param $comment Comment
     */
    public static function commentRemoved($comment)
    {
        ScoreInputNewComment::getInstance()->remove($comment->author_id, $comment->id);
    }

    /**
     * Добавляем баллы за новое фото и проверяем достижения
     *
     * @param $photo AlbumPhoto
     */
    public static function photoCreated($photo)
    {
        ScoreInputNewPhoto::getInstance()->add($photo->author_id, $photo->id);
        ScoreAchievement::model()->checkAchieve($photo->author_id, ScoreAchievement::TYPE_PHOTO);
    }

    /**
     * Вычитаем баллы за удаление фото
     *
     * @param $photo AlbumPhoto
     */
    public static function photoRemoved($photo)
    {
        ScoreInputNewPhoto::getInstance()->remove($photo->author_id, $photo->id);
    }

    /**
     * @param $user_id int id пользователя
     */
    public static function visit($user_id)
    {
        ScoreVisits::getInstance()->addTodayVisit($user_id);
    }

    /**
     * Добавляем баллы за нового друга и проверяем достижения
     *
     * @param $user1_id int id нового друга
     * @param $user2_id int id нового друга
     */
    public static function friendAdded($user1_id, $user2_id)
    {
        ScoreInputNewFriend::getInstance()->add($user1_id, $user2_id);

        ScoreAchievement::model()->checkAchieve($user1_id, ScoreAchievement::TYPE_FRIENDS);
        ScoreAchievement::model()->checkAchieve($user2_id, ScoreAchievement::TYPE_FRIENDS);
    }

    /**
     * Вычитаем баллы за потерю друга
     *
     * @param $user1_id int id нового друга
     * @param $user2_id int id нового друга
     */
    public static function friendRemoved($user1_id, $user2_id)
    {
        ScoreInputNewFriend::getInstance()->remove($user1_id, $user2_id);
    }
}