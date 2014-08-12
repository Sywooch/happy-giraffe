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
        if (isset($_GET['BlogContent_page'])) {
            return true;
        }

        $criteria = new CDbCriteria(array(
            'condition' => 't.removed = 0 AND t.author_id = :user_id AND (t.uniqueness >= 50 OR t.uniqueness IS NULL AND t.type_id != :status)',
            'params' => array(':user_id' => $user->id, ':status' => CommunityContent::TYPE_STATUS),
        ));

        $count = CommunityContent::model()->count($criteria);
        return $count == 0;
    }

    protected  static function byPost(CommunityContent $post)
    {
        return (is_int($post->uniqueness) && $post->uniqueness < 50) || $post->type_id == CommunityContent::TYPE_STATUS;
    }
} 