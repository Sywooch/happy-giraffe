<?php

namespace site\frontend\modules\comments\behaviors;

/**
 * Description of ConvertBehavior
 *
 * @author Кирилл
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
