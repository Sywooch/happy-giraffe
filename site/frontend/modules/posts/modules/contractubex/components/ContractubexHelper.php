<?php
namespace site\frontend\modules\posts\modules\contractubex\components;
use site\frontend\modules\posts\models\Content;

/**
 * @author Никита
 * @date 03/12/15
 */

class ContractubexHelper
{
    public static function getForum()
    {
        $title = self::getTitle();
        $forum = \Community::model()->findByAttributes(array('title' => $title));
        if ($forum === null) {
            $forum = new \Community();
            $forum->title = $title;
            $forum->save(false);

            $rubric = new \CommunityRubric();
            $rubric->title = $title;
            $rubric->community_id = $forum->id;
            $rubric->save(false);
        }
        return $forum;
    }

    public static function getForumCriteria()
    {
        $forum = self::getForum();
        $model = clone Content::model();
        $model->byLabels(array($forum->toLabel()));
        return $model->getDbCriteria();
    }

    public static function getChosenPostsCriteria()
    {
        $criteria = new \CDbCriteria();
        $criteria->addInCondition('t.id', self::getPostIds());
        $criteria->mergeWith(self::getForumCriteria());
        return $criteria;
    }

    public static function getOtherPostsCriteria()
    {
        $criteria = new \CDbCriteria();
        $criteria->addNotInCondition('t.id', self::getPostIds());
        $criteria->mergeWith(self::getForumCriteria());
        return $criteria;
    }

    public static function getAuthorsIds()
    {
        return array(450668);
    }

    public static function getPostIds()
    {
        return array(705068, 705063, 705058, 705073, 705083);
    }

    public static function getTitle()
    {
        return 'Контрактубекс';
    }
}