<?php

/**
 * This is the model class for table "message_cache".
 *
 * The followings are the available columns in table 'message_cache':
 * @property string $id
 * @property string $user_id
 * @property string $cache
 *
 * The followings are the available model relations:
 * @property User $user
 */
class MessageCache extends CActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @return MessageCache the static model class
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
        return 'message_cache';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('user_id, cache', 'required'),
            array('user_id', 'length', 'max' => 10),
            array('cache', 'length', 'max' => 100),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('user_id, cache', 'safe', 'on' => 'search'),
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
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'user_id' => 'User',
            'cache' => 'Cache',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('user_id', $this->user_id, true);
        $criteria->compare('cache', $this->cache, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    static public function UpdateUserCache($user_id)
    {
        $model = self::model()->findByAttributes(array('user_id' => $user_id));
        if (isset($model)) {
            $model->UpdateCache();
            self::model()->updateAll(array('cache' => $model->cache), 'user_id=' . $user_id);
        } else {
            $model = new MessageCache();
            $model->user_id = $user_id;
            $model->UpdateCache();
            $model->save();
        }
    }

    public static function GetUserCache($user_id)
    {
        $value = Yii::app()->cache->get('uc_' . $user_id);
        if ($value === false) {
            $model = self::model()->find('user_id=' . $user_id);
            if (isset($model))
                $value = $model->cache;
            else {
                $model = new MessageCache();
                $model->user_id = $user_id;
                $model->UpdateCache();
                $model->save();
                $value = $model->cache;
            }
            Yii::app()->cache->set('uc_' . $user_id, $value);
        }
        return $value;
    }

    public function UpdateCache()
    {
        do {
            $cache = substr(md5(time() . $this->user_id), 0, 8);
        } while (MessageCache::model()->count('cache="' . $cache . '"') != 0);
        $this->cache = $cache;
        Yii::app()->cache->set('uc_' . $this->user_id, $cache);
    }

    /**
     * @static
     * @return string cache
     */
    public static function GetCurrentUserCache()
    {
        return self::GetUserCache(Yii::app()->user->getId());
    }

}
