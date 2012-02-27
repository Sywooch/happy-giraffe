<?php

/**
 * This is the model class for table "album_photos".
 *
 * The followings are the available columns in table 'album_photos':
 * @property integer $id
 * @property string $user_id
 * @property string $album_id
 * @property string $file_name
 * @property string $fs_name
 * @property string $previewUrl
 * @property string $originalUrl
 * @property string $created
 * @property string $updated
 *
 * The followings are the available model relations:
 * @property Album $album
 * @property User $user
 */
class AlbumPhoto extends CActiveRecord
{
    private $_check_access = null;

    /**
     * @var string original photos folder
     */
    private $original_folder = 'originals';
    /**
     * @var string thumbnail image folder
     */
    private $thumb_folder = 'thumbs';
    /**
     * @var CUploadedFile
     */
    public $file;

    /**
     * Returns the static model of the specified AR class.
     * @return AlbumPhoto the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'album_photos';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('user_id, album_id, file_name', 'required'),
            array('user_id, album_id', 'length', 'max' => 10),
            array('file_name, fs_name', 'length', 'max' => 100),
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
            'album' => array(self::BELONGS_TO, 'Album', 'album_id'),
            'user' => array(self::BELONGS_TO, 'User', 'user_id'),
            'attach' => array(self::HAS_MANY, 'AttachPhoto', 'photo_id'),
        );
    }

    public function scopes()
    {
        return array(
            'forAlbum' => array(
                'limit' => 3,
            )
        );
    }

    /**
     * @return array
     */
    public function behaviors()
    {
        return array(
            'CTimestampBehavior' => array(
                'class' => 'zii.behaviors.CTimestampBehavior',
                'createAttribute' => 'created',
                'updateAttribute' => 'updated',
            )
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'user_id' => 'User',
            'album_id' => 'Album',
            'file_name' => 'File Name',
            'created' => 'Дата создания',
            'updated' => 'Дата последнего обновления',
        );
    }

    /**
     * Save entity and save image in the file system
     * @return bool
     */
    public function create()
    {
        $this->file_name = $this->file;
        $this->fs_name = md5($this->file_name) . '.' . $this->file->extensionName;
        if ($this->save())
        {
            $this->saveFile();
            return true;
        }
        return false;
    }

    /**
     * Save file in the file system
     * @return bool
     */
    public function saveFile()
    {
        $dir = Yii::getPathOfAlias('site.common.uploads.photos');
        $model_dir = $dir . DIRECTORY_SEPARATOR . $this->original_folder . DIRECTORY_SEPARATOR . $this->primaryKey;
        mkdir($model_dir);
        $file_name = $model_dir . DIRECTORY_SEPARATOR . $this->fs_name;
        return $this->file->saveAs($file_name);
    }

    /**
     * Get path to the original image
     * @return string
     */
    public function getOriginalPath()
    {
        $dir = Yii::getPathOfAlias('site.common.uploads.photos');
        return $dir . DIRECTORY_SEPARATOR . $this->original_folder . DIRECTORY_SEPARATOR . $this->primaryKey .
            DIRECTORY_SEPARATOR . $this->fs_name;
    }

    /**
     * Get url to the original image
     * @return string
     */
    public function getOriginalUrl()
    {
        return implode('/', array(
            Yii::app()->params['photos_url'],
            $this->original_folder,
            $this->primaryKey,
            $this->fs_name,
        ));
    }

    /**
     * Get path to the preview image
     *
     * @param int $width
     * @param int $height
     *
     * @return string
     */public function getPreviewPath($width = 100, $height = 100)
    {
        // Uload root
        $dir = Yii::getPathOfAlias('site.common.uploads.photos');
        // Thumb relative path
        $thumb_dir = $this->thumb_folder . DIRECTORY_SEPARATOR . $width . 'x' . $height;
        // Thumb file system path
        $thumb_path = $dir . DIRECTORY_SEPARATOR . $thumb_dir;
        // Entity file system path
        $model_dir = $thumb_path . DIRECTORY_SEPARATOR . $this->primaryKey;
        // Image file system path
        $thumb = $model_dir . DIRECTORY_SEPARATOR . $this->fs_name;
        if(!file_exists($thumb))
        {
            if(!file_exists($thumb_path))
            {
                mkdir($thumb_path);
                $handle = fopen($thumb_path . DIRECTORY_SEPARATOR . 'index.html', 'x+');
                fclose($handle);
            }
            if(!file_exists($model_dir))
                mkdir($model_dir);
            Yii::import('ext.image.Image');
            $image = new Image($this->originalPath);
            $image->resize($width, $height, Image::AUTO);
            $image->save($thumb);
        }
        return $thumb;
    }

    /**
     * Get preview image url
     *
     * @param int $width
     * @param int $height
     * @return string
     */
    public function getPreviewUrl($width = 100, $height = 100)
    {
        $this->getPreviewPath($width, $height);
        return implode('/', array(
            Yii::app()->params['photos_url'],
            $this->thumb_folder,
            $width . 'x' . $height,
            $this->primaryKey,
            $this->fs_name,
        ));
    }

    public function getCheckAccess()
    {
        return true;
    }
}