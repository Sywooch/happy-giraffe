<?php
/**
 * Author: alexk984
 * Date: 30.08.12
 *
 * Ищет посты для комментирования в постах обычных пользователей
 *
 */
class UserPosts extends PostForCommentator
{
    protected $nextGroup = 'TrafficPosts';
    protected $entities = array(
        'CommunityContent',
    );

    /**
     * @param bool $simple_users
     * @return CDbCriteria
     */
    public function getCriteria($simple_users = true)
    {
        $criteria = new CDbCriteria;
        $criteria->select = 't.*';
        $criteria->condition = 't.created >= "' . date("Y-m-d H:i:s", strtotime('-48 hour')) . '" AND `full` IS NULL AND t.removed = 0';
        $criteria->with = array(
            'author' => array(
                'select'=>array('id'),
                'condition' => ($simple_users) ? 'author.group = 0' : 'author.group > 0',
                'together' => true,
            ),
        );

        return $criteria;
    }

    /**
     * Возвращает лимит комментариев для поста, зависит от кол-во постов у автора
     *
     * новички - 5 комментариев
     * 2-4 поста - 8 комментариев
     * 5 и более - 15 комментариев
     *
     * @param CommunityContent $post
     * @return int
     */
    protected function getCommentsLimit($post)
    {
        $author_posts_count = $post->author->communityContentsCount;
        if ($author_posts_count < 2)
            return 5;
        elseif ($author_posts_count < 5)
            return 8;
        else
            return 15;
    }
}
