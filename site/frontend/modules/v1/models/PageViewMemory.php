<?php

namespace site\frontend\modules\v1\models;

/**
 * ћожно было не делать, тупанул, но ладно уж.
 *
 * @property $_id
 * @property $expires
 */
class PageViewMemory extends \EMongoDocument
{
    const EXPIRE_TIME = 900;

    public $expires;

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    public function getCollectionName()
    {
        return 'page_views_memory';
    }

    /**
     * Create new record.
     *
     * @param $user_id
     * @param $url
     *
     * @return PageViewMemory
     */
    public function create($user_id, $url)
    {
        $model = new self;

        $model->_id = self::getId($user_id, $url);
        $model->expires = time() + self::EXPIRE_TIME;

        $model->save();

        return $model;
    }

    /**
     * Refresh expires
     */
    public function refresh()
    {
        $this->expires = time() + self::EXPIRE_TIME;

        $this->save();
    }

    /**
     * Constructs unique id
     *
     * @param $user_id
     * @param $url
     *
     * @return string
     */
    public static function getId($user_id, $url)
    {
        /**@todo: guests*/
        return $user_id . '|' . $url;
    }

    /**
     * Check expires, return true if expire time out.
     *
     * @return bool
     */
    public function isTimeOut()
    {
        return time() > $this->expires;
    }
}