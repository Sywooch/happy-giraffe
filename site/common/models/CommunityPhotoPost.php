<?php

/**
 * This is the model class for table "community__photo_posts".
 *
 * The followings are the available columns in table 'community__photo_posts':
 * @property string $content_id
 * @property string $text
 * @property string $photo_id
 *
 * The followings are the available model relations:
 * @property AlbumPhoto $photo
 * @property CommunityContent $content
 */
class CommunityPhotoPost extends HActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return CommunityPhotoPost the static model class
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
		return 'community__photo_posts';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
			array('content_id, photo_id', 'required'),
			array('content_id, photo_id', 'length', 'max'=>11),
			array('text', 'safe'),
			array('content_id, text, photo_id', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array(
			'photo' => array(self::BELONGS_TO, 'AlbumPhoto', 'photo_id'),
			'content' => array(self::BELONGS_TO, 'CommunityContent', 'content_id'),
		);
	}

}