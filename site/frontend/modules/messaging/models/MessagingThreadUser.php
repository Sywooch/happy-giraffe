<?php

/**
 * This is the model class for table "messaging__threads_users".
 *
 * The followings are the available columns in table 'messaging__threads_users':
 * @property string $user_id
 * @property string $thread_id
 * @property integer $hidden
 */
class MessagingThreadUser extends CActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return MessagingThreadUser the static model class
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
        return 'messaging__threads_users';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('user_id', 'required'),
            array('hidden', 'boolean'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('user_id, thread_id, hidden', 'safe', 'on'=>'search'),
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
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'user_id' => 'User',
            'thread_id' => 'Thread',
            'hidden' => 'Hidden',
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

        $criteria=new CDbCriteria;

        $criteria->compare('user_id',$this->user_id,true);
        $criteria->compare('thread_id',$this->thread_id,true);
        $criteria->compare('hidden',$this->hidden);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }
}