<?php
/**
 * Created by JetBrains PhpStorm.
 * User: solivager
 * Date: 12/7/12
 * Time: 3:15 PM
 * To change this template use File | Settings | File Templates.
 */
class FriendEventDataProvider extends EMongoDocumentDataProvider
{
    public function fetchData()
    {
        $data = parent::fetchData();

        $entityIds = array();
        foreach ($data as $k => $v) {
            $entityIds['User'][] = $v->user_id;
            switch ($v->type) {
                case FriendEvent::TYPE_STATUS_UPDATED:
                    $entityIds['CommunityContent'][] = $v->content_id;
                    break;
            }
        }

        $entities = array();
        foreach ($entityIds as $entity => $ids) {
            $method = 'get' . $entity. 'Criteria';
            $criteria = FriendEvent::$method();
            $criteria->addInCondition('t.id', $ids);
            $entities[$entity] = CActiveRecord::model($entity)->findAll($criteria);
        }

        foreach ($data as $k => $v) {
            $v->user = $entities['User'][$v->user_id];
            switch ($v->type) {
                case FriendEvent::TYPE_STATUS_UPDATED:
                    $v->content = $entities['CommunityContent'][$v->content_id];
                    break;
            }
        }

        return $data;
    }
}
