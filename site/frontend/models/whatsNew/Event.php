<?php
/**
 * Created by JetBrains PhpStorm.
 * User: solivager
 * Date: 11/28/12
 * Time: 12:15 PM
 * To change this template use File | Settings | File Templates.
 */
class Event extends CModel
{
    public $id;
    public $last_updated;
    public $type;

    const EVENT_POST = 0;
    const EVENT_CONTEST = 1;
    const EVENT_COOK_DECOR = 2;
    const EVENT_RECIPE = 3;
    const EVENT_USER = 4;

    public static $types = array(
        self::EVENT_POST => 'Posts',
        self::EVENT_CONTEST => 'Contests',
        self::EVENT_COOK_DECOR => 'CookDecors',
        self::EVENT_RECIPE => 'Recipes',
        self::EVENT_USER => 'Users',
    );

    public function rules()
    {
        return array(
            array('type', 'in', 'range' => array_keys(self::$types)),
        );
    }

    public function attributeNames()
    {
        return array('id', 'last_updated', 'type');
    }
}
