<?php
/**
 * @author Никита
 * @date 22/07/15
 */

class CommentBackup extends \site\frontend\modules\comments\models\Comment
{
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function getDbConnection()
    {
        return Yii::app()->dbBackup;
    }

    public function behaviors()
    {
        return array(
            'ContestBehavior' => array(
                'class' => 'site\frontend\modules\comments\modules\contest\behaviors\ContestBehavior',
            ),
        );
    }

    public function afterSave()
    {
        if ($this->isNewRecord)
        {
            if (in_array($this->entity, array('CommunityContent', 'BlogContent', 'AlbumPhoto')))
            {
                PostRating::reCalcFromComments($this);
            }

            Yii::import('site.frontend.modules.routes.models.*');
            Scoring::commentCreated($this);

            //send signals to commentator panel
//            if (Yii::app()->user->checkAccess('commentator_panel'))
//            {
//                Yii::import('site.frontend.modules.signal.components.*');
//                Yii::import('site.frontend.modules.signal.models.*');
//                Yii::import('site.frontend.modules.signal.helpers.*');
//                Yii::import('site.frontend.modules.cook.models.*');
//                Yii::import('site.frontend.modules.cook.components.*');
//                Yii::import('site.seo.modules.commentators.models.*');
//                Yii::import('site.seo.models.*');
//
//                if (CommentatorHelper::getStringLength($this->text) >= CommentatorHelper::COMMENT_LIMIT)
//                    CommentatorWork::getCurrentUser()->checkComment($this);
//            }
        }
        parent::afterSave();
    }
}