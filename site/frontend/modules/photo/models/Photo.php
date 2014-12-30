<?php

namespace site\frontend\modules\photo\models;
use site\frontend\modules\photo\components\ImageFile;
use site\frontend\modules\photo\helpers\FsNameHelper;
use site\frontend\modules\photo\helpers\ImageSizeHelper;

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
 * @property \site\frontend\modules\photo\models\PhotoAttach[] $photoAttaches
 * @property \User $author
 */

class Photo extends \HActiveRecord implements \IHToJSON, \IPreview
{
    protected $imageStringBuffer;

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
            'oldPhoto' => array(self::HAS_ONE, '\AlbumPhoto', 'newPhotoId'),
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
            'HTimestampBehavior' => array(
                'class' => 'HTimestampBehavior',
                'createAttribute' => 'created',
                'updateAttribute' => 'updated',
                'setUpdateOnCreate' => true,
            ),
            'AuthorBehavior' => array(
                'class' => 'site\common\behaviors\AuthorBehavior',
            ),
            'FsBehavior' => array(
                'class' => 'site\frontend\modules\photo\behaviors\FsBehavior',
                'fs' => \Yii::app()->fs,
                'prefix' => 'originals',
                'fsName' => 'fs_name',
            ),
        );
    }

    protected function createFsName()
    {
        $hash = md5(uniqid($this->original_name . microtime(), true));
        return FsNameHelper::createFsName($hash);
    }

    public function toJSON()
    {
        return array(
            'id' => (int) $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'originalName' => $this->original_name,
            'width' => (int) $this->width,
            'height' => (int) $this->height,
            'fsName' => $this->fs_name,
            'originalUrl' => \Yii::app()->fs->getUrl($this->getFile()->getKey()),
        );
    }

    protected function writeImage(\CEvent $event)
    {
        $event->isValid = $this->getFile()->setContent($this->imageStringBuffer);
    }

    protected function createThumbs(\CEvent $event)
    {
        \Yii::app()->gearman->client()->doBackground('createThumbs', $this->id);
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
        $this->fs_name = $this->createFsName() . '.' . $extension;
        $this->imageStringBuffer = $imageString;
        $this->attachEventHandler('onBeforeSave', array($this, 'writeImage'));
    }

    public function getImage()
    {
        return $this->getFile()->getContent();
    }

    /*
     * @todo поставить корректный пресет
     */
    public function getPreviewPhoto()
    {
        return \Yii::app()->thumbs->getThumb($this, 'rowGrid')->getUrl();
    }

    public function getPreviewText()
    {
        return $this->description;
    }
}
