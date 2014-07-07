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
 * @property integer $updated
 * @property integer $removed
 *
 * The followings are the available model relations:
 * @property PhotoAttach[] $photoAttaches
 * @property Photo $cover
 */

namespace site\frontend\modules\photo\models;

class PhotoCollection extends \HActiveRecord
{
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
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
//			array('updated, removed', 'required'),
//			array('updated, removed', 'numerical', 'integerOnly'=>true),
//			array('entity, key', 'length', 'max'=>255),
//			array('entity_id, cover_id', 'length', 'max'=>11),
//			array('created', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, entity, entity_id, key, cover_id, created, updated, removed', 'safe', 'on'=>'search'),
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
			'userDefinedCover' => array(self::BELONGS_TO, 'site\frontend\modules\photo\models\Photo', 'cover_id'),
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
			'removed' => 'Removed',
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
	 * @return \CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new \CDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('entity',$this->entity,true);
		$criteria->compare('entity_id',$this->entity_id,true);
		$criteria->compare('key',$this->key,true);
		$criteria->compare('cover_id',$this->cover_id,true);
		$criteria->compare('created',$this->created,true);
		$criteria->compare('updated',$this->updated);
		$criteria->compare('removed',$this->removed);

		return new \CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
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
}
