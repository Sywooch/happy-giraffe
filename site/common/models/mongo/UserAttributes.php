<?php
/**
 * Author: choo
 * Date: 22.05.2012
 */
class UserAttributes extends EMongoDocument
{
    public $user_id;
    public $attributes;

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function getCollectionName()
    {
        return 'user_attributes';
    }

    public function indexes()
    {
        return array(
            'index_user' => array(
                'key' => array(
                    'user_id' => EMongoCriteria::SORT_ASC,
                ),
                'unique'=>true,
            ),
        );
    }

    public static function set($user_id, $key, $value) {
        $model = self::model()->findByAttributes(array(
            'user_id' => (int) $user_id,
        ));

        filter_var($value, FILTER_VALIDATE_BOOLEAN);

        if ($model === null) {
            $model = new self;
            $model->user_id = (int) $user_id;
            $model->attributes = array($key => $value);
        } else {
            $model->attributes[$key] = $value;
        }

        $comet = new CometModel();
        $comet->send($user_id, array('key' => $key, 'value' => $value), CometModel::SETTING_UPDATED);

        return $model->save();
    }

    public static function del($user_id, $key) {
        $model = self::model()->findByAttributes(array(
            'user_id' => (int) $user_id,
        ));

        if ($model !== null) {
            unset($model->attributes[$key]);
            return $model->save();
        } else {
            return false;
        }
    }

    public static function get($user_id, $key, $default = null) {
        $model = self::model()->findByAttributes(array(
            'user_id' => (int) $user_id,
        ));

        if ($model !== null && isset($model->attributes[$key])) {
            return $model->attributes[$key];
        } else {
            return $default;
        }
    }

    public static function isFiredWorker($user_id, $created_time)
    {
        $fire_time = UserAttributes::get($user_id, 'fire_time');
        if (!empty($fire_time)){
            if ($fire_time > strtotime($created_time))
                return true;
        }

        return false;
    }

    /**
     * Удаляет свойство
     * @param string $name
     */
    public static function removeAttr($name)
    {
        $modifier = new EMongoModifier(array('attributes.'.$name => array('unset' => 1)));
        self::model()->updateAll($modifier);
    }
}
