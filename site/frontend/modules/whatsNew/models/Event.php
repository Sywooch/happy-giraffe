<?php
/**
 * Created by JetBrains PhpStorm.
 * User: solivager
 * Date: 11/28/12
 * Time: 12:15 PM
 * To change this template use File | Settings | File Templates.
 */
abstract class Event extends CModel
{
    public $id;
    public $last_updated;
    public $type;

    protected $clusterable = false;

    const EVENT_POST = 0;
    const EVENT_CONTEST = 1;
    const EVENT_COOK_DECOR = 2;
    const EVENT_RECIPE = 3;
    const EVENT_USER = 4;

    public static $types = array(
        self::EVENT_POST => 'Post',
        self::EVENT_CONTEST => 'Contest',
        self::EVENT_COOK_DECOR => 'Decor',
        self::EVENT_RECIPE => 'Recipe',
        self::EVENT_USER => 'User',
    );

    public function rules()
    {
        return array(
            array('id', 'numerical', 'integerOnly' => true),
            array('last_updated', 'date', 'format' => 'yyyy-MM-dd hh:mm:ss'),
            array('type', 'in', 'range' => array_keys(self::$types)),
        );
    }

    public static function factory($type)
    {
        $class = 'Event' . self::$types[$type];
        return new $class;
    }

    public function attributeNames()
    {
        return array('id', 'last_updated', 'type');
    }

    public function getView()
    {
        return 'application.modules.whatsNew.views.default.types.' . lcfirst(self::$types[$this->type]);
    }

    public function getSeed()
    {
        return ($this->clusterable)
            ? self::$types[$this->type]
            : self::$types[$this->type] . '_' . $this->id;
    }

    public function getBlockId()
    {
        return md5($this->seed);
    }

    public function setAttributes($values, $safeOnly = true)
    {
        parent::setAttributes($values, $safeOnly);
    }

    public function getCode()
    {
        //не получается кэшировать из-за галереи, которая подключает скрипты
//        $cache_id = 'event_code_'.$this->id.'__'.$this->last_updated;
//        $value=Yii::app()->cache->get($cache_id);
//        if($value===false)
//        {
//            $this->setSpecificValues();
//            $value=Yii::app()->controller->renderPartial($this->view, array('data' => $this), true);
//            Yii::app()->cache->set($cache_id,$value, 300);
//        }

        $this->setSpecificValues();
        $value = Yii::app()->controller->renderPartial($this->view, array('data' => $this), true);

        return $value;
    }

    abstract public function setSpecificValues();
}
