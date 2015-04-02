<?php

namespace site\frontend\modules\photo\models;
use site\frontend\modules\photo\helpers\FsNameHelper;

/**
 * This is the model class for table "photo__crops".
 *
 * The followings are the available columns in table 'photo__crops':
 * @property string $id
 * @property integer $x
 * @property integer $y
 * @property integer $w
 * @property integer $h
 * @property string $photoId
 * @property string $fsName
 *
 * The followings are the available model relations:
 * @property \site\frontend\modules\photo\models\Photo $photo
 */

class PhotoCrop extends \CActiveRecord implements \IHToJSON
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
        return array(
            array('x, y, w, h', 'numerical', 'integerOnly' => true),
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
			'photo' => array(self::BELONGS_TO, 'site\frontend\modules\photo\models\Photo', 'photoId'),
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
			'photoId' => 'Photo Id',
            'fsName' => 'Fs Name',
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

    public function behaviors()
    {
        return array(
            'HTimestampBehavior' => array(
                'class' => 'HTimestampBehavior',
                'createAttribute' => 'created',
                'updateAttribute' => 'updated',
                'setUpdateOnCreate' => true,
            ),
        );
    }

    public static function create($photo, $cropData)
    {
        $crop = new PhotoCrop();
        $crop->attributes = $cropData;
        $crop->photo = $photo;
        $crop->photoId = $photo->id;
        $extension = pathinfo($crop->photo->fs_name, PATHINFO_EXTENSION);
        $crop->fsName = $crop->createFsName() . '.' . $extension;
        return $crop;
    }

    protected function createFsName()
    {
        $hash = md5(uniqid($this->id . microtime(), true));
        return FsNameHelper::createFsName($hash);
    }

    public function toJSON()
    {
        return array(
            'id' => (int) $this->id,
            'x' => (int) $this->x,
            'y' => (int) $this->y,
            'w' => (int) $this->w,
            'h' => (int) $this->h,
            'photoId' => $this->photoId,
            'fsName' => $this->fsName,
        );
    }
}
