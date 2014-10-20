<?php

namespace site\frontend\modules\posts\behaviors\converters;

/**
 * Description of CommunityContentBehavior
 *
 * @author Кирилл
 */
class CommunityContentBehavior extends \CActiveRecordBehavior
{

    public function convertToNewPosts()
    {
        
    }

    public function afterSave($event)
    {
        parent::afterSave($event);
        $this->convertToNewPosts();
    }

    protected function convertPost()
    {
        
    }

    protected function convertPhotoPost()
    {
        
    }

    protected function convertVideoPost()
    {
        
    }

    protected function convertStatus()
    {
        
    }

}

?>
