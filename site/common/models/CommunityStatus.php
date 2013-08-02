<?php

/**
 * This is the model class for table "community__statuses".
 *
 * The followings are the available columns in table 'community__statuses':
 * @property int $id
 * @property int $content_id
 * @property string $text
 * @property int $mood_id
 *
 * The followings are the available model relations:
 * @property CommunityContent $content
 * @property UserMood $mood
 */
class CommunityStatus extends HActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return CommunityStatus the static model class
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
        return 'community__statuses';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return array(
            array('text', 'length', 'max' => 250),
            array('mood_id', 'default', 'setOnEmpty' => true, 'value' => null),
            array('mood_id', 'exist', 'attributeName' => 'id', 'className' => 'UserMood'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        return array(
            'content' => array(self::BELONGS_TO, 'CommunityContent', 'content_id'),
            'mood' => array(self::BELONGS_TO, 'UserMood', 'mood_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'content_id' => 'Content',
            'text' => 'Text',
            'mood_id' => 'Mood',
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

        $criteria->compare('id',$this->id,true);
        $criteria->compare('content_id',$this->content_id,true);
        $criteria->compare('text',$this->text,true);
        $criteria->compare('mood_id',$this->status_id,true);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }

    public function getPhoto()
    {
        return null;
    }

    public function getContent()
    {
        return BlogContent::model()->findByPk($this->content_id);
    }
}