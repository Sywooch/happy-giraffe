<?php

/**
 * This is the model class for table "album_photos_attaches".
 *
 * The followings are the available columns in table 'album_photos_attaches':
 * @property string $photo_id
 * @property string $entity
 * @property string $entity_id
 *
 * The followings are the available model relations:
 * @property AlbumPhoto $photo
 */
class AttachPhoto extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return AttachPhoto the static model class
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
		return 'album_photos_attaches';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('photo_id, entity, entity_id', 'required'),
			array('photo_id', 'length', 'max'=>11),
			array('entity', 'length', 'max'=>50),
			array('entity_id', 'length', 'max'=>10),
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
			'photo' => array(self::BELONGS_TO, 'AlbumPhoto', 'photo_id'),
		);
	}

    public function findByEntity($entity, $entity_id)
    {
        return $this->findAll('entity = :entity and entity_id = :entity_id', array(
            ':entity' => $entity,
            ':entity_id' => $entity_id
        ));
    }
}