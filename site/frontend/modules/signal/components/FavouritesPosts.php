<?php
/**
 * Author: alexk984
 * Date: 30.08.12
 *
 * Ищет посты для комментирования в постах который добавлены на главную, в соц сети или в рассылку
 */
class FavouritesPosts extends PostForCommentator
{
    protected $nextGroup = 'UserPosts';
    protected $entities = array(
        'CommunityContent',
    );

    /**
     * @return CDbCriteria
     */
    public function getCriteria()
    {
        $ids = array_merge(Favourites::getIdList(Favourites::BLOCK_INTERESTING, 4),
            Favourites::getIdList(Favourites::BLOCK_BLOGS, 12),
            Favourites::getIdList(Favourites::BLOCK_SOCIAL_NETWORKS, 5),
            Favourites::getIdList(Favourites::WEEKLY_MAIL, 6)
        );

        if (empty($ids))
            return null;

        $criteria = new CDbCriteria;
        $criteria->condition = '`full` IS NULL AND t.removed = 0';
        $criteria->compare('t.id', $ids);

        return $criteria;
    }
}
