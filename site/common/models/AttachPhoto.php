<?php

/**
 * This is the model class for table "album_photos_attaches".
 *
 * The followings are the available columns in table 'album_photos_attaches':
 * @property integer $id
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
            array('id', 'numerical'),
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

    public function afterSave()
    {
        if($this->isNewRecord)
        {
            if($this->photo->album_id == null)
            {
                switch($this->entity)
                {
                    case 'User' : $type = 1; break;
                    case 'Comment' : $type = 2; break;
                    case 'Baby' : $type = 3; break;
                    case 'UserPartner' : $type = 3; break;
                    default : $type = 0;
                }
                if($type != 0)
                {
                    $album = Album::model()->findByAttributes(array('author_id' => Yii::app()->user->id, 'type' => $type));
                    if(!$album)
                    {
                        $album = new Album;
                        $album->author_id = Yii::app()->user->id;
                        $album->type = $type;
                        $album->title = Album::$systems[$type];
                        $album->save();
                    }
                    $this->photo->album_id = $album->primaryKey;
                }
                $this->photo->save(false);
            }
        }
    }
}