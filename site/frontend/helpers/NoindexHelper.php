<?php
/**
 * Created by PhpStorm.
 * User: mikita
 * Date: 11/08/14
 * Time: 16:49
 */

class NoindexHelper
{
    public static function setNoIndex($model)
    {
        $noindex = false;

        if ($model instanceof CommunityContent) {
            $noindex = self::byPost($model);
        }
        if ($model instanceof User) {
            $noindex = self::byUser($model);
        }

        if ($noindex) {
            Yii::app()->clientScript->registerMetaTag('noindex', 'robots');
        }
    }

    protected  static function byUser(User $user)
    {
        $criteria = new CDbCriteria(array(
            'condition' => 't.removed = 0 AND t.author_id = :user_id AND (c.uniqueness >= 50 OR c.uniqueness IS NULL)',
            'params' => array(':user_id' => $user->id),
        ));

        $count = CommunityContent::model()->count($criteria);
        return $count == 0;
    }

    protected  static function byPost(CommunityContent $post)
    {
        return (is_int($post->uniqueness) && $post->uniqueness < 50) || $post->type_id == CommunityContent::TYPE_STATUS;
    }
} 