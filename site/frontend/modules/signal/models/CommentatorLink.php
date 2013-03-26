<?php

/**
 * This is the model class for table "commentators__links".
 *
 * The followings are the available columns in table 'commentators__links':
 * @property string $id
 * @property string $url
 * @property string $entity
 * @property string $entity_id
 * @property string $user_id
 * @property string $created
 * @property integer $count
 *
 * The followings are the available model relations:
 * @property User $user
 */
class CommentatorLink extends HActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return CommentatorLink the static model class
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
        return 'commentators__links';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('url, entity, entity_id, user_id, created', 'required'),
            array('count', 'numerical', 'integerOnly' => true),
            array('url', 'length', 'max' => 1024),
            array('url', 'unique'),
            array('entity', 'length', 'max' => 16),
            array('entity_id, user_id', 'length', 'max' => 10),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, url, entity, entity_id, user_id, created, count', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        return array(
            'user' => array(self::BELONGS_TO, 'User', 'user_id'),
        );
    }

    /**
     * Проверяет откуда пришел посетитель страницы, если пришел с проставленной комментатором ссылки,
     * увеличиваем кол-во переходов по этой ссылке на 1
     * @param $entity string сущность на которую пришел посетитель
     * @param $entity_id int id сущности на которую пришел посетитель
     */
    public static function checkPageVisit($entity, $entity_id)
    {
        $ref = Yii::app()->request->urlReferrer;
        if (!empty($ref) && strpos($ref, 'http://www.happy-giraffe.ru') !== 0) {
            $models = self::model()->findAllByAttributes(array('url' => Yii::app()->request->urlReferrer));
            foreach ($models as $model)
                if ($model->entity == $entity && $model->entity_id == $entity_id) {
                    $model->count++;
                    $model->update(array('count'));
                }
        }
    }
}