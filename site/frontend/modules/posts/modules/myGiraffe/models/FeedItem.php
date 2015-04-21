<?php
namespace site\frontend\modules\posts\modules\myGiraffe\models;

/**
 * @property int $id
 * @property int $userId
 * @property string $filter
 * @property int $postId
 * @property int dtimeCreate
 *
 * @property \site\frontend\modules\posts\models\Content $post
 *
 * @author Никита
 * @date 17/04/15
 */

class FeedItem extends \HActiveRecord
{
    public function tableName()
    {
        return 'myGiraffe__feed_items';
    }

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    public function relations()
    {
        return array(
            'post' => array(self::BELONGS_TO, 'site\frontend\modules\posts\models\Content', 'postId'),
        );
    }

    public function behaviors()
    {
        return array(
            'HTimestampBehavior' => array(
                'class' => 'HTimestampBehavior',
                'createAttribute' => 'dtimeCreate',
                'updateAttribute' => null,
            ),
        );
    }

    public function getListDataProvider($userId, $filter)
    {
        $criteria = new \CDbCriteria();
        $criteria->compare('userId', $userId);
        $criteria->compare('filter', $filter);
        $criteria->order = 'created DESC';

        return new \CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }
}