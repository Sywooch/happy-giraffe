<?php

namespace site\frontend\modules\photo\models;
use site\frontend\modules\photo\components\observers\PhotoCollectionObserver;

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
 * @property \site\frontend\modules\photo\models\PhotoAttach[] $attaches
 * @property int $attachesCount $attachesCount
 * @property \site\frontend\modules\photo\models\PhotoAttach $userDefinedCover
 */

class PhotoCollection extends \HActiveRecord implements \IHToJSON
{
    private $_observer;

    public static $config = array(
        'PhotoAlbum' => array(
            'default' => 'site\frontend\modules\photo\models\collections\AlbumPhotoCollection',
        ),
        'CommunityContent' => array(
            'default' => 'site\frontend\modules\photo\models\collections\CommunityContentPhotoCollection',
        ),
        'FamilyMember' => array(
            'default' => 'site\frontend\modules\photo\models\collections\FamilyMemberPhotoCollection',
        ),
        'Family' => array(
            'default' => 'site\frontend\modules\photo\models\collections\FamilyPhotoCollection',
            'all' => 'site\frontend\modules\photo\models\collections\FamilyAllPhotoCollection',
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
            'attaches' => array(self::HAS_MANY, 'site\frontend\modules\photo\models\PhotoAttach', 'collection_id'),
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
        if (isset($attributes['entity'])) {
            $class = self::getClassName($attributes['entity'], $attributes['key']);
        } else {
            $class = get_class($this);
        }
        $model = new $class(null);
        return $model;
    }

    public static function getClassName($entity, $key)
    {
        if (isset(self::$config[$entity][$key])) {
            $class = self::$config[$entity][$key];
        } else {
            $class = 'site\frontend\modules\photo\models\PhotoCollection';
        }
        return $class;
    }

    public function behaviors()
    {
        return array(
            'HTimestampBehavior' => array(
                'class' => 'HTimestampBehavior',
                'createAttribute' => 'created',
                'updateAttribute' => 'updated',
                'setUpdateOnCreate' => true,
            ),
            'RelatedModelBehavior' => array(
                'class' => 'site.common.behaviors.RelatedEntityBehavior',
                'possibleRelations' => array(
                    'PhotoAlbum' => '\site\frontend\modules\photo\models\PhotoAlbum',
                    'CommunityContent' => '\CommunityContent',
                    'FamilyMember' => '\site\frontend\modules\family\models\FamilyMember',
                    'Family' => '\site\frontend\modules\family\models\Family',
                ),
            ),
            'UrlBehavior' => array(
                'class' => 'site\common\behaviors\UrlBehavior',
                'preparedUrl' => array($this, 'getUrlInternal'),
            ),
        );
    }

    public function getUrlInternal($model)
    {
        $parentModel = $model->RelatedModelBehavior->relatedModel;
        if ($parentModel !== null && $parentModel->asa('UrlBehavior') || method_exists($parentModel, 'getUrl')) {
            return $parentModel->getUrl();
        }
        return false;
    }

    public function getAttachUrl(PhotoAttach $attach)
    {
        return $this->getUrl() . 'photo' . $attach->photo_id . '/';
    }

    public function setCover(PhotoAttach $attach)
    {
        if ($attach->collection_id == $this->id) {
            $this->cover = $attach;
            $this->cover_id = $attach->id;
            return true;
        }
        return false;
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
        $attach->collection = $this;
        $success = $attach->save();
        return ($success) ? $attach : false;
    }

    public function attachPhotos($ids, $replace = false)
    {
        if (empty($ids)) {
            return false;
        }

        if (! is_array($ids)) {
            $ids = array($ids);
        }

        $newAttaches = self::attachPhotosInternal($this, $ids, $replace);
        $relatedCollections = $this->getRelatedCollections();
        /** @var \site\frontend\modules\photo\models\PhotoCollection $collection */
        foreach ($relatedCollections as $collection) {
            self::attachPhotosInternal($collection, $ids, $replace);
        }
        return $newAttaches;
    }

    /**
     * @param PhotoCollection $collection
     * @param $ids
     * @param $replace
     * @throws \CDbException
     * @todo оптимизировать для больших коллекций
     */
    protected static function attachPhotosInternal(PhotoCollection $collection, $ids, $replace)
    {
        if ($replace) {
            $attaches = array();
            /** @var \site\frontend\modules\photo\models\PhotoAttach $attach */
            foreach ($collection->attaches as $attach) {
                if (array_search($attach->photo_id, $ids) === false) {
                    $attach->scenario = 'attachPhotos';
                    $attach->delete();
                    if ($attach->id == $collection->cover_id) {
                        $collection->cover = null;
                    }
                } else {
                    $attaches[] = $attach;
                }
            }
            $maxPosition = 0;
        } else {
            $attaches = $collection->attaches;
            $maxPosition = $collection->getMaxPosition();
        }

        $newAttaches = array();
        foreach ($ids as $positionOffset => $id) {
            $newPosition = $maxPosition + $positionOffset + 1;
            if ($attach = $collection->getAttachByPhotoId($id)) {
                $updatePosition = $replace && ($attach->position != $newPosition);
                if ($updatePosition) {
                    $attach->position = $newPosition;
                    $attach->update(array('position'));
                }
            } else {
                $attach = $collection->attachPhoto($id, $newPosition);
                $attaches[] = $attach;
                $newAttaches[] = $attach;
            }
        }

        $collection->attaches = $attaches;
        if ($collection->cover === null) {
            $collection->setCover($collection->getDefaultCover());
        }
        $collection->update(array('updated', 'cover_id'));

        return $newAttaches;
    }

    protected function getDefaultCover()
    {
        return (isset($this->attaches[0])) ? $this->attaches[0] : null;
    }

    protected function getAttachByPhotoId($photoId)
    {
        foreach ($this->attaches as $attach) {
            if ($attach->photo_id == $photoId) {
                return $attach;
            }
        }
        return null;
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

    /**
     * @return \site\frontend\modules\photo\components\observers\PhotoCollectionObserver
     */
    protected function getObserver()
    {
        if ($this->_observer === null) {
            $this->_observer = PhotoCollectionObserver::getObserver($this);
        }
        return $this->_observer;
    }

    public function getAuthor()
    {
        if ($this->RelatedModelBehavior->relatedModel) {
            return $this->RelatedModelBehavior->relatedModel->author;
        }
        return null;
    }
}
