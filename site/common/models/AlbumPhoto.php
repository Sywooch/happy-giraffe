<?php

/**
 * This is the model class for table "album_photos".
 *
 * The followings are the available columns in table 'album_photos':
 * @property integer $id
 * @property string $author_id
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
     * @var string template image folder
     */
    private $tmp_folder = 'temp';
    /**
     * @var CUploadedFile
     */
    public $file;

    public $isTemplate = false;

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
            array('author_id, album_id, file_name', 'required'),
            array('author_id, album_id', 'length', 'max' => 10),
            array('file_name, fs_name', 'length', 'max' => 100),
            array('title', 'length', 'max' => 50),
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
            'author' => array(self::BELONGS_TO, 'User', 'author_id'),
            'attach' => array(self::HAS_MANY, 'AttachPhoto', 'photo_id'),
            'remove' => array(self::HAS_ONE, 'Removed', 'entity_id', 'condition' => '`remove`.`entity` = :entity', 'params' => array(':entity' => get_class($this)))
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

    public function scopes()
    {
        return array(
            'active' => array(
                'condition' => $this->tableAlias . '.removed = 0',
            ),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'author_id' => 'User',
            'album_id' => 'Album',
            'file_name' => 'File Name',
            'title' => 'Название',
            'created' => 'Дата создания',
            'updated' => 'Дата последнего обновления',
        );
    }

    public function afterSave()
    {
        if ($this->isNewRecord){
            $signal = new UserSignal();
            $signal->user_id = (int)$this->author_id;
            $signal->item_id = (int)$this->id;
            $signal->item_name = get_class($this);
            $signal->signal_type = UserSignal::TYPE_NEW_USER_PHOTO;
            $signal->save();

            //добавляем баллы
            Yii::import('site.frontend.modules.scores.models.*');
            UserScores::addScores($this->author_id, ScoreActions::ACTION_PHOTO, 1, $this);
        }
        parent::afterSave();
    }

    public function beforeDelete()
    {
        $this->removed = 1;
        $this->save();
        UserSignal::close($this->id, get_class($this));
        Yii::import('site.frontend.modules.scores.models.*');
        UserScores::removeScores($this->author_id, ScoreActions::ACTION_PHOTO, 1, $this);
        return false;
    }

    /**
     * Save entity and save image in the file system
     * @return bool
     */
    public function create($temp = false)
    {
        if(!$temp)
        {
            $this->file_name = $this->file;
            $this->fs_name = md5($this->file_name) . '.' . $this->file->extensionName;
        }
        else
        {
            $this->fs_name = $this->file_name;
        }
        if ($this->save())
        {
            $this->saveFile(false, $temp);
            return true;
        }
        return false;
    }

    /**
     * Save file in the file system
     * @return bool
     */
    public function saveFile($temp = false, $move_temp = false)
    {
        $dir = Yii::getPathOfAlias('site.common.uploads.photos');
        if(!$temp)
        {
            $model_dir = $dir . DIRECTORY_SEPARATOR . $this->original_folder . DIRECTORY_SEPARATOR . $this->primaryKey;
            if(!file_exists($model_dir))
                mkdir($model_dir);
        }
        else
        {
            $model_dir = $dir . DIRECTORY_SEPARATOR . $this->tmp_folder;
            $this->file_name = $this->file;
            $this->fs_name = md5($this->file_name . time()) . '.' . $this->file->extensionName;
        }
        $file_name = $model_dir . DIRECTORY_SEPARATOR . $this->fs_name;
        if(!$move_temp)
            return $this->file->saveAs($file_name);
        else
            rename($this->templatePath, $file_name);
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
     */
    public function getPreviewPath($width = 100, $height = 100, $master = false)
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
            $image->resize($width, $height, $master ? $master : Image::AUTO);
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
    public function getPreviewUrl($width = 100, $height = 100, $master = false)
    {
        $this->getPreviewPath($width, $height, $master);
        return implode('/', array(
            Yii::app()->params['photos_url'],
            $this->thumb_folder,
            $width . 'x' . $height,
            $this->primaryKey,
            $this->fs_name,
        ));
    }

    public function  getTemplatePath()
    {
        return Yii::getPathOfAlias('site.common.uploads.photos') . DIRECTORY_SEPARATOR . $this->tmp_folder . DIRECTORY_SEPARATOR . $this->fs_name;
    }

    public function getTemplateUrl()
    {
        return Yii::app()->params['photos_url'] . '/' . $this->tmp_folder . '/' . $this->fs_name;
    }

    public function getPageUrl()
    {
        return Yii::app()->createUrl('/albums/photo', array('id'=>$this->id));
    }

    public function getCheckAccess()
    {
        return true;
    }

    public function getDescription()
    {
        return $this->file_name;
    }
}