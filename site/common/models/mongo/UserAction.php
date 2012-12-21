<?php
/**
 * Author: choo
 * Date: 24.07.2012
 */
class UserAction extends EMongoDocument
{
    const USER_ACTION_MOOD_CHANGED = 0;
    const USER_ACTION_STATUS_CHANGED = 1;
    const USER_ACTION_PURPOSE_CHANGED = 2;
    const USER_ACTION_CLUBS_JOINED = 3;
    const USER_ACTION_INTERESTS_ADDED = 4;
    const USER_ACTION_PHOTOS_ADDED = 5;
    const USER_ACTION_COMMUNITY_CONTENT_ADDED = 6;
    const USER_ACTION_FRIENDS_ADDED = 7;
    const USER_ACTION_LEVELUP = 8;
    const USER_ACTION_USED_SERVICES = 9;
    const USER_ACTION_FAMILY_UPDATED = 10;
    const USER_ACTION_ADDRESS_UPDATED = 11;
    const USER_ACTION_COMMENT_ADDED = 12;
    const USER_ACTION_RECIPE_ADDED = 13;
    const USER_ACTION_DUEL = 14;
    const USER_ACTION_BLOG_CONTENT_ADDED = 15;

    private $_stackableActions = array(
        self::USER_ACTION_CLUBS_JOINED,
        self::USER_ACTION_INTERESTS_ADDED,
        self::USER_ACTION_USED_SERVICES,
        self::USER_ACTION_FRIENDS_ADDED,
        self::USER_ACTION_PHOTOS_ADDED,
    );

    public $user_id;
    public $updated;
    public $created;
    public $type;
    public $data;
    public $blockData = null;

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function getCollectionName()
    {
        return 'user_actions';
    }

    public function beforeSave()
    {
        if ($this->isNewRecord)
            $this->created = time();

        return parent::beforeSave();
    }

    public function add($user_id, $type, $params = array(), $blockData = null)
    {
        if (($stack = $this->getStack($user_id, $type, $blockData)) !== null) {
            $newData = $stack->getDataByParams($params);
            if (array_search($newData, $stack->data) === FALSE) {
                $stack->updated = time();
                $stack->data[] = $newData;
                $stack->save();
            }
        } else {
            $action = new self;
            $action->user_id = (int) $user_id;
            $action->type = $type;
            $action->updated = time();
            $action->data = (in_array($type, $this->_stackableActions)) ? array($action->getDataByParams($params)) : $action->getDataByParams($params);
            if ($blockData !== null)
                $action->blockData = $blockData;

            $action->save();
        }
    }

    public function getDataByParams($params)
    {
        switch ($this->type) {
            case self::USER_ACTION_MOOD_CHANGED:
                return $params['model']->getAttributes(array('mood_id'));
                break;
            case self::USER_ACTION_STATUS_CHANGED:
                $model = $params['model'];
                $data = $model->getAttributes(array('text'));
                $data['created'] = time();
                return $data;
                break;
            case self::USER_ACTION_PURPOSE_CHANGED:
                return $params['model']->getAttributes(array('text'));
                break;
            case self::USER_ACTION_CLUBS_JOINED:
                $community = Community::model()->findByPk($params['community_id']);
                return $community->getAttributes(array('id'));
                break;
            case self::USER_ACTION_COMMENT_ADDED:
            case self::USER_ACTION_BLOG_CONTENT_ADDED:
            case self::USER_ACTION_COMMUNITY_CONTENT_ADDED:
            case self::USER_ACTION_DUEL:
            case self::USER_ACTION_PHOTOS_ADDED:
                return $params['model']->getAttributes(array('id'));
                break;
            case self::USER_ACTION_RECIPE_ADDED:
                $model = $params['model'];
                $data = $model->getAttributes(array('id', 'title', 'section'));
                $data['created'] = time();
                $data['contentImage'] = $model->contentImage;
                return $data;
                break;
            case self::USER_ACTION_ADDRESS_UPDATED:
                $model = $params['model'];
                return array(
                    'flag' => $model->flag,
                    'country_name' => $model->country->name,
                    'country_id' => $model->country_id,
                    'locationWithoutCountry' => $model->locationWithoutCountry,
                    'locationString' => $model->locationString,
                );
                break;
            case self::USER_ACTION_FAMILY_UPDATED:
                $model = $params['model'];
                return array(
                    'entity' => get_class($model),
                    'entity_id' => $model->id,
                );
            default:
                return $params;
        }
    }

