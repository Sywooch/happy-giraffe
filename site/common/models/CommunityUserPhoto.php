<?php

/**
 * This is the model class for table "community__user_photos".
 *
 * The followings are the available columns in table 'community__user_photos':
 * @property integer $id
 * @property string $content_id
 * @property string $photo_id
 * @property string $description
 *
 * The followings are the available model relations:
 * @property CommunityContent $content
 * @property AlbumPhoto $photo
 */
class CommunityUserPhoto extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return CommunityUserPhoto the static model class
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
		return 'community__user_photos';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('content_id, photo_id, description', 'required'),
			array('content_id, photo_id', 'length', 'max'=>10),
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
			'content' => array(self::BELONGS_TO, 'CommunityContent', 'content_id'),
			'photo' => array(self::BELONGS_TO, 'AlbumPhoto', 'photo_id'),
		);
	}
}