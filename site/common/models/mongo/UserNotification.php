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
        self::NEW_COMMENT => 'newComment',
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
        return;
        $method = $this->_types[$type];
        $this->$method($type, $attributes);
    }

    public function newComment($type, $attributes)
    {
        $entity_name = get_class($attributes['entity']);
        if (! $this->findByEntity($type, $attributes['entity'])) {
            $notification = new self;
            $notification->type = $type;
            $notification->created = time();
            $notification->entity = array(
                'name' => $entity_name,
                'id' => (int) $attributes['entity']->id,
                'quantity' => 1,
            );
            switch ($entity_name) {
                case 'CommunityComment':
                    $notification->user_id = (int) $attributes['entity']->author_id;
                    $notification->url = Yii::app()->createUrl('community/view', array(
                        'community_id' => $attributes['entity']->rubric->community->id,
                        'content_type_slug' => $attributes['entity']->type->slug,
                        'content_id' => $attributes['entity']->id,
                    ));
                    $notification->params = array(
                        '{post}' => $attributes['entity']->name,
                        '{club}' => $attributes['entity']->rubric->community->name,
                    );
                    break;
                case 'RecipeBookRecipe':
                    $notification->user_id = (int) $attributes['entity']->author_id;
                    $notification->url = Yii::app()->createUrl('recipebook/default/view', array(
                        'id' => $attributes['entity']->id,
                    ));
                    $notification->params = array(
                        '{post}' => $attributes['entity']->name,
                        '{recipeBook}' => CHtml::tag('span', array('class' => 'black'), 'Книга народных рецептов'),
                    );
                    break;
                case 'User':
                    $notification->user_id = (int) $attributes['entity']->id;
                    $notification->url = Yii::app()->createUrl('user/profile', array('user_id' => $attributes['entity']->id));
                    break;
            }
        }
    }

    public function generateText()
    {
        $params = $this->params;
        $add_span = create_function('&$item, $key', '$item = CHtml::tag("span", array("class" => "black"), $item);');
        array_walk($params, $add_span);
        if ($this->entity !== null) $params['{n}'] = Notification::parse($this->entity['quantity'], self::$types[$this->type]['noun']);
        return strtr(self::$types[$this->type]['tmpl'], $params);
    }
}