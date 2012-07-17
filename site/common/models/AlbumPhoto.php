<?php

/**
 * This is the model class for table "album_photos".
 *
 * The followings are the available columns in table 'album_photos':
 * @property integer $id
 * @property string $author_id
 * @property integer $album_id
 * @property string $file_name
 * @property string $fs_name
 * @property string $title
 * @property string $previewUrl
 * @property string $originalUrl
 * @property string $created
 * @property string $updated
 *
 * The followings are the available model relations:
 * @property Album $album
 * @property User $author
 *
 * @method AlbumPhoto findByPk()
 */
class AlbumPhoto extends HActiveRecord
{
    const CROP_SIDE_CENTER = 'center';
    const CROP_SIDE_TOP = 'top';
    const CROP_SIDE_BOTTOM = 'bottom';

    public $options = array();

    public $w_title = null;
    public $w_description = null;

    public $width;
    public $height;

    /**
     * @var string original photos folder
     */
    public $original_folder = 'originals';
    /**
     * @var string thumbnail image folder
     */
    private $thumb_folder = 'thumbs';
    /**
     * @var string template image folder
     */
    private $tmp_folder = 'temp';
    /**
     * @var string avatars image folder
     */
    private $avatars_folder = 'avatars';
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
        return 'album__photos';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('author_id, file_name', 'required'),
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
        if ($this->isNewRecord && Yii::app()->hasComponent('comet') && $this->author->isNewComer() && isset($this->album)) {
            if ($this->album->type == 0 || $this->album->type == 1 || $this->album->type == 3) {
                $signal = new UserSignal();
                $signal->user_id = (int)$this->author_id;
                $signal->item_id = (int)$this->id;
                $signal->item_name = get_class($this);
                $signal->signal_type = UserSignal::TYPE_NEW_USER_PHOTO;
                $signal->save();

                if (!empty($this->album_id)) {
                    UserScores::addScores($this->author_id, ScoreActions::ACTION_PHOTO, 1, $this);
                }
            }
        }
        parent::afterSave();
    }

    public function beforeDelete()
    {
        $this->removed = 1;
        $this->save(false);
        UserSignal::closeRemoved($this);
        if (!empty($this->album_id)) {
            UserScores::removeScores($this->author_id, ScoreActions::ACTION_PHOTO, 1, $this);
        }
        return false;
    }

    /**
     * Save entity and save image in the file system
     * @return bool
     */
    public function create($temp = false)
    {
        if (!$temp) {
            $this->file_name = $this->file;
            $this->fs_name = md5($this->file_name . time()) . '.' . $this->file->extensionName;
        }
        else {
            $this->fs_name = $this->file_name;
        }
        if ($this->save(false)) {
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
        if (!$temp) {
            $model_dir = $dir . DIRECTORY_SEPARATOR . $this->original_folder . DIRECTORY_SEPARATOR . $this->author_id;
            if (!file_exists($model_dir))
                mkdir($model_dir);
        }
        else {
            $model_dir = $dir . DIRECTORY_SEPARATOR . $this->tmp_folder;
            $this->file_name = $this->file;
            $this->fs_name = md5($this->file_name . time()) . '.' . $this->file->extensionName;
        }
        $file_name = $model_dir . DIRECTORY_SEPARATOR . $this->fs_name;
        if (!$move_temp)
            return $this->file->saveAs($file_name);
        else {
            //echo $this->templatePath;Yii::app()->end();
            rename($this->templatePath, $file_name);
        }
    }

    /**
     * Get path to the original image
     * @return string
     */
    public function getOriginalPath()
    {
        $dir = Yii::getPathOfAlias('site.common.uploads.photos');
        return $dir . DIRECTORY_SEPARATOR . $this->original_folder . DIRECTORY_SEPARATOR . $this->author_id .
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
            $this->author_id,
            $this->fs_name,
        ));
    }

    /**
     * Get path to the preview image
     *
     * @param int $width
     * @param int $height
     * @param bool/string $master
     * @param bool $crop
     *
     * @return string
     */
    public function getPreviewPath($width = 100, $height = 100, $master = false, $crop = false, $crop_side = self::CROP_SIDE_CENTER)
    {
        // Uload root
        $dir = Yii::getPathOfAlias('site.common.uploads.photos');
        // Thumb relative path
        $thumb_dir = $this->thumb_folder . DIRECTORY_SEPARATOR . $width . 'x' . $height;
        // Thumb file system path
        $thumb_path = $dir . DIRECTORY_SEPARATOR . $thumb_dir;
        // Entity file system path
        $model_dir = $thumb_path . DIRECTORY_SEPARATOR . $this->author_id;
        // Image file system path
        $thumb = $model_dir . DIRECTORY_SEPARATOR . $this->fs_name;
        if (!file_exists($thumb)) {
            if (!file_exists($thumb_path)) {
                mkdir($thumb_path);
                $handle = fopen($thumb_path . DIRECTORY_SEPARATOR . 'index.html', 'x+');
                fclose($handle);
            }
            if (!file_exists($model_dir))
                mkdir($model_dir);
            Yii::import('site.frontend.extensions.image.Image');
            if (!file_exists($this->originalPath))
                return false;
            $image = new Image($this->originalPath);

            if ($image->width <= $width && $image->height <= $height) {

            }
            elseif ($master && $master == Image::WIDTH && $image->width < $width)
                $image->resize($image->width, $height, Image::WIDTH);
            elseif ($master && $master == Image::HEIGHT && $image->height < $height)
                $image->resize($width, $image->height, Image::HEIGHT);
            else
                $image->resize($width, $height, $master ? $master : Image::AUTO);

            if ($crop)
                $image->crop($width, $height, $crop_side);

            $this->width = $image->width;
            $this->height = $image->height;
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
    public function getPreviewUrl($width = 100, $height = 100, $master = false, $crop = false, $crop_side = self::CROP_SIDE_CENTER)
    {
        $this->getPreviewPath($width, $height, $master, $crop, $crop_side);
        return implode('/', array(
            Yii::app()->params['photos_url'],
            $this->thumb_folder,
            $width . 'x' . $height,
            $this->author_id,
            $this->fs_name,
        ));
    }

    public function  getTemplatePath()
    {
        return Yii::getPathOfAlias('site.common.uploads.photos') . DIRECTORY_SEPARATOR . $this->tmp_folder . DIRECTORY_SEPARATOR . $this->fs_name;
    }

    public function getTempPath()
    {
        return Yii::getPathOfAlias('site.common.uploads.photos') . DIRECTORY_SEPARATOR . $this->tmp_folder . DIRECTORY_SEPARATOR;
    }


    public function getTemplateUrl()
    {
        return Yii::app()->params['photos_url'] . '/' . $this->tmp_folder . '/' . $this->fs_name;
    }

    public function getTempUrl()
    {
        return Yii::app()->params['photos_url'] . '/' . $this->tmp_folder . '/';
    }

    public function getAvatarPath($size)
    {
        $dir = Yii::getPathOfAlias('site.common.uploads.photos');
        if (!file_exists($dir . DIRECTORY_SEPARATOR . $this->avatars_folder . DIRECTORY_SEPARATOR . $this->author_id))
            mkdir($dir . DIRECTORY_SEPARATOR . $this->avatars_folder . DIRECTORY_SEPARATOR . $this->author_id);

        if (!file_exists($dir . DIRECTORY_SEPARATOR . $this->avatars_folder . DIRECTORY_SEPARATOR . $this->author_id . DIRECTORY_SEPARATOR . $size))
            mkdir($dir . DIRECTORY_SEPARATOR . $this->avatars_folder . DIRECTORY_SEPARATOR . $this->author_id . DIRECTORY_SEPARATOR . $size);

        return $dir . DIRECTORY_SEPARATOR . $this->avatars_folder . DIRECTORY_SEPARATOR . $this->author_id .
            DIRECTORY_SEPARATOR . $size . DIRECTORY_SEPARATOR . $this->fs_name;
    }

    /**
     * Get url to the original image
     * @return string
     */
    public function getAvatarUrl($size)
    {
        return implode('/', array(
            Yii::app()->params['photos_url'],
            $this->avatars_folder,
            $this->author_id,
            $size,
            $this->fs_name
        ));
    }

    public function getUrl()
    {
        return Yii::app()->createUrl('albums/photo', array('user_id' => $this->author_id, 'album_id' => $this->album_id, 'id' => $this->id));
    }

    public function getCheckAccess()
    {
        return true;
    }

    public function getDescription()
    {
        return $this->file_name;
    }

    public function getNeighboringPhotos()
    {
        $prev = Yii::app()->db->createCommand('select id from ' . $this->tableName() . ' where removed = 0 and album_id = ' . $this->album_id . ' and id < ' . $this->id . ' order by id desc limit 1')->queryRow();
        $next = Yii::app()->db->createCommand('select id from ' . $this->tableName() . ' where removed = 0 and album_id = ' . $this->album_id . ' and id > ' . $this->id . ' order by id asc limit 1')->queryRow();
        return array(
            'prev' => $prev ? $prev['id'] : false,
            'next' => $next ? $next['id'] : false
        );
    }

    public function getCommentContent($full_size)
    {
        if ($full_size)
            return CHtml::image($this->getOriginalUrl(460, 600), $this->title);
        else
            return CHtml::image($this->getPreviewUrl(460, 600), $this->title);
    }
}