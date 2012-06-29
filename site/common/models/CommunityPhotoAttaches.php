<?php

/**
 * This is the model class for table "community__content_photo_attaches".
 *
 * The followings are the available columns in table 'community__content_photo_attaches':
 * @property string $id
 * @property string $content_id
 * @property string $photo_id
 * @property string $title
 * @property string $description
 * @property string $created
 *
 * The followings are the available model relations:
 * @property AlbumPhotos $photo
 * @property CommunityContents $content
 */
class CommunityPhotoAttaches extends CActiveRecord
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'community__content_photo_attaches';
	}

	public function rules()
	{
		return array(
			array('content_id, photo_id, title', 'required'),
			array('content_id, photo_id', 'length', 'max'=>10),
			array('title', 'length', 'max'=>70),
			array('description', 'length', 'max'=>200),
            array('created', 'safe')
		);
	}

	public function relations()
	{
		return array(
			'photo' => array(self::BELONGS_TO, 'AlbumPhotos', 'photo_id'),
			'content' => array(self::BELONGS_TO, 'CommunityContents', 'content_id'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'content_id' => 'Content',
			'photo_id' => 'Photo',
			'title' => 'Title',
			'description' => 'Description',
			'created' => 'Created',
		);
	}

    public function behaviors()
    {
        return array(
            'CTimestampBehavior' => array(
                'class' => 'zii.behaviors.CTimestampBehavior',
                'createAttribute' => 'created',
                'updateAttribute' => null,
            )
        );
    }
}