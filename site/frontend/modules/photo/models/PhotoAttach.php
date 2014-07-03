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
 *
 * The followings are the available model relations:
 * @property Photo $photo
 * @property PhotoCollection $collection
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
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('photo_id, collection_id', 'required'),
			array('photo_id, collection_id, position', 'length', 'max'=>11),
			array('created, updated', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, photo_id, collection_id, position, data, created, updated', 'safe', 'on'=>'search'),
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
		$criteria->compare('photo_id',$this->photo_id,true);
		$criteria->compare('collection_id',$this->collection_id,true);
		$criteria->compare('position',$this->position,true);
		$criteria->compare('data',$this->data,true);
		$criteria->compare('created',$this->created,true);
		$criteria->compare('updated',$this->updated,true);

		return new \CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
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

    public function toJSON()
    {
        return array(
            'position' => (int) $this->position,
            'photo' => $this->photo,
        );
    }
}
