<?php
/**
 * Created by JetBrains PhpStorm.
 * User: mikita
 * Date: 21/04/14
 * Time: 11:52
 * To change this template use File | Settings | File Templates.
 */

class MailComment extends Comment
{
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function getCommentText($length)
    {
        return Str::getDescription($this->text, $length);
    }

    public function exceedsLength($length)
    {
        return strlen($this->getCommentText($length)) > $length;
    }

    public function isSpecialist()
    {
        $model = $this->getCommentEntity();
        return $model instanceof CommunityContent && $this->author->getSpecialist($this->getCommentEntity()->rubric->community_id) !== null;
    }
}