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
    public static function saveByEntity($entity, $social_key, $value)
    {
        $model = self::findByEntity($entity, $social_key);
        if(!$model)
        {
            $model = new Rating;
            $model->entity_name = get_class($entity);
            $model->entity_id = $entity->primaryKey;
            $model->social_key = $social_key;
        }
        $model->value = $value;
        $model->save();
        return $model;
    }
}