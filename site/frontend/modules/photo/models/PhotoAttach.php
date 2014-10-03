<?php
/**
 * This is the model class for table "photo__attaches".
 *
 * The followings are the available columns in table 'photo__attaches':
 * @property string $id
 * @property string $photo_id
 * @property string $collection_id
 * @property string $position
 * @property string $data
 * @property string $created
 * @property string $updated
 * @property string $removed
 *
 * The followings are the available model relations:
 * @property site\frontend\modules\photo\models\Photo $photo
 * @property site\frontend\modules\photo\models\PhotoCollection $collection
 */

namespace site\frontend\modules\photo\models;

class PhotoAttach extends \HActiveRecord implements \IHToJSON
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'photo__attaches';
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
			'photo' => array(self::BELONGS_TO, 'site\frontend\modules\photo\models\Photo', 'photo_id'),
			'collection' => array(self::BELONGS_TO, 'site\frontend\modules\photo\models\PhotoCollection', 'collection_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'photo_id' => 'Photo',
			'collection_id' => 'Collection',
			'position' => 'Position',
			'data' => 'Data',
			'created' => 'Created',
			'updated' => 'Updated',
            'removed' => 'Removed',
		);
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return PhotoAttach the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
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
            'softDelete' => array(
                'class' => 'site.common.behaviors.SoftDeleteBehavior',
            ),
        );
    }

    public function toJSON()
    {
        return array(
            'id' => $this->id,
            'position' => (int) $this->position,
            'photo' => $this->photo,
        );
    }

    public function collection($collectionId)
    {
        $this->getDbCriteria()->compare($this->getTableAlias() . '.collection_id', $collectionId);
        return $this;
    }

    protected function beforeDelete()
    {
        if ($this->collection->cover_id == $this->id) {
            throw new \Exception('Нельзя удалить обложку');
        }
    }
}
