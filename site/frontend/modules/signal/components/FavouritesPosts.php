<?php
/**
 * Ищет посты для комментирования в постах который добавлены на главную, в соц сети или в рассылку
 *
 * @author alexk984
 */
class FavouritesPosts extends PostForCommentator
{
    protected $nextGroup = 'UserPosts';

    /**
     * @return CDbCriteria
     */
    public function getCriteria()
    {
        $ids = array_merge(
            Favourites::getListForCommentators(Favourites::BLOCK_INTERESTING),
            Favourites::getListForCommentators(Favourites::BLOCK_BLOGS),
            Favourites::getListForCommentators(Favourites::BLOCK_SOCIAL_NETWORKS),
            Favourites::getListForCommentators(Favourites::WEEKLY_MAIL)
        );

        if (empty($ids))
            return null;

        $criteria = new CDbCriteria;
        $criteria->condition = '`full` IS NULL AND t.removed = 0 AND t.author_id != :user_id';
        $criteria->params = array(':user_id' => Yii::app()->user->id);
        $criteria->compare('t.id', $ids);

        return $criteria;
    }
}
