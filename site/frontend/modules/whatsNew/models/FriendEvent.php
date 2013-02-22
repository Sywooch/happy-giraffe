<?php
/**
 * Created by JetBrains PhpStorm.
 * User: solivager
 * Date: 12/7/12
 * Time: 11:29 AM
 * To change this template use File | Settings | File Templates.
 */
class FriendEvent extends EMongoDocument
{
    // simple
    const TYPE_STATUS_UPDATED = 0;
    const TYPE_PURPOSE_UPDATED = 1;
    const TYPE_COMMENT_ADDED = 2;
    const TYPE_POST_ADDED = 3;
    const TYPE_RECIPE_ADDED = 4;
    const TYPE_CONTEST_PARTICIPATED = 5;

    // stackable
    const TYPE_CLUBS_JOINED = 6;
    const TYPE_PHOTOS_ADDED = 7;
    const TYPE_FAMILY_ADDED = 8;
    const TYPE_SERVICE_USED = 9;
    const TYPE_INTERESTS_ADDED = 10;

    public static $types = array(
        self::TYPE_STATUS_UPDATED => 'Status',
        self::TYPE_PURPOSE_UPDATED => 'Purpose',
        self::TYPE_COMMENT_ADDED => 'Comment',
        self::TYPE_POST_ADDED => 'Post',
        self::TYPE_RECIPE_ADDED => 'Recipe',
        self::TYPE_CONTEST_PARTICIPATED => 'Contest',
        self::TYPE_CLUBS_JOINED => 'Clubs',
        self::TYPE_PHOTOS_ADDED => 'Photos',
        self::TYPE_FAMILY_ADDED => 'Family',
        self::TYPE_SERVICE_USED => 'Service',
        self::TYPE_INTERESTS_ADDED => 'Interests',
    );

    public $user_id;
    public $created;
    public $updated;
    public $type;

    private $_params;
    private $_user;

    public function init()
    {
        $this->ensureIndexes = false;
    }

    public function indexes()
    {
        return array(
            'updated' => array(
                'key' => array(
                    'updated' => EMongoCriteria::SORT_DESC,
                ),
            ),
            'userId' => array(
                'key' => array(
                    'user_id' => EMongoCriteria::SORT_ASC,
                ),
            ),
        );
    }

    public function getCollectionName()
    {
        return 'friend_actions';
    }

    public static function model($type)
    {
        return parent::model(self::getClassName($type));
    }

    public static function getClassName($type)
    {
        return 'FriendEvent' . self::$types[$type];
    }

    protected function instantiate($attributes)
    {
        $class = self::getClassName($attributes['type']);
        $model = new $class(null);
        $model->initEmbeddedDocuments();
        $model->setAttributes($attributes, false);
        return $model;
    }


    public function getParams()
    {
        return $this->_params;
    }

    public function setParams($params)
    {
        $this->_params = $params;
    }

    public function getUser()
    {
        return $this->_user;
    }

    public function setUser($user)
    {
        $this->_user = $user;
    }

    public function getStack()
    {
        return null;
    }

    public function createBlock()
    {
        $this->created = $this->updated = time();
        $this->save();
    }

    public function getView()
    {
        return 'application.modules.whatsNew.views.friends.types.' . lcfirst(self::$types[$this->type]);
    }

    public static function getUserCriteria()
    {
        return new CDbCriteria(array(
            'index' => 'id',
        ));
    }

    public static function getCommunityContentCriteria()
    {
        return new CDbCriteria(array(
            'index' => 'id',

        ));
    }

    public function getExist()
    {
        return true;
    }

    public function getBlockId()
    {
        return $this->_id;
    }

    public function getCode()
    {
        $cache_id = 'friend_event_code_' . $this->_id;
        $value = Yii::app()->cache->get($cache_id);

        if ($value === false) {
            $value = Yii::app()->controller->renderPartial('application.modules.whatsNew.views.friends._brick', array(
                'data' => $this,
            ), true);

            if ($this->canBeCached())
                Yii::app()->cache->set($cache_id, $value, 300);
        }

        return $value;
    }

    protected function afterSave()
    {
        $comet = new CometModel;
        $comet->type = CometModel::WHATS_NEW_UPDATE;

        $user = User::model()->findByPk($this->user_id);
        $friends = User::model()->findAll($user->getFriendsCriteria(array('select' => 't.id', 'index' => 'id')));
        $friendsIds = array_keys($friends);

        foreach ($friendsIds as $id)
            $comet->send('whatsNewFriendsUser' . $id);

        parent::afterSave();
    }

    /**
     * Если статью удаляли, удаляем все связанные события
     */
    public static function postDeleted($entity, $entity_id)
    {
        //удаляем сообщения у тех кто комментировал статью
        $comment_ids = Yii::app()->db->createCommand()
            ->select('id')
            ->from('comments')
            ->where('entity=:entity AND entity_id=:entity_id', array(':entity' => $entity, ':entity_id' => $entity_id))
            ->queryColumn();

        if (!empty($comment_ids)) {
            foreach ($comment_ids AS $index => $value)
                $comment_ids[$index] = (int)$value;

            $criteria = new EMongoCriteria;
            $criteria->comment_id('in', $comment_ids);
            $criteria->type('==', self::TYPE_COMMENT_ADDED);
            FriendEvent::model(self::TYPE_COMMENT_ADDED)->deleteAll($criteria);
        }

        //удаляем сообщение у автора статьи
        $criteria = new EMongoCriteria;
        if ($entity == 'CookRecipe'){
            $type = self::TYPE_RECIPE_ADDED;
            $criteria->recipe_id('==', (int)$entity_id);
        } else {
            $type = self::TYPE_POST_ADDED;
            $criteria->content_id('==', (int)$entity_id);
        }
        $criteria->type('==', $type);
        FriendEvent::model($type)->deleteAll($criteria);
    }

    public static function userDeleted($user)
    {
        $criteria = new EMongoCriteria;
        $criteria->user_id('==', (int)$user->id);
        $criteria->type('==', self::TYPE_PHOTOS_ADDED);
        FriendEvent::model(self::TYPE_PHOTOS_ADDED)->deleteAll($criteria);
    }
}
