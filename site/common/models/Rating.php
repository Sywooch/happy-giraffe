<?php

/**
 * This is the model class for table "ratings".
 *
 * The followings are the available columns in table 'ratings':
 * @property integer $entity_id
 * @property string $entity_name
 * @property string $social_key
 * @property integer $value
 */
class Rating extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return rating the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'ratings';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('entity_id, entity_name, social_key, value', 'required'),
			array('entity_id, value', 'numerical', 'integerOnly'=>true),
			array('entity_name', 'length', 'max'=>50),
			array('social_key', 'length', 'max'=>2),
		);
	}

    /**
     * @static
     * @param CActiveRecord $entity
     * @param string $social_key
     * @return Rating
     */
    public static function findByEntity($entity, $social_key = false)
    {
        $params = array(
            'entity_name' => get_class($entity),
            'entity_id' => $entity->primaryKey,
        );
        if($social_key !== false)
            $params['social_key'] = $social_key;
        if($social_key !== false)
            return self::model()->findByAttributes($params);
        else
            return self::model()->findAllByAttributes($params);
    }

    /**
     * @static
     * @param CActiveRecord $entity
     * @param string $social_key
     * @return int
     */
    public static function countByEntity($entity, $social_key = false)
    {
        $model = self::findByEntity($entity, $social_key);
        if($social_key === false)
        {
            $sum = 0;
            foreach($model as $item)
                $sum += $item->value;
            return $sum;
        }
        else if($model)
        {
            return $model->value;
        }
        return 0;
    }


    /**
     * @static
     * @param CActiveRecord $entity
     * @param string $social_key
     * @param int $value
     * @return Rating
     */
    public static function saveByEntity($entity, $social_key, $value, $plus = false)
    {
        $model = self::findByEntity($entity, $social_key);
        if(!$model)
        {
            $model = new Rating;
            $model->entity_name = get_class($entity);
            $model->entity_id = $entity->primaryKey;
            $model->social_key = $social_key;
        }
        $model->value = $plus !== false ? $model->value + $value : $value;
        $model->save();
        return $model;
    }

    public static function chekUserByYohoho($entity, $user_id)
    {
        $where = array(
            ':entity_id' => $entity->primaryKey,
            ':entity_name' => get_class($entity),
            ':social_key' => 'yh',
            ':user_id' => $user_id,
        );
        $user = Yii::app()->db->createCommand()
            ->select('user_id')
            ->from('ratings_yohoho')
            ->where('entity_id=:entity_id and entity_name=:entity_name and social_key=:social_key
                    and user_id=:user_id', $where)
            ->queryRow();
        return $user;
    }

    public static function addUserByYohoho($entity, $user_id)
    {
        $user = self::chekUserByYohoho($entity, $user_id);
        if($user)
           return false;
        $insert = array(
            'entity_id' => $entity->primaryKey,
            'entity_name' => get_class($entity),
            'social_key' => 'yh',
            'user_id' => $user_id,
        );
        Yii::app()->db->createCommand()
            ->insert('ratings_yohoho', $insert);
        self::saveByEntity($entity, 'yh', 2, true);
        return true;
    }

    public static function deleteByYohoho($entity, $user_id)
    {
        $where = array(
            ':entity_id' => $entity->primaryKey,
            ':entity_name' => get_class($entity),
            ':social_key' => 'yh',
            ':user_id' => $user_id,
        );
        Yii::app()->db->createCommand()
            ->delete('ratings_yohoho', 'entity_id=:entity_id and entity_name=:entity_name
                    and social_key=:social_key and user_id=:user_id', $where);
        self::saveByEntity($entity, 'yh', -2, true);
    }

    public static function pushUserByYohoho($entity, $user_id)
    {
        if(!self::addUserByYohoho($entity, $user_id))
            self::deleteByYohoho($entity, $user_id);
    }
}