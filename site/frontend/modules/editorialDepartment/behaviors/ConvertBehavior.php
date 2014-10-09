<?php

namespace site\frontend\modules\editorialDepartment\behaviors;

/**
 * Description of ConvertBehavior
 *
 * @author Кирилл
 * 
 * @property \site\frontend\modules\editorialDepartment\models\Content $owner Owner
 */
class ConvertBehavior extends \EMongoDocumentBehavior
{

    public function beforeSave($event)
    {
        if ($this->owner->isNewRecord)
        {
            $communityContent = new \CommunityContent('advEditor');
            $communityPost = new \CommunityPost('advEditor');
        }
        else
        {
            $communityContent = \CommunityContent::model()->with('post')->findByPk($this->owner->entityId);
            $communityPost = $communityContent->post;
            $communityContent->detachBehaviors();
            $communityContent->attachBehaviors($communityContent->behaviors());
            $communityPost->detachBehaviors();
            $communityPost->attachBehaviors($communityPost->behaviors());
            $communityContent->scenario = 'advEditor';
            $communityPost->scenario = 'advEditor';
        }

        \Yii::app()->db->beginTransaction();
        try
        {
            $communityPost->text = $this->owner->htmlText;

            $communityContent->author_id = $this->owner->fromUserId;
            $communityContent->title = $this->owner->title;
            $communityContent->updated = new \CDbExpression('FROM_UNIXTIME(:dtimeUpdate)', array('dtimeUpdate' => $this->owner->dtimeUpdate));
            if ($communityContent->isNewRecord)
                $communityContent->created = new \CDbExpression('FROM_UNIXTIME(:dtimeCreate)', array('dtimeCreate' => $this->owner->dtimeCreate));
            $communityContent->rubric_id = $this->owner->rubricId;
            $communityContent->type_id = \CommunityContent::TYPE_POST;
            $communityContent->preview = $this->owner->htmlTextPreview;

            $communityContent->meta_title = $this->owner->meta->title;
            $communityContent->meta_keywords = $this->owner->meta->keywords;
            $communityContent->meta_description = $this->owner->meta->description;

            if (!$communityContent->save(false))
                throw new \Exception;
            $communityPost->content_id = $communityContent->id;
            if (!$communityPost->save(false))
                throw new \Exception;

            \Yii::app()->db->currentTransaction->commit();
            $this->owner->entity = get_class($communityContent);
            $this->owner->entityId = (int) $communityContent->id;
        }
        catch (\Exception $e)
        {
            die($e->getMessage());
            \Yii::app()->db->currentTransaction->rollback();
            $event->isValid = false;
            return false;
        }

        return parent::beforeSave($event);
    }

}

?>
