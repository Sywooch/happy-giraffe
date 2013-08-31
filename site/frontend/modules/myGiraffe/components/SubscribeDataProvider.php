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
            $criteria = self::getCommunityCriteria($community_id);
        elseif ($type == self::TYPE_FRIENDS)
            $criteria = self::getFriendsContent($user_id); elseif ($type == self::TYPE_BLOGS)
            $criteria = self::getBlogsCriteria($user_id); else
            $criteria = self::getAllContent($user_id);

        if (UserAttributes::get(Yii::app()->user->id, 'my_giraffe_only_new')) {
            $criteria->addNotInCondition('t.id', ViewedPost::getInstance()->viewed_ids);
            if (isset($_GET['page']))
                $_GET['page'] = 1;
        }

        $criteria->order = 't.id desc';

        return new CActiveDataProvider('CommunityContent', array(
            'criteria' => $criteria,
            'pagination' => array('pageVar' => 'page')
        ));
    }

    public static function getAllContent($user_id)
    {
        $criteria = new CDbCriteria;
        $criteria->with = array('rubric');
        $criteria->addInCondition('community_id', UserCommunitySubscription::getSubUserCommunities($user_id), 'OR');
        $criteria->addInCondition('author_id', UserBlogSubscription::getSubUserIds($user_id), 'OR');
        return $criteria;
    }

    /**
     * Посты друзей
     *
     * @param int $user_id
     * @return CActiveDataProvider
     */
    public static function getFriendsContent($user_id)
    {
        return new CActiveDataProvider('CommunityContent');
    }

    /**
     * @param int $community_id
     * @return mixed
     */
    public static function getCommunityCriteria($community_id)
    {
        $criteria = new CDbCriteria;
        $criteria->with = array('rubric');
        $criteria->compare('community_id', $community_id, false, 'OR');
        return $criteria;
    }

    /**
     * Посты подписок на блоги
     *
     * @param int $user_id
     * @return CActiveDataProvider
     */
    public static function getBlogsCriteria($user_id)
    {
        $criteria = new CDbCriteria;
        $criteria->addInCondition('author_id', UserBlogSubscription::getSubUserIds($user_id), 'OR');
        return $criteria;
    }
} 