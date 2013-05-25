<?php
/**
 * Начисление баллов за действия пользователя
 *
 * @author Alex Kireev <alexk984@gmail.com>
 */
class Scoring
{
    /**
     * @param $content CommunityContent
     */
    public static function contentCreated($content)
    {
        //проверяем на выполнение условий достижения
        ScoreAchievement::model()->checkAchieve($content->author_id, ScoreAchievement::TYPE_DAY_POSTS);

        if ($content->isFromBlog && count($content->contentAuthor->contentBlogPosts) == 1)
            ScoreInputFirstBlogRecord::getInstance()->add($content->author_id, $content);
        else {
            ScoreInput::model()->add($content->author_id, ScoreInput::TYPE_POST_ADDED, array('model' => $content));
        }
    }
}