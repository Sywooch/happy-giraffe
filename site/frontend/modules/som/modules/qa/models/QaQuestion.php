<?php

/**
 * This is the model class for table "qa__questions".
 *
 * The followings are the available columns in table 'qa__questions':
 * @property string $id
 * @property string $title
 * @property string $text
 * @property integer $sendNotifications
 * @property string $categoryId
 * @property string $authorId
 * @property string $dtimeCreate
 * @property string $dtimeUpdate
 * @property string $url
 *
 * The followings are the available model relations:
 * @property QaCategories $category
 */
class QaQuestion extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'qa__questions';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('text, sendNotifications, categoryId, authorId', 'required'),
			array('sendNotifications', 'numerical', 'integerOnly'=>true),
			array('title', 'length', 'max'=>150),
			array('categoryId, authorId', 'length', 'max'=>11),
			array('dtimeCreate, dtimeUpdate', 'length', 'max'=>10),
			array('url', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, title, text, sendNotifications, categoryId, authorId, dtimeCreate, dtimeUpdate, url', 'safe', 'on'=>'search'),
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
			'category' => array(self::BELONGS_TO, 'QaCategories', 'categoryId'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'title' => 'Title',
			'text' => 'Text',
			'sendNotifications' => 'Send Notifications',
			'categoryId' => 'Category',
			'authorId' => 'Author',
			'dtimeCreate' => 'Dtime Create',
			'dtimeUpdate' => 'Dtime Update',
			'url' => 'Url',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('text',$this->text,true);
		$criteria->compare('sendNotifications',$this->sendNotifications);
		$criteria->compare('categoryId',$this->categoryId,true);
		$criteria->compare('authorId',$this->authorId,true);
		$criteria->compare('dtimeCreate',$this->dtimeCreate,true);
		$criteria->compare('dtimeUpdate',$this->dtimeUpdate,true);
		$criteria->compare('url',$this->url,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return QaQuestion the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
