<?php
/**
 * Created by JetBrains PhpStorm.
 * User: solivager
 * Date: 12/7/12
 * Time: 11:29 AM
 * To change this template use File | Settings | File Templates.
 */
abstract class FriendEvent extends EMongoDocument
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

    public function getCollectionName()
    {
        return 'friend_actions';
    }

    public static function model($type)
    {
        $className = 'FriendEvent' . self::$types[$type];

        return parent::model($className);
    }

    public function getParams()
    {
        return $this->_params;
    }

    public function setParams($params)
    {
        $this->_params = $params;
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
}
