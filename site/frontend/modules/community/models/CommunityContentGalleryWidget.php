<?php

/**
 * This is the model class for table "community__content_gallery_widgets".
 *
 * The followings are the available columns in table 'community__content_gallery_widgets':
 * @property string $id
 * @property string $title
 * @property string $gallery_id
 * @property string $item_id
 * @property string $club_id
 * @property integer $hidden
 *
 * The followings are the available model relations:
 * @property CommunityClubs $club
 * @property CommunityContentGallery $gallery
 * @property CommunityContentGalleryItems $item
 */
class CommunityContentGalleryWidget extends HActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'community__content_gallery_widgets';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('gallery_id, club_id', 'required'),
			array('hidden', 'numerical', 'integerOnly'=>true),
			array('title', 'length', 'max'=>255),
			array('gallery_id, item_id, club_id', 'length', 'max'=>11),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, title, gallery_id, item_id, club_id, hidden', 'safe', 'on'=>'search'),
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
			'club' => array(self::BELONGS_TO, 'CommunityClub', 'club_id'),
			'gallery' => array(self::BELONGS_TO, 'CommunityContentGallery', 'gallery_id'),
			'item' => array(self::BELONGS_TO, 'CommunityContentGalleryItem', 'item_id'),
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
			'gallery_id' => 'Gallery',
			'item_id' => 'Item',
			'club_id' => 'Club',
			'hidden' => 'Hidden',
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
		$criteria->compare('gallery_id',$this->gallery_id,true);
		$criteria->compare('item_id',$this->item_id,true);
		$criteria->compare('club_id',$this->club_id,true);
		$criteria->compare('hidden',$this->hidden);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return CommunityContentGalleryWidget the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
