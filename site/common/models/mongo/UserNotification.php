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
                'CommunityContent' => '{c} к вашей записи {post} в клубе {club}',
                'RecipeBookRecipe' => '{c} к вашей записи {post} в сервисе {recipeBook}',
                'User' => '{r} в гостевой книге',
                'AlbumPhoto' => '{c} к фотографии {photo} в альбомe {album}',
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
            'entity.id' => (int) $entity->id,
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
            'entity.id' => (int) $entity->id,
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
            ->user_id('==', (int) $user_id)
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
            ->user_id('==', (int) $user_id);

        $models = $this->findAll($criteria);
        $count = 0;
        foreach ($models as $m) {
            $count += ($m['entity'] != null) ? $m['entity']['quantity'] : 1;
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
        $entity = new $entity_name;
        $entity->findByPk($attributes['comment']['entity_id']);

        $recipient = ($entity_name == 'User') ? $entity->id : $entity->author_id;
        if ($recipient != Yii::app()->user->id) {
            $notification = $this->findByEntity($type, $entity);
            if ($notification === null) {
                $notification = new self;
                $notification->user_id = (int) $recipient;
                $notification->url = $entity->url;
                $notification->type = $type;
                $notification->created = time();
                $notification->entity = array(
                    'name' => $entity_name,
                    'id' => (int) $entity->id,
                    'quantity' => 1,
                );
                switch ($entity_name) {
                    case 'CommunityContent':
                        $notification->params = array(
                            '{post}' => $entity->name,
                            '{club}' => $entity->rubric->community->name,
                        );
                        break;
                    case 'RecipeBookRecipe':
                        $notification->params = array(
                            '{post}' => $entity->name,
                            '{recipeBook}' => CHtml::tag('span', array('class' => 'black'), 'Книга народных рецептов'),
                        );
                        break;
                    case 'User':
                        break;
                    case 'AlbumPhoto':
                        $notification->params = array(
                            '{photo}' => $entity->title,
                            '{album}' => $entity->album->title,
                        );
                        break;
                }
            } else {
                $notification->entity['quantity']++;
                $notification->updated = time();
            }
            $notification->save();
        }
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
        if ($this->entity !== null) {
            $params['{c}'] = Notification::parse($this->entity['quantity'], Notification::NOTIFICATION_COMMENT);
            $params['{r}'] = Notification::parse($this->entity['quantity'], Notification::NOTIFICATION_RECORD);
        }
        return strtr($this->template, $params);
    }
}