    public function getStack($user_id, $type, $blockData)
    {
        if (! in_array($type, $this->_stackableActions))
            return null;

        $criteria = new EMongoCriteria();
        $criteria->type = $type;
        $criteria->user_id = (int) $user_id;
        if ($blockData !== null)
            $criteria->blockData = $blockData;
        $criteria->sort('updated', EMongoCriteria::SORT_DESC);
        $criteria->created('>=', strtotime(date("Y-m-d").'00:00:00'));

        $stack = self::model()->find($criteria);
        if ($stack === null)
            return null;

        switch ($type) {
            case self::USER_ACTION_PHOTOS_ADDED:
                $result = (time() - $stack->updated < 60) && HDate::isSameDate($stack->updated, time());
                break;
            default:
                $result = HDate::isSameDate($stack->created, time());
        }

        return $result ? $stack : null;
    }

    public function getMyCriteria($user_id)
    {
        $criteria = new EMongoCriteria;
        $criteria->user_id = (int) $user_id;

        return $criteria;
    }

    public function getFriendsCriteria($user_id)
    {
        $user = User::model()->findByPk($user_id);
        $friends = User::model()->findAll($user->getFriendsCriteria(array('select' => 't.id', 'index' => 'id')));
        $friendsIds = array_keys($friends);
        var_dump($friendsIds);

        $criteria = new EMongoCriteria(array(
            'conditions' => array(
                'type' => array('in' => array(
                    self::USER_ACTION_PHOTOS_ADDED,
                    self::USER_ACTION_COMMUNITY_CONTENT_ADDED,
                    self::USER_ACTION_COMMENT_ADDED,
                    self::USER_ACTION_FAMILY_UPDATED,
                    self::USER_ACTION_CLUBS_JOINED,
                    self::USER_ACTION_BLOG_CONTENT_ADDED,
                    self::USER_ACTION_DUEL,
                )),
                'user_id' => array('in' => $friendsIds),
            ),
        ));


        return $criteria;
    }

    public function getText()
    {
        $user = User::model()->findByPk($this->user_id);
        $userLink = CHtml::link($user->first_name, $user->url);
        switch ($this->type) {
            case self::USER_ACTION_PHOTOS_ADDED:
                $album = Album::model()->findByPk($this->data['id']);
                $text = $userLink . ' ' . HDate::simpleVerb('добавил', $user->gender) . ' ' . 'новые фото <b>в альбом</b>' . ' ' . CHtml::link($album->title, $album->url);
                break;
            case self::USER_ACTION_COMMUNITY_CONTENT_ADDED:
                $content = CommunityContent::model()->findByPk($this->data['id']);
                $text = $userLink . ' ' . HDate::simpleVerb('добавил', $user->gender) . ' ' . 'запись <b>в клубе</b>' . ' ' . CHtml::link($content->rubric->community->title, $content->rubric->community->url);
                break;
            case self::USER_ACTION_BLOG_CONTENT_ADDED:
                $text = $userLink . ' ' . HDate::simpleVerb('добавил', $user->gender) . ' ' . 'запись <b>в свой блог</b>';
                break;
            case self::USER_ACTION_DUEL:
                $text = $userLink . ' ' . HDate::simpleVerb('поучаствовал', $user->gender) . ' ' . '<b>в дуэли</b>';
                break;
            case self::USER_ACTION_CLUBS_JOINED:
                $club = Community::model()->findByPk($this->data['id']);
                $text = $userLink . ' ' . HDate::simpleVerb('вступил', $user->gender) . ' ' . CHtml::link($club->title, $club->url);
                break;
            case self::USER_ACTION_FAMILY_UPDATED:
                $text = $userLink . ' ' . HDate::simpleVerb('обновил', $user->gender) . ' ' . 'информацию о семье';
                break;
            case self::USER_ACTION_COMMENT_ADDED:
                $comment = Comment::model()->findByPk($this->data['id']);
                $entity = CActiveRecord::model($comment->entity)->findByPk($comment->entity_id);
                switch (get_class($entity)) {
                    case 'BlogContent':
                        $to = 'к вашей записи ' . CHtml::link($entity->title, $entity->url) . ' <b>в блоге</b>';
                        break;
                    case 'CommunityContent':
                        $to = 'к вашей записи ' . CHtml::link($entity->title, $entity->url) . ' <b>в сообществе</b> ' . CHtml::link($entity->rubric->community->title, $entity->rubric->community->url);
                        break;
                    case 'CookRecipe':
                        $to = 'к вашему рецепту ' . CHtml::link($entity->title, $entity->url);
                        break;
                    case 'AlbumPhoto':
                        $to = 'к вашему фото ' . CHtml::link($entity->title, $entity->url) . ' <b>в альбоме</b> ' . CHtml::link($entity->album->title, $entity->album->url);
                        break;
                }
                $text = $userLink . ' ' . HDate::simpleVerb('оставил', $user->gender) . ' комментарий ' . $to;
                break;
            default:
                $text = null;
        }

        return $text;
    }
}
