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
            array('cover_id', 'validateCover', 'on' => 'setCover'),
        );
    }

    public function validateCover($attribute, $params)
    {
        if (! PhotoAttach::model()->collection($this->id)->exists('id = :id', array(':id' => $this->$attribute))) {
            $this->addError($attribute, '');
        }
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
            'cover' => array(self::BELONGS_TO, 'site\frontend\modules\photo\models\PhotoAttach', 'cover_id'),
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
        if (isset(self::$config[$attributes['entity']][$attributes['key']])) {
            $class = self::$config[$attributes['entity']][$attributes['key']];
        } else {
            $class = 'site\frontend\modules\photo\models\PhotoCollection';
        }

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

    public function setCover($attach)
    {
        $this->cover_id = $attach;
        return $this->save();
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
            'id' => (int) $this->id,
            'attachesCount' => (int) $this->attachesCount,
            'cover' => $this->cover,
            'updated' => strtotime($this->updated),
        );
    }

    public function attachPhoto($photoId, $position = 0)
    {
        $attach = new PhotoAttach();
        $attach->photo_id = $photoId;
        $attach->position = $position;
        $attach->collection_id = $this->id;
        $success = $attach->save();
        if ($success && $this->cover_id === null) {
            $this->setCover($attach->id);
        }
        return $success;
    }

    public function attachPhotos($ids, $replace = false)
    {
        if (empty($ids)) {
            return false;
        }

        if ($replace) {
            $this->removeAttaches();
        }

        $collections = array_merge(array($this), $this->getRelatedCollections());
        $success = true;
        foreach ($collections as $collection) {
            $startPosition = $this->getMaxPosition() + 1;
            if ($collection->cover_id === null) {
                $collection->setCover($ids[0]);
            }

            foreach ($ids as $i => $photoId) {
                $position = $startPosition + $i;
                $success = $success && $collection->attachPhoto($photoId, $position);
                $collection->update(array('updated'));
            }
        }
        return $success;
    }

    public function removeAttaches()
    {
        return PhotoAttach::model()->deleteAll('collection_id = :collectionId', array(':collectionId' => $this->id)) > 0;
    }

    public function sortAttaches($attachesIds)
    {
        foreach ($attachesIds as $i => $attachId) {
            PhotoAttach::model()->updateByPk($attachId, array('position' => $i));
        }
    }

    public function moveAttaches(PhotoCollection $destinationCollection, $attachesIds)
    {
        $startPosition = $this->getMaxPosition() + 1;

        $criteria = new \CDbCriteria(array(
            'scopes' => array(
                'collection' => $this->id,
            ),
        ));
        $criteria->addInCondition('id', $attachesIds);

        $attaches = PhotoAttach::model()->findAll($criteria);
        $success = true;
        foreach ($attaches as $i => $attach) {
            $position = $startPosition + $i;
            $attach->position = $position;
            $attach->collection_id = $destinationCollection->id;
            $success = $success && $attach->update(array('position', 'collection_id'));
        }
        return $success;
    }

    /**
     * @return \site\frontend\modules\photo\models\PhotoCollection[]
     */
    public function getRelatedCollections()
    {
        return array();
    }

    protected function getMaxPosition()
    {
        $criteria = new \CDbCriteria(array(
            'select' => 'MAX(position)',
            'scopes' => array(
                'collection' => $this->id,
            ),
        ));
        PhotoAttach::model()->applyScopes($criteria);
        $maxPosition = \Yii::app()->db->commandBuilder->createFindCommand(PhotoAttach::model()->tableName(), $criteria)->queryScalar();
        return ($maxPosition !== null) ? $maxPosition : -1;
    }
}
