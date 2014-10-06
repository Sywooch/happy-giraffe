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
use site\frontend\modules\photo\helpers\ImageSizeHelper;

class Photo extends \HActiveRecord implements \IHToJSON
{
    private $_imageFile;

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
		return array(
			array('title', 'length', 'max' => 150),
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

    public function getImageFile($refresh = false)
    {
        if ($this->_imageFile === null || $refresh) {
            $this->_imageFile = new ImageFile($this);
        }
        return $this->_imageFile;
    }

    protected function writeImage(\CModelEvent $event)
    {
        $event->isValid = $this->getImageFile()->write();
    }

    public function validate($attributes = null, $clearErrors = false)
    {
        return parent::validate($attributes, $clearErrors);
    }

    public function setImage($imageString)
    {
        $imageSize = ImageSizeHelper::getImageSize($imageString);
        if ($imageSize === false) {
            $this->addError('image', 'Загружаются только изображения');
            return;
        }
        if (! in_array($imageSize[2], array_keys(\Yii::app()->getModule('photo')->types))) {
            $this->addError('image', 'Загружаются только файлы jpg, png, gif');
            return;
        }
        $this->width = $imageSize[0];
        $this->height = $imageSize[1];
        $extension = \Yii::app()->getModule('photo')->types[$imageSize[2]];
        $this->fs_name = $this->createFsName($extension);
        $this->getImageFile()->buffer = $imageString;
        $this->attachEventHandler('onBeforeSave', array($this, 'writeImage'));
    }

    public function getImage()
    {
        return $this->getImageFile()->read();
    }
}
