<?php

/**
 * This is the model class for table "photo__collections".
 *
 * The followings are the available columns in table 'photo__collections':
 * @property string $id
 * @property string $entity
 * @property string $entity_id
 * @property string $key
 * @property string $cover_id
 * @property string $created
 * @property string $updated
 *
 * The followings are the available model relations:
 * @property site\frontend\modules\photo\models\PhotoAttach[] $attaches
 * @property int $attachesCount $attachesCount
 * @property site\frontend\modules\photo\models\PhotoAttach $userDefinedCover
 */

namespace site\frontend\modules\photo\models;

class PhotoCollection extends \HActiveRecord implements \IHToJSON
{
    public static $config = array(
        'PhotoAlbum' => array(
            'default' => 'site\frontend\modules\photo\models\collections\AlbumPhotoCollection',
        ),
        'User' => array(
            'default' => 'site\frontend\modules\photo\models\collections\UserAllPhotoCollection',
            'unsorted' => 'site\frontend\modules\photo\models\collections\UserUnsortedPhotoCollection',
        ),
    );

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'photo__collections';
	}

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return array(

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
            'attaches' => array(self::HAS_MANY, 'site\frontend\modules\photo\models\Photoattach', 'collection_id'),
            'attachesCount' => array(self::STAT, 'site\frontend\modules\photo\models\PhotoAttach', 'collection_id'),
            'userDefinedCover' => array(self::BELONGS_TO, 'site\frontend\modules\photo\models\PhotoAttach', 'cover_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'entity' => 'Entity',
			'entity_id' => 'Entity',
			'key' => 'Key',
			'cover_id' => 'Cover',
			'created' => 'Created',
			'updated' => 'Updated',
		);
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return PhotoCollection the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    protected function instantiate($attributes)
    {
        if (! isset(self::$config[$attributes['entity']][$attributes['key']])) {
            throw new \Exception('Invalid collection');
        }

        $class = self::$config[$attributes['entity']][$attributes['key']];
        $model = new $class(null);
        return $model;
    }

    public function behaviors()
    {
        return array(
            'CTimestampBehavior' => array(
                'class' => 'zii.behaviors.CTimestampBehavior',
                'createAttribute' => 'created',
                'updateAttribute' => 'updated',
                'setUpdateOnCreate' => true,
            ),
            'RelatedModelBehavior' => array(
                'class' => 'site.common.behaviors.RelatedEntityBehavior',
                'possibleRelations' => array('PhotoAlbum' => '\site\frontend\modules\photo\models\PhotoAlbum'),
            ),
        );
    }

    public function getCover()
    {
        if (empty($this->attaches)) {
            return null;
        }

        $related = $this->userDefinedCover;
        if ($related === null) {
            return $this->attaches[0]->photo;
        }
    }

    public function scopes()
    {
        return array(
            'notEmpty' => array(
                'join' => 'INNER JOIN ' . PhotoAttach::model()->tableName() . ' ON ' . $this->getTableAlias().'.id = ' . PhotoAttach::model()->tableName() . '.collection_id',
            ),
        );
    }

    public function toJSON()
    {
        return array(
            'id' => $this->id,
            'attachesCount' => (int) $this->attachesCount,
            'cover' => $this->cover,
        );
    }

    public function attachPhoto($photoId)
    {
        $attach = new PhotoAttach();
        $attach->photo_id = $photoId;
        $attach->collection_id = $this->id;
        return $attach->save();
    }
}
