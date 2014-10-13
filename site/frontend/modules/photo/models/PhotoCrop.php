<?php

/**
 * This is the model class for table "photo__crops".
 *
 * The followings are the available columns in table 'photo__crops':
 * @property string $id
 * @property integer $x
 * @property integer $y
 * @property integer $w
 * @property integer $h
 * @property string $photo_id
 *
 * The followings are the available model relations:
 * @property site\frontend\modules\photo\models\Photo $photo
 */
class PhotoCrop extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'photo__crops';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{

	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'photo' => array(self::BELONGS_TO, 'Photo', 'photo_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'x' => 'X',
			'y' => 'Y',
			'w' => 'W',
			'h' => 'H',
			'photo_id' => 'Photo',
		);
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return PhotoCrop the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    public function afterSave()
    {

        parent::afterSave();
    }
}
