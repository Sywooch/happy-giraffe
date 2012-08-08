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
    const NEW_COMMENT = 0;
    const NEW_REPLY = 1;
    const DELETED = 2;
    const TRANSFERRED = 3;

    public $user_id;
    public $type;
    public $url;
    public $created;
    public $updated;
    public $text;

    public $entity = null;
    public $params = array();

    private $_types = array(
        self::NEW_COMMENT => array(
            'method' => 'newComment',
            'templates' => array(
                'CommunityContent' => '{comments} к вашей записи {post} в клубе {club}',
                'RecipeBookRecipe' => '{comments} к вашей записи {post} в сервисе {recipeBook}',
                'AlbumPhoto' => '{comments} к фотографии {photo}',
                'BlogContent' => '{comments} к вашей записи {post} в блоге',
                'User' => '{records} в гостевой книге',
            ),
        ),
        self::NEW_REPLY => array(
            'method' => 'newReply',
            'templates' => array(
                'CommunityContent' => '{replies} на ваш комментарий к записи {post} в клубе {club}',
                'RecipeBookRecipe' => '{replies} на ваш комментарий к записи {post} в сервисе {recipeBook}',
                'AlbumPhoto' => '{replies} на ваш комментарий к фотографии {photo}',
                'BlogContent' => '{replies} на ваш комментарий к записи {post} в вашем блоге',
            ),
        ),
        self::DELETED => array(
            'method' => 'deleted',
            'templates' => array(
                'CommunityContent' => 'Ваша запись {post} в клубе {club} удалена по причине {deleteReason}',
                'Comment' => 'Ваш комментарий к записи {post} в клубе {club} удален по причине {deleteReason}',
            ),
        ),
        self::TRANSFERRED => array(
            'method' => 'transferred',
            'templates' => array(
                'CommunityContent' => 'Ваша запись {post} перенесена в рубрику {rubric} клуба {club}',
            ),
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

    public function deleteByEntity($type, $entity)
    {
        $notification = $this->findByAttributes(array(
            'type' => $type,
            'entity.name' => get_class($entity),
            'entity.id' => (int)$entity->id,
        ));
        if ($notification !== null) {
            $notification->delete();
        }
    }

    public function findByEntity($type, $entity)
    {
        return $this->findByAttributes(array(
            'type' => $type,
            'entity.name' => get_class($entity),
            'entity.id' => (int)$entity->id,
        ));
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
            ->user_id('==', (int)$user_id)
            ->limit(5)
            ->sort('updated', EMongoCriteria::SORT_DESC);

        $notifications = $this->findAll($criteria);

        $data = array();
        foreach ($notifications as $m) {
            $data[] = array(
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
            ->user_id('==', (int)$user_id);

        $models = $this->findAll($criteria);
        $count = 0;
        foreach ($models as $m) {
            $count += (isset($m['entity']['quantity'])) ? $m['entity']['quantity'] : 1;
        }

        return $count;
    }

    public function create($type, $attributes = array())
    {
        $method = $this->_types[$type]['method'];
        $this->$method($type, $attributes);
    }

    public function newComment($type, $attributes)
    {
        $entity_name = $attributes['comment']['entity'];
        $entity = CActiveRecord::model($entity_name)->findByPk($attributes['comment']['entity_id']);
        $recipient = ($entity_name == 'User') ? $entity->id : $entity->author_id;
        if ($recipient != Yii::app()->user->id) {
            $notification = $this->findByEntity($type, $entity);
            if ($notification === null) {
                $notification = new self;
                $notification->user_id = (int)$recipient;
                $notification->url = $entity->url;
                $notification->type = $type;
                $notification->created = $notification->updated = time();
                $notification->entity = array(
                    'name' => $entity_name,
                    'id' => (int)$entity->id,
                    'quantity' => 1,
                );
                $notification->params = $this->getParamsByEntity($entity);
            } else {
                $notification->entity['quantity']++;
                $notification->updated = time();
            }
            $notification->save();
        }
    }

    public function newReply($type, $attributes)
    {
        $entity_name = $attributes['comment']['entity'];
        $entity = CActiveRecord::model($entity_name)->findByPk($attributes['comment']['entity_id']);
        $recipient = $attributes['comment']->response->author_id;
        if ($recipient != Yii::app()->user->id) {
            $notification = $this->findByEntity($type, $entity);
            if ($notification === null) {
                $notification = new self;
                $notification->user_id = (int)$recipient;
                $notification->url = $entity->url;
                $notification->type = $type;
                $notification->created = $notification->updated = time();
                $notification->entity = array(
                    'name' => $entity_name,
                    'id' => (int)$entity->id,
                    'quantity' => 1,
                );
                $notification->params = $this->getParamsByEntity($entity);
            } else {
                $notification->entity['quantity']++;
                $notification->updated = time();
            }
            $notification->save();
        }
    }

    public function deleted($type, $attributes)
    {
        $entity_name = get_class($attributes['entity']);
        $entity = $attributes['entity'];
        $recipient = $entity->author_id;
        if ($recipient != Yii::app()->user->id) {
            $notification = new self;
            $notification->user_id = (int)$recipient;
            $notification->url = $entity->url;
            $notification->type = $type;
            $notification->created = $notification->updated = time();
            $notification->entity = array(
                'name' => $entity_name,
                'id' => (int)$entity->id,
            );
            $notification->params = $notification->getParamsByEntity($entity);
            $notification->save();
        }
    }

    public function transferred($type, $attributes)
    {
        $entity_name = get_class($attributes['entity']);
        $entity = $attributes['entity'];
        $recipient = $entity->author_id;
        if ($recipient != Yii::app()->user->id) {
            $notification = new self;
            $notification->user_id = (int)$recipient;
            $notification->url = $entity->url;
            $notification->type = $type;
            $notification->created = $notification->updated = time();
            $notification->entity = array(
                'name' => $entity_name,
                'id' => (int)$entity->id,
            );
            $notification->params = $notification->getParamsByEntity($entity);
            $notification->save();
        }
    }

    public function getParamsByEntity($entity, $direct = true)
    {
        $params = array();
        switch (get_class($entity)) {
            case 'CommunityContent':
                if (isset($entity->rubric->community))
                    $params = array(
                        '{post}' => $entity->title,
                        '{club}' => $entity->rubric->community->title,
                        '{rubric}' => $entity->rubric->title,
                    );
                break;
            case 'BlogContent':
                $params = array(
                    '{post}' => $entity->title,

                );
                break;
            case 'AlbumPhoto':
                $params = array(
                    '{photo}' => $entity->title,
                );
                break;
            case 'RecipeBookRecipe':
                $params = array(
                    '{post}' => $entity->title,
                    '{recipeBook}' => CHtml::tag('span', array('class' => 'black'), 'Книга народных рецептов'),
                );
                break;
            case 'Comment':
                $params = $this->getParamsByEntity(CActiveRecord::model($entity->entity)->findByPk($entity->entity_id), false);
                break;
            case 'User':
                $params = array();
                break;
        }
        if ($this->type == self::DELETED && $direct) {
            $params['{deleteReason}'] = Removed::$types[$entity->remove->type];
        }
        return $params;
    }

    public function getTemplate()
    {
        return $this->_types[$this->type]['templates'][$this->entity['name']];
    }

    public function generateText()
    {
        $params = $this->params;
        $add_span = create_function('&$item, $key', '$item = CHtml::tag("span", array("class" => "black"), $item);');
        array_walk($params, $add_span);
        if (isset($this->entity['quantity'])) {
            $params['{comments}'] = Notification::parse($this->entity['quantity'], Notification::NOTIFICATION_COMMENT);
            $params['{records}'] = Notification::parse($this->entity['quantity'], Notification::NOTIFICATION_RECORD);
            $params['{replies}'] = Notification::parse($this->entity['quantity'], Notification::NOTIFICATION_REPLY);
        }
        return strtr($this->template, $params);
    }
}