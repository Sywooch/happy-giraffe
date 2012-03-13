<?php
/**
 * Created by JetBrains PhpStorm.
 * User: choo
 * Date: 3/10/12
 * Time: 6:17 PM
 * To change this template use File | Settings | File Templates.
 */
class UserNotification extends EMongoDocument
{
    const GUESTBOOK_NEW_RECORD = 0;
    const CLUB_NEW_COMMENT = 1;

    public $user_id;
    public $type;
    public $url;
    public $created;
    public $updated;
    public $text;

    public $entity = null;
    public $params = array();

    public static $types = array(
        self::GUESTBOOK_NEW_RECORD => array(
            'method' => 'guestBookNewRecord',
            'tmpl' => '{n} в гостевой книге',
            'noun' => Notification::NOTIFICATION_RECORD,
        ),
        self::CLUB_NEW_COMMENT => array(
            'method' => 'newComment',
            'tmpl' => '{n} к вашей записи {post} в клубе {club}',
            'noun' => Notification::NOTIFICATION_COMMENT,
        ),
    );

    public function getCollectionName()
    {
        return 'notifications';
    }

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    protected function afterSave()
    {
        parent::afterSave();

        $this->sendUpdate($this->user_id);
    }

    protected function afterDelete()
    {
        parent::afterDelete();

        $this->sendUpdate($this->user_id);
    }

    protected function beforeValidate()
    {
        $this->text = $this->generateText();

        return parent::beforeValidate();
    }

    public function sendUpdate($user_id)
    {
        $comet = new CometModel;
        $comet->type = CometModel::TYPE_UPDATE_NOTIFICATIONS;
        $comet->send($user_id, $this->getUserData($user_id));
    }

    public function create($type, $entity = null)
    {
        if ($entity !== null) {
            $notification = self:: model()->findByAttributes(array(
                'type' => $type,
                'entity.name' => get_class($entity),
                'entity.id' => (int) $entity->id,
            ));
        }
        if ($notification !== null) {
            $notification->entity['quantity']++;
            $notification->updated = time();
        } else {
            $notification = new UserNotification;
            $notification->type = $type;
            $notification->created = $notification->updated = time();

            if ($entity !== null) {
                $notification->entity = array(
                    'name' => get_class($entity),
                    'id' => (int) $entity->id,
                    'quantity' => 1,
                );
            }

            $method = 'add' . self::$types[$type]['method'];
            $notification->$method($entity);
        }
        $notification->save();
    }

    public function deleteByEntity($type, $entity)
    {
        $notification = $this->findByAttributes(array(
            'type' => $type,
            'entity.name' => get_class($entity),
            'entity.id' => (int) $entity->id,
        ));
        if ($notification !== null) {
            $notification->delete();
        }
    }

    public function getUserData($user_id)
    {
        return array(
            'count' => $this->getCount($user_id),
            'data' => $this->getLast($user_id),
        );
    }

    public function getLast($user_id)
    {
        $criteria = new EMongoCriteria;

        $criteria
            ->user_id('==', (int) $user_id)
            ->limit(5)
            ->sort('updated', EMongoCriteria::SORT_DESC);

        $notifications = $this->findAll($criteria);

        $data = array();
        foreach ($notifications as $m) {
            $data[] = array(
                '_id' => $m->_id,
                'text' => $m->text,
                'url' => $m->url,
            );
        }

        return $data;
    }

    public function getCount($user_id)
    {
        $criteria = new EMongoCriteria;
        $criteria
            ->user_id('==', (int) $user_id);

        $models = $this->findAll($criteria);
        $count = 0;
        foreach ($models as $m) {
            $count += ($m['entity'] != null) ? $m['entity']['quantity'] : 1;
        }

        return $count;
    }

    public function generateText()
    {
        $params = $this->params;
        $add_span = create_function('&$item, $key', '$item = CHtml::tag("span", array("class" => "black"), $item);');
        array_walk($params, $add_span);
        if ($this->entity !== null) $params['{n}'] = Notification::parse($this->entity['quantity'], self::$types[$this->type]['noun']);
        return strtr(self::$types[$this->type]['tmpl'], $params);
    }

    public function addNewComment($entity)
    {
        $this->user_id = (int) $entity->author_id;
        $this->url = Yii::app()->createUrl('community/view', array(
            'community_id' => $entity->rubric->community->id,
            'content_type_slug' => $entity->type->slug,
            'content_id' => $entity->id,
        ));
        $this->params = array(
            '{post}' => $entity->name,
            '{club}' => $entity->rubric->community->name,
        );
    }

    public function addGuestBookNewRecord($entity)
    {
        $this->user_id = (int) $entity->id;
        $this->url = Yii::app()->createUrl('user/profile', array('user_id' => $entity->id));
    }
}
