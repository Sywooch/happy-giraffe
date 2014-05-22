<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SummaryNotification
 *
 * @author Кирилл
 */
class NotificationSummary extends Notification
{

    public function attributeNames()
    {
        return array(
            "type",
            "entity_id",
            "updated",
            "count",
            "visibleCount",
            "url",
        );
    }

    public function afterFind()
    {
        parent::afterFind();
        $this->articles = array_map(function($data)
            {
                $obj = new NotificationArticle;
                foreach ($data as $k => $v)
                    $obj->{$k} = $v;
                return $obj;
            }, $this->articles);
    }

    public function getEntity()
    {
        return null;
    }

    public function getEntity_id()
    {
        return null;
    }

    public function getUrl()
    {
        return null;
    }

}

?>
