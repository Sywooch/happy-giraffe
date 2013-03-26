<?php

/**
 * This is the model class for table "commentators__likes".
 *
 * The followings are the available columns in table 'commentators__likes':
 * @property integer $id
 * @property string $entity
 * @property integer $entity_id
 * @property string $user_id
 * @property integer $social_id
 *
 * The followings are the available model relations:
 * @property User $user
 */
class CommentatorLike extends HActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return CommentatorLike the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'commentators__likes';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('entity, entity_id, user_id, social_id', 'required'),
            array('entity_id, social_id', 'numerical', 'integerOnly' => true),
            array('entity', 'length', 'max' => 16),
            array('user_id', 'length', 'max' => 10),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, entity, entity_id, user_id, social_id', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'user' => array(self::BELONGS_TO, 'User', 'user_id'),
        );
    }

    /**
     * Добавить лайк комментатора к статье
     * @param $entity string класс статьи
     * @param $entity_id int id статьи
     * @param $social_id int id соц сети
     */
    public static function addCurrentUserLike($entity, $entity_id, $social_id)
    {
        $model = self::model()->findByAttributes(array(
            'entity' => $entity,
            'entity_id' => $entity_id,
            'social_id' => $social_id,
        ));
        if ($model === null){
            $model = new self;
            $model->user_id = Yii::app()->user->id;
            $model->entity_id = $entity_id;
            $model->entity = $entity;
            $model->social_id = $social_id;
            $model->save();
        }
    }
}