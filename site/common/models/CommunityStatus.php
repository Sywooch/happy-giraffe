<?php

/**
 * This is the model class for table "community__statuses".
 *
 * The followings are the available columns in table 'community__statuses':
 * @property int $id
 * @property int $status_id
 * @property int $content_id
 * @property string $text
 *
 * The followings are the available model relations:
 * @property CommunityContent $content
 * @property UserStatus $status
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
            array('content_id', 'length', 'max' => 11),
            array('content_id', 'numerical', 'integerOnly' => true),
            array('text', 'safe')
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        return array(
            'content' => array(self::BELONGS_TO, 'CommunityContent', 'content_id'),
            'status' => array(self::BELONGS_TO, 'UserStatus', 'status_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'status_id' => 'Status',
            'content_id' => 'Content',
            'text' => 'Text',
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
        $criteria->compare('status_id',$this->status_id,true);
        $criteria->compare('content_id',$this->content_id,true);
        $criteria->compare('text',$this->text,true);

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