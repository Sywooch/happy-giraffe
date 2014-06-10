<?php
/**
 * Created by PhpStorm.
 * User: mikita
 * Date: 10/06/14
 * Time: 11:27
 */

class LastModifiedBehavior extends CBehavior
{
    public $entity;
    public $action = 'view';
    public $getParameter;

    public function getDateTime()
    {
        return date("Y-m-d H:i:s", max($this->getContentLastUpdated(), $this->getLinksLastUpdated()));
    }

    protected function getTableName()
    {
        return CActiveRecord::model($this->entity)->tableName();
    }

    protected function getContentLastUpdated()
    {
        $cId = Yii::app()->request->getQuery($this->getParameter);
        $sql = "SELECT
                    GREATEST(
                        COALESCE(MAX(c.created), '0000-00-00 00:00:00'),
                        COALESCE(MAX(c.updated), '0000-00-00 00:00:00'),
                        COALESCE(MAX(cm.created), '0000-00-00 00:00:00'),
                        COALESCE(MAX(cm.updated), '0000-00-00 00:00:00')
                    )
                FROM " . $this->getTableName() .  " c
                LEFT OUTER JOIN comments cm
                ON cm.entity = :entity AND cm.entity_id = :content_id
                WHERE c.id = :content_id";
        $command = Yii::app()->db->createCommand($sql);
        return strtotime($command->queryScalar(array(
            ':content_id' => $cId,
            ':entity' => $this->entity,
        )));
    }

    protected function getLinksLastUpdated()
    {
        $url = Yii::app()->request->url;
        return InnerLinksBlock::model()->getUpTime($url);
    }
} 