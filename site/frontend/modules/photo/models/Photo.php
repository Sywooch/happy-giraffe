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
 * @property site\frontend\modules\photo\models\PhotoAttach[] $photoAttaches
 * @property \User $author
 */

namespace site\frontend\modules\photo\models;

use site\frontend\modules\photo\components\ImageFile;

class Photo extends \HActiveRecord implements \IHToJSON
{
    private $_imageFile;
    private $_imageString;

    const FS_NAME_LEVELS = 2;
    const FS_NAME_SYMBOLS_PER_LEVEL = 2;

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
			'photoAttaches' => array(self::HAS_MANY, 'site\frontend\modules\photo\models\PhotoAttach', 'photo_id'),
			'author' => array(self::BELONGS_TO, '\User', 'author_id'),
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
            ),
            'AuthorBehavior' => array(
                'class' => 'site\common\behaviors\AuthorBehavior',
            ),
        );
    }

    protected function createFsName($extension)
    {
        $hash = md5(uniqid($this->original_name . microtime(), true));

        $path = '';
        for ($i = 0; $i < self::FS_NAME_LEVELS; $i++) {
            $dirName = substr($hash, $i * self::FS_NAME_SYMBOLS_PER_LEVEL, self::FS_NAME_SYMBOLS_PER_LEVEL);
            $path .= $dirName . DIRECTORY_SEPARATOR;
        }

        $path .= substr($hash, self::FS_NAME_LEVELS * self::FS_NAME_SYMBOLS_PER_LEVEL) . '.' . $extension;

        return $path;
    }

    public function toJSON()
    {
        return array(
            'id' => $this->id,
            'title' => $this->title,
            'original_name' => $this->original_name,
            'width' => (int) $this->width,
            'height' => (int) $this->height,
            'fs_name' => $this->fs_name,
            'originalUrl' => $this->getImageFile()->getOriginalUrl(),
        );
    }

    public function setImage($imageString)
    {
        $imageData = new ImageStringData($imageString);
        if (! $imageData->validate()) {
            return false;
        }
        $this->_imageString = $imageString;
        $this->attributes = $imageData->attributes;
        $this->fs_name = $this->createFsName($imageData->extension);
        $this->attachEventHandler('onBeforeSave', array($this, 'writeImage'));
    }

    public function getImageFile()
    {
        if ($this->_imageFile === null) {
            $this->_imageFile = new ImageFile($this);
        }
        return $this->_imageFile;
    }

    protected function writeImage(\CModelEvent $event)
    {
        $event->isValid = $this->getImageFile()->write($this->_imageString);
    }
}
