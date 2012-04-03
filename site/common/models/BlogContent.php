<?php
/**
 * Author: choo
 * Date: 28.03.2012
 */
class BlogContent extends CommunityContent
{
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function getUrl()
    {
        return Yii::app()->createUrl('/blog/view', array(
            'content_id' => $this->id,
        ));
    }
}
