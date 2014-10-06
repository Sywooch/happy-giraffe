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

    public function afterSave($event)
    {
        $communityContent = new \CommunityContent('advEditor');
        $communityPost = new \CommunityPost('advEditor');

        $communityContent->db->beginTransaction();
        try
        {
            $communityPost->text = $this->owner->htmlText;

            $communityContent->title = $this->owner->title;
            $communityContent->updated = new \CDbExpression('FROM_UNIXTIME(:dtimeUpdate)', array('dtimeUpdate' => $this->owner->dtimeUpdate));
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
            $communityContent->db->currentTransaction->commit();
        }
        catch (\Exception $e)
        {
            $communityContent->db->currentTransaction->rollback();
        }

        return parent::afterSave($event);
    }

}

?>
