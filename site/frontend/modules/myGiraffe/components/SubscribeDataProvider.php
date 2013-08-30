<?php
/**
 * Выбор подписок пользователя
 *
 * @author Alex Kireev <alexk984@gmail.com>
 */
class SubscribeDataProvider
{
    const TYPE_ALL = 1;
    const TYPE_FRIENDS = 2;
    const TYPE_BLOGS = 3;
    const TYPE_COMMUNITY = 4;

    /**
     * Посты для страницы "Мой Жираф"
     *
     * @param int $user_id
     * @param int $type
     * @param int $community_id
     * @return CActiveDataProvider
     */
    public static function getDataProvider($user_id, $type, $community_id = null)
    {
        if (!empty($community_id))
            return CommunityContent::model()->getContents($community_id, null, null);
        if ($type == self::TYPE_FRIENDS)
            return self::getFriendsContent($user_id);
        if ($type == self::TYPE_BLOGS)
            return self::getBlogsContent($user_id);

        return new CActiveDataProvider('CommunityContent');
    }

    /**
     * Посты друзей
     * @param int $user_id
     * @return CActiveDataProvider
     */
    public static function getFriendsContent($user_id)
    {

        return new CActiveDataProvider('CommunityContent');
    }

    /**
     * Посты подписок на блоги
     *
     * @param int $user_id
     * @return CActiveDataProvider
     */
    public static function getBlogsContent($user_id)
    {
        $criteria = new CDbCriteria;
        $criteria->addInCondition('author_id', UserBlogSubscription::getSubUserIds($user_id));
        $criteria->order = 'id desc';
        return new CActiveDataProvider('CommunityContent');
    }
} 