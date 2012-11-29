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
        self::EVENT_POST => 'post',
        self::EVENT_CONTEST => 'contest',
        self::EVENT_COOK_DECOR => 'decor',
        self::EVENT_RECIPE => 'recipe',
        self::EVENT_USER => 'user',
    );

    public function rules()
    {
        return array(
            array('last_updated', 'date', 'format' => 'yyyy-MM-dd hh:mm:ss'),
            array('type', 'in', 'range' => array_keys(self::$types)),
        );
    }

    public function attributeNames()
    {
        return array('id', 'last_updated', 'type');
    }

    public function getView()
    {
        return 'types/' . self::$types[$this->type];
    }

    public function getData()
    {
        $method = 'get' . self::$types[$this->type] . 'Data';
        return $this->$method();
    }

    public function getPostData()
    {

    }

    public function getContestData()
    {

    }

    public function getDecorData()
    {
        $last_updated = $this->last_updated;
        $decorations = CookDecoration::model()->lastDecorations;

        return compact('last_updated', 'decorations');
    }

    public function getRecipeData()
    {

    }

    public function getUserData()
    {

    }
}
