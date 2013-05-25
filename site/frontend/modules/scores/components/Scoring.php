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

        if ($content->isFromBlog) {
            UserAction::model()->add($content->author_id, UserAction::USER_ACTION_BLOG_CONTENT_ADDED, array('model' => $content));

            if ($content->type_id == CommunityContent::TYPE_VIDEO) {
                ScoreAchievement::model()->checkAchieve($content->author_id, ScoreAchievement::TYPE_VIDEO);
                ScoreInput::model()->add($content->author_id, ScoreInput::TYPE_VIDEO, array('model' => $content));
            } else {
                //проверяем на выполнение условий достижения
                ScoreAchievement::model()->checkAchieve($content->author_id, ScoreAchievement::TYPE_BLOG);

                if (count($content->contentAuthor->contentBlogPosts) == CommunityContent::TYPE_POST)
                    ScoreInput::model()->add($content->author_id, ScoreInput::TYPE_FIRST_BLOG_RECORD, array('model' => $content));
                else
                    ScoreInput::model()->add($content->author_id, ScoreInput::TYPE_POST_ADDED, array('model' => $content));
            }
        } elseif ($content->rubric->community_id != Community::COMMUNITY_NEWS) {
            //проверяем на выполнение условий достижения
            ScoreInput::model()->add($content->author_id, ScoreInput::TYPE_POST_ADDED, array('model' => $content));
        }
    }
}