<?php

/**
 * This is the model class for table "photo__photos".
 *
 * The followings are the available columns in table 'photo__photos':
 * @property string $id
 * @property string $title
 * @property string $description
 * @property string $width
 * @property string $height
 * @property string $original_name
 * @property string $fs_name
 * @property string $created
 * @property string $updated
 * @property string $author_id
 *
 * The followings are the available model relations:
 * @property PhotoAttach[] $photoAttaches
 * @property PhotoCollection[] $photoCollections
 * @property \User $author
 */

namespace site\frontend\modules\photo\models;

use site\frontend\modules\photo\components\FileHelper;

class Photo extends \HActiveRecord
{
    const ROOT_ALIAS = 'site.common.uploads.photos.v2';

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'photo__photos';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('width, height, original_name, author_id', 'required'),
			array('title', 'length', 'max'=>255),
			array('width, height', 'length', 'max'=>5),
			array('original_name, fs_name', 'length', 'max'=>100),
			array('author_id', 'length', 'max'=>11),
			array('created, updated', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, title, description, width, height, original_name, fs_name, created, updated, author_id', 'safe', 'on'=>'search'),
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
			'photoAttaches' => array(self::HAS_MANY, 'PhotoAttaches', 'photo_id'),
			'photoCollections' => array(self::HAS_MANY, 'PhotoCollections', 'cover_id'),
			'author' => array(self::BELONGS_TO, 'Users', 'author_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'title' => 'Title',
			'description' => 'Description',
			'width' => 'Width',
			'height' => 'Height',
			'original_name' => 'Original Name',
			'fs_name' => 'Fs Name',
			'created' => 'Created',
			'updated' => 'Updated',
			'author_id' => 'Author',
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
		$criteria->compare('title',$this->title,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('width',$this->width,true);
		$criteria->compare('height',$this->height,true);
		$criteria->compare('original_name',$this->original_name,true);
		$criteria->compare('fs_name',$this->fs_name,true);
		$criteria->compare('created',$this->created,true);
		$criteria->compare('updated',$this->updated,true);
		$criteria->compare('author_id',$this->author_id,true);

		return new \CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Photo the static model class
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
            )
        );
    }

    public function getOriginalPath()
    {
        return \Yii::getPathOfAlias(self::ROOT_ALIAS . '.originals') . DIRECTORY_SEPARATOR . $this->fs_name;
    }

    public function getOriginalUrl()
    {
        return \Yii::app()->params['photos_url'] . '/originals/' . $this->fs_name;
    }
}
