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
 *
 * The followings are the available model relations:
 * @property PhotoAttach[] $photoAttaches
 * @property PhotoCollection[] $photoCollections
 */

namespace site\frontend\modules\photo\models;

use site\frontend\modules\photo\components\FileHelper;

class Photo extends \HActiveRecord
{
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
			array('description, width, height, original_name', 'required'),
			array('title', 'length', 'max'=>255),
			array('width, height', 'length', 'max'=>5),
			array('original_name, fs_name', 'length', 'max'=>100),
			array('created, updated', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, title, description, width, height, original_name, fs_name, created, updated', 'safe', 'on'=>'search'),
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

    public static function createByPath($path, $userId = null)
    {
        if ($userId === null) {
            if (\Yii::app()->user->isGuest) {
                throw new \CHttpException('У нас проблемы');
            } else {
                $userId = \Yii::app()->user->id;
            }
        }

        $imageSize = getimagesize($path);
        $model = new Photo();
        $model->width = $imageSize[0];
        $model->height = $imageSize[1];
        $model->original_name = FileHelper::getName($path);
        $model->fs_name = sha1_file($path);

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
}
