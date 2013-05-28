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
        //проверяем на выполнение условий достижения
        ScoreAchievement::model()->checkAchieve($content->author_id, ScoreAchievement::TYPE_DAY_POSTS);

        if ($content->getIsFromBlog() && count($content->contentAuthor->contentBlogPosts) == 1)
            ScoreInputFirstBlogRecord::getInstance()->add($content->author_id);
        else {
            if ($content->type_id == CommunityContent::TYPE_POST)
                ScoreInputNewPost::getInstance()->add($content->author_id, $content);
            elseif ($content->type_id == CommunityContent::TYPE_VIDEO)
                ScoreInputNewVideo::getInstance()->add($content->author_id, $content);
        }
    }

    /**
     * Вычитаем баллы за удаление контента
     *
     * @param $content CommunityContent
     */
    public static function contentRemoved($content)
    {
        if ($content->getIsFromBlog() && count($content->contentAuthor->contentBlogPosts) == 0)
            ScoreInputFirstBlogRecord::getInstance()->remove($content->author_id);
        else {
            if ($content->type_id == CommunityContent::TYPE_POST)
                ScoreInputNewPost::getInstance()->add($content->author_id, $content);
            elseif ($content->type_id == CommunityContent::TYPE_VIDEO)
                ScoreInputNewVideo::getInstance()->add($content->author_id, $content);
        }
    }

    /**
     * Добавляем баллы за новый комментарий и проверяем достижения
     *
     * @param $comment Comment
     */
    public static function commentCreated($comment)
    {

    }

    /**
     * Добавляем баллы за новый комментарий и проверяем достижения
     *
     * @param $comment Comment
     */
    public static function commentRemoved($comment)
    {

    }

    /**
     * Добавляем баллы за новое фото и проверяем достижения
     *
     * @param $photo AlbumPhoto
     */
    public static function photoCreated($photo)
    {

    }

    /**
     * Вычитаем баллы за удаление фото
     *
     * @param $photo AlbumPhoto
     */
    public static function photoRemoved($photo)
    {

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

    }

    /**
     * Вычитаем баллы за потерю друга
     *
     * @param $user1_id int id нового друга
     * @param $user2_id int id нового друга
     */
    public static function friendRemoved($user1_id, $user2_id)
    {

    }
}