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

    public function attach($owner)
    {

    }

    protected function lastModified()
    {
        $content_id = Yii::app()->request->getQuery('content_id');

        $sql = "SELECT
                    GREATEST(
                        COALESCE(MAX(c.created), '0000-00-00 00:00:00'),
                        COALESCE(MAX(c.updated), '0000-00-00 00:00:00'),
                        COALESCE(MAX(cm.created), '0000-00-00 00:00:00'),
                        COALESCE(MAX(cm.updated), '0000-00-00 00:00:00')
                    )
                FROM community__contents c
                LEFT OUTER JOIN comments cm
                ON cm.entity = 'CommunityContent' AND cm.entity_id = :content_id
                WHERE c.id = :content_id";

        $command = Yii::app()->db->createCommand($sql);
        $command->bindValue(':content_id', $content_id, PDO::PARAM_INT);
        $t1 = strtotime($command->queryScalar());

        //проверяем блок внутренней перелинковки
        $url = 'http://www.happy-giraffe.ru' . Yii::app()->request->getRequestUri();
        $t2 = InnerLinksBlock::model()->getUpTime($url);

        if (empty($t2))
            return $t1;

        return date("Y-m-d H:i:s", max($t1, $t2));
    }
} 