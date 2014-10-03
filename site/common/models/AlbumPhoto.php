<?php

/**
 * This is the model class for table "album_photos".
 *
 * The followings are the available columns in table 'album_photos':
 * @property int $id
 * @property int $author_id
 * @property int $album_id
 * @property string $file_name
 * @property string $fs_name
 * @property string $title
 * @property int $width
 * @property int $height
 * @property int $hidden
 * @property string $created
 * @property string $updated
 * @property int $type_id Для совместимости с CommunityContent. Возвращает CommunityContent::TYPE_PHOTO
 *
 * The followings are the available model relations:
 * @property Album $album
 * @property User $author
 * @property UserAvatar $userAvatar
 *
 * @method AlbumPhoto findByPk()
 */
class AlbumPhoto extends HActiveRecord
{
    const CROP_SIDE_CENTER = 'center';
    const CROP_SIDE_TOP = 'top';
    const CROP_SIDE_BOTTOM = 'bottom';

    const PHOTO_VIEW_SMALL = 0;
    const PHOTO_VIEW_MEDIUM = 1;
    const PHOTO_VIEW_LARGE = 2;

    public static  $photoViewDimensions = array(
        self::PHOTO_VIEW_SMALL => array(
            'width' => 724,
            'height' => 623,
            'minScreenWidth' => null,
            'maxScreenWidth' => 1024,
        ),
        self::PHOTO_VIEW_MEDIUM => array(
            'width' => 1140,
            'height' => 935,
            'minScreenWidth' => 1025,
            'maxScreenWidth' => 1440,
        ),
        self::PHOTO_VIEW_LARGE => array(
            'width' => 1620,
            'height' => 1295,
            'minScreenWidth' => 1441,
            'maxScreenWidth' => null,
        ),
    );

    public $options = array();

    public $w_title = null;
    public $w_description = null;
    public $w_idx = null;

    public $count;

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
     * @var string blogs image folder
     */
    private $blogs_folder = 'blogs';
    /**
     * @var string blogs image folder
     */
    private $mail_folder = 'mail';
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
            array('title', 'length', 'max' => 250),
            array('created, updated', 'safe'),
            array('album_id', 'unsafe', 'on' => 'update'),
            array('width', 'numerical', 'integerOnly'=>true, 'min' => 200, 'on' => 'avatarUpload', 'tooSmall' => 'Минимальная ширина аватары составляет 200 пикселей.'),
            array('height', 'numerical', 'integerOnly'=>true, 'min' => 200, 'on' => 'avatarUpload', 'tooSmall' => 'Минимальная высота аватары составляет 200 пикселей.'),
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
            'attach' => array(self::HAS_ONE, 'AttachPhoto', 'photo_id'),
            'userAvatar' => array(self::HAS_ONE, 'UserAvatar', 'avatar_id'),
            'galleryItem' => array(self::HAS_ONE, 'CommunityContentGalleryItem', 'photo_id'),
            'cookRecipe' => array(self::HAS_ONE, 'CookRecipe', 'photo_id'),
            'remove' => array(self::HAS_ONE, 'Removed', 'entity_id', 'condition' => '`remove`.`entity` = :entity', 'params' => array(':entity' => get_class($this))),
            'commentsCount' => array(self::STAT, 'Comment', 'entity_id', 'condition' => 'entity=:modelName', 'params' => array(':modelName' => get_class($this))),
        );
    }

    /**
     * @return array
     */
    public function behaviors()
    {
        return array(
            'ContentBehavior' => array(
                'class' => 'site\frontend\modules\notifications\behaviors\ContentBehavior',
            ),
            'CTimestampBehavior' => array(
                'class' => 'zii.behaviors.CTimestampBehavior',
                'createAttribute' => 'created',
                'updateAttribute' => 'updated',
            ),
            'antispam' => array(
                'class' => 'site.frontend.modules.antispam.behaviors.AntispamBehavior',
                'interval' => 60 * 60,
                'maxCount' => 50,
            ),
            'softDelete' => array(
                'class' => 'site.common.behaviors.SoftDeleteBehavior',
            ),
            //'pingable' => array(
            //    'class' => 'site.common.behaviors.PingableBehavior',
            //),
        );
    }

    public function scopes()
    {
        return array(
            'active' => array(
                'condition' => $this->tableAlias . '.removed = 0 AND ' . $this->tableAlias . '.hidden = 0',
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

    public function beforeValidate()
    {
        if (empty($this->album_id))
            $this->album_id = Album::getAlbumByType($this->author_id, Album::TYPE_PRIVATE)->id;
        $this->setDimensions();

        return parent::beforeSave();
    }

    public function afterSave()
    {
        if ($this->isNewRecord) {
            if ($this->album !== null && ($this->album->type == 0 || $this->album->type == 1)) {
                UserAction::model()->add($this->author_id, UserAction::USER_ACTION_PHOTOS_ADDED, array('model' => $this), array('album_id' => $this->album_id));
                FriendEventManager::add(FriendEvent::TYPE_PHOTOS_ADDED, array('album_id' => $this->album->id, 'user_id' => $this->author_id));
                Scoring::photoCreated($this);
            }

            $this->generatePhotoViewPhotos();
        }

        parent::afterSave();
    }

    public function beforeDelete()
    {
        $this->removed = 1;
        $this->save(false);

        if (!empty($this->album_id) && in_array($this->album->type, array(0, 1, 3)))
            Scoring::photoRemoved($this);

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
        } else {
            $this->fs_name = $this->file_name;
        }
        if ($this->save(false)) {
            $this->saveFile(false, $temp);
            $this->setDimensions();
            return true;
        }
        return false;
    }

    public static function createByUrl($url, $user_id, $album_type = false, $title = null)
    {
        //upload file content
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_AUTOREFERER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);

        $file = curl_exec($ch);
        $httpStatus = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpStatus !== 200) {
            return false;
        }

        if (empty($file)) {
            return false;
        }

        //define file extension if it is not set
        $dir = Yii::getPathOfAlias('site.common.uploads.photos.temp');
        $file_name = md5($url . time());
        file_put_contents($dir . DIRECTORY_SEPARATOR . $file_name, $file);

        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mimetype = finfo_file($finfo, $dir . DIRECTORY_SEPARATOR . $file_name);
        finfo_close($finfo);

        if ($mimetype == 'image/jpeg')
            $ext = 'jpeg';
        elseif ($mimetype == 'image/gif')
            $ext = 'gif'; elseif ($mimetype == 'image/png')
            $ext = 'png'; elseif ($mimetype == 'image/tiff')
            $ext = 'tiff'; else
            return false;

        $model = new AlbumPhoto();
        $model->author_id = $user_id;

        //prepare directory
        $dir = Yii::getPathOfAlias('site.common.uploads.photos');
        $model_dir = $dir . DIRECTORY_SEPARATOR . $model->original_folder . DIRECTORY_SEPARATOR . $model->author_id;
        if (!file_exists($model_dir))
            mkdir($model_dir);

        //save file
        $file_name = md5(time());
        while (file_exists($model_dir . DIRECTORY_SEPARATOR . $file_name . '.' . $ext))
            $file_name = md5($file_name . time());
        file_put_contents($model_dir . DIRECTORY_SEPARATOR . $file_name . '.' . $ext, $file);

        if (!in_array($ext, array('jpg', 'jpeg', 'png', 'gif', 'JPG', 'JPEG', 'PNG', 'GIF')))
            return false;

        if ($album_type !== false)
            $model->album_id = Album::getAlbumByType($user_id, $album_type)->id;
        $model->fs_name = $file_name . '.' . $ext;
        $model->file_name = $file_name . '.' . $ext;
        $model->title = $title;
        $model->save(false);

        return $model;
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
        } else {
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
     * Создаем фото из объекта PhpThumb
     *
     * @param PhpThumb $image
     * @return bool
     */
    public function savePhotoFromPhpThumb($image)
    {
        $dir = Yii::getPathOfAlias('site.common.uploads.photos');
        $model_dir = $dir . DIRECTORY_SEPARATOR . $this->original_folder . DIRECTORY_SEPARATOR . $this->author_id;
        if (!file_exists($model_dir))
            mkdir($model_dir);

        $fs_name = $this->fs_name;
        $file_name = $model_dir . DIRECTORY_SEPARATOR . $this->fs_name;
        while (file_exists($file_name)) {
            $fs_name = substr(md5(time()), 0, 5) . $this->fs_name;
            $file_name = $model_dir . DIRECTORY_SEPARATOR . $fs_name;
        }

        $image->save($file_name);
        $this->fs_name = $fs_name;

        return $this->save();
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
            $this->getHost(),
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
     * @param bool $master
     * @param bool $crop
     * @param string $crop_side
     * @param bool $force_replace
     *
     * @return string
     */
    public function getPreviewPath($width = 100, $height = 100, $master = false, $crop = false, $crop_side = self::CROP_SIDE_CENTER, $force_replace = false)
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
        if (!file_exists($thumb) || $force_replace) {
            if (!file_exists($thumb_path)) {
                mkdir($thumb_path);
                $handle = fopen($thumb_path . DIRECTORY_SEPARATOR . 'index.html', 'x+');
                fclose($handle);
            }
            if (!file_exists($model_dir))
                mkdir($model_dir);

            if (!file_exists($this->originalPath)) {
                //$this->delete();
                return false;
            }

            #TODO imagick Применяется для анимированных gif, но поскольку он сейчас долго работает пришлось отключить
//            if (exif_imagetype($this->originalPath) == IMAGETYPE_GIF)
//                return $this->imagickResize($thumb, $width, $height, $master, $crop, $crop_side);
//            else
            $thumb = $this->gdResize($thumb, $width, $height, $master, $crop);
        }

        if ($thumb !== false && $size = @getimagesize($thumb)) {
            $this->width = $size[0];
            $this->height = $size[1];
        }

        return $thumb;
    }

    private function gdResize($thumb, $width, $height, $master, $crop)
    {
        Yii::import('site.frontend.extensions.EPhpThumb.*');

        try {
            $image = Yii::app()->phpThumb->create($this->originalPath);

        } catch (CException $e) {
            #TODO сделать более грамотный механизм обработки плохих фоток
            if (strpos($e->getMessage(), 'File is not a valid image') !== false
                || strpos($e->getMessage(), 'Image format not supported') !== false
            ) {
                //удаляем фотку
                $this->delete();
            }
            return false;
        }

        if (! isset(Yii::app()->params['magic']) && ($image->width <= $width && $image->height <= $height
            || $master == Image::WIDTH && $image->height <= $height
            || $master == Image::HEIGHT && $image->height <= $height
            )) {
            //just copy file
            copy($this->originalPath, $thumb);
        } else {

            if ($crop) {
                $image = $image->cropFromTop($width, $height, 'T');
            } elseif (empty($height))
                $image = $image->resize($width, 1500); elseif (empty($width))
                $image = $image->resize(1500, $height); else
                $image = $image->resize($width, $height);

            $image = $image->save($thumb);

            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mimetype = finfo_file($finfo, $thumb);
            finfo_close($finfo);

            if ($mimetype == 'image/jpeg')
                shell_exec('jpegoptim --strip-all ' . $thumb);
            elseif ($mimetype == 'image/png')
                shell_exec('optipng -o2 ' . $thumb);

        }

        return $thumb;
    }

    private function imagickResize($thumb, $width, $height, $master, $crop, $crop_side)
    {
        Yii::import('site.frontend.extensions.image.Image');
        if (!file_exists($this->originalPath))
            return false;
        try {
            $image = new Image($this->originalPath);
        } catch (CException $e) {
            return $thumb;
        }

        if ($image->width <= $width && $image->height <= $height) {

        } elseif ($master && $master == Image::WIDTH && $image->width < $width)
            $image->resize($image->width, $height, Image::WIDTH); elseif ($master && $master == Image::HEIGHT && $image->height < $height)
            $image->resize($width, $image->height, Image::HEIGHT); elseif ($master && $master == Image::INVERT) {
            $image->resize($width, $height, ($image->width > $image->height) ? Image::HEIGHT : Image::WIDTH);
        } else
            $image->resize($width, $height, $master ? $master : Image::AUTO);

        if ($crop)
            $image->crop($width, $height, $crop_side);

        $image->save($thumb);

        return $thumb;
    }

    /**
     * Get preview image url
     *
     * @param int $width
     * @param int $height
     * @param bool $master
     * @param bool $crop
     * @param string $crop_side
     *
     * @return string
     */
    public function getPreviewUrl($width = 100, $height = 100, $master = false, $crop = false, $crop_side = self::CROP_SIDE_CENTER)
    {
        $this->getPreviewPath($width, $height, $master, $crop, $crop_side);
        return implode('/', array(
            $this->getHost(),
            $this->thumb_folder,
            $width . 'x' . $height,
            $this->author_id,
            $this->fs_name,
        ));
    }

    public function getPreviewHtml($width = 100, $height = 100, $master = false, $crop = false, $crop_side = self::CROP_SIDE_CENTER)
    {
        $url = $this->getPreviewUrl($width, $height, $master, $crop, $crop_side);
        $path = $this->getPreviewPath($width, $height, $master, $crop, $crop_side);
        $size = @getimagesize($path);
        return CHtml::image($url, '', array('width' => $size[0], 'height' => $size[1]));
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
     * Возвращает url аватарки
     * @param $size string размер аватарки
     * @return string
     */
    public function getAvatarUrl($size)
    {
        return implode('/', array(
            $this->getHost(),
            $this->avatars_folder,
            $this->author_id,
            $size,
            $this->fs_name
        ));
    }

    public function getBlogPath()
    {
        $dir = Yii::getPathOfAlias('site.common.uploads.photos');

        if (!file_exists($dir . DIRECTORY_SEPARATOR . $this->blogs_folder . DIRECTORY_SEPARATOR . $this->author_id))
            mkdir($dir . DIRECTORY_SEPARATOR . $this->blogs_folder . DIRECTORY_SEPARATOR . $this->author_id);

        return $dir . DIRECTORY_SEPARATOR . $this->blogs_folder . DIRECTORY_SEPARATOR . $this->author_id .
        DIRECTORY_SEPARATOR . $this->fs_name;
    }

    public function getBlogUrl()
    {
        return implode('/', array(
            $this->getHost(),
            $this->blogs_folder,
            $this->author_id,
            $this->fs_name
        ));
    }

    public function getMailPath()
    {
        $dir = Yii::getPathOfAlias('site.common.uploads.photos');

        if (!file_exists($dir . DIRECTORY_SEPARATOR . $this->mail_folder . DIRECTORY_SEPARATOR . $this->author_id))
            mkdir($dir . DIRECTORY_SEPARATOR . $this->mail_folder . DIRECTORY_SEPARATOR . $this->author_id);

        return $dir . DIRECTORY_SEPARATOR . $this->mail_folder . DIRECTORY_SEPARATOR . $this->author_id .
        DIRECTORY_SEPARATOR . $this->fs_name;
    }

    public function getMailUrl()
    {
        return implode('/', array(
            $this->getHost(),
            $this->mail_folder,
            $this->author_id,
            $this->fs_name
        ));
    }

    public function getUrlParams()
    {
        if (!empty($this->galleryItem) && isset($this->galleryItem->gallery->content)) {
            if ($this->galleryItem->gallery->content->getIsFromBlog())
                return array('albums/singlePhoto', array(
                    'photo_id' => $this->id,
                    'user_id' => $this->galleryItem->gallery->content->author_id,
                    'content_id' => $this->galleryItem->gallery->content_id,
                ));
            else
                return array('albums/singlePhoto', array(
                    'photo_id' => $this->id,
                    'community_id' => $this->galleryItem->gallery->content->rubric->community_id,
                    'content_id' => $this->galleryItem->gallery->content_id,
                ));
        } elseif (empty($this->album_id) && !empty($this->attach)) {
            switch ($this->attach->entity) {
                case 'ContestWork':
                    $work = ContestWork::model()->findByPk($this->attach->entity_id);
                    $params = array(
                        'entity' => 'Contest',
                        'contest_id' => $work->contest_id
                    );
                    break;
                //case '':
            }
            $params['photo_id'] = $this->id;
            return array('albums/singlePhoto', $params);
        } else
            return array(
                'albums/photo',
                array(
                    'user_id' => $this->author_id,
                    'album_id' => $this->album_id,
                    'id' => $this->id
                ),
            );
    }

    public function getUrl($comments = false, $absolute = false)
    {
        list($route, $params) = $this->urlParams;

        if ($comments)
            $params['#'] = 'comment_list';

        $method = $absolute ? 'createAbsoluteUrl' : 'createUrl';
        return Yii::app()->$method($route, $params);
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

    public function getAttachByEntity($entity)
    {
        return AttachPhoto::model()->findByAttributes(array('entity' => $entity, 'photo_id' => $this->id), array('order' => 't.id DESC'));
    }

    public function getRssContent()
    {
        return CHtml::image($this->getPreviewUrl(460, 600), $this->title);
    }

    public function getPhoto()
    {
        return $this;
    }

    public function getContentTitle()
    {
        return $this->title;
    }

    /**
     * Возвращает подсказку для вывода
     */
    public function getPowerTipTitle($full = false)
    {
        if (empty($this->album)) {
            if (!empty($this->galleryItem)) {
                $post = $this->galleryItem->gallery->content;
                if (!$post)
                    return '';
                $t = htmlentities("Фотогалерея к записи <span class='color-gray'>" . $post->title . "</span>", ENT_QUOTES, "UTF-8");
                if (!$full)
                    return $t;
                return htmlentities(("Клуб <span class='color-category " . $post->rubric->community->css_class . "'>" . $post->rubric->community->title . "</span><br>"), ENT_QUOTES, "UTF-8") . $t;
            }
            return '';
        }

        $title = htmlentities("Фотоальбом <span class='color-gray' >" . $this->album->title . "</span>", ENT_QUOTES, "UTF-8");
        if (!$full)
            return $title;
        if (!empty($this->title))
            return $title . htmlentities('<br>' . 'Фотография <span class=\'color-gray\' > ' . $this->title . '</span>', ENT_QUOTES, "UTF-8");
        return $title;
    }

    /**
     * @param bool $edit в редактировании
     * @param null $parentModel
     * @return string
     */
    public function getWidget($edit = false, $parentModel = null)
    {
        if (get_class(Yii::app()) == 'CConsoleApplication')
            return Yii::app()->command->renderFile(Yii::getPathOfAlias('site.frontend.views.albums') . DIRECTORY_SEPARATOR . '_widget.php', array(
                'model' => $this,
                'edit' => $edit,
                'parentModel' => $parentModel
            ), true);

        return Yii::app()->controller->renderPartial('//albums/_widget', array(
            'model' => $this,
            'edit' => $edit,
            'parentModel' => $parentModel
        ), true);
    }

    protected function setDimensions()
    {
        $size = @getimagesize($this->getOriginalPath());
        $this->width = $size[0];
        $this->height = $size[1];
    }

    /**
     * Создает временную модель с загруженным пользователем файлом
     *
     * @param $file
     * @param $hidden скрыто ли фото
     * Информация о загруженном файле
     * ["name"]=> название исходного файла
     * ["type"]=> "image/png" "image/jpeg"
     * ["tmp_name"]=> временный адрес файла
     * ["error"]=> int(0)
     * ["size"]=>
     * @return AlbumPhoto
     */
    public function createUserTempPhoto($file, $hidden = 1, $scenario = null)
    {
        if (is_array($file['type']))
            $file['type'] = $file['type'][0];
        if ($file['type'] != 'image/png' && $file['type'] != 'image/jpeg')
            return null;

        if (is_array($file['name']))
            $file['name'] = $file['name'][0];
        if (is_array($file['tmp_name']))
            $file['tmp_name'] = $file['tmp_name'][0];

        $model = new AlbumPhoto();
        if ($scenario !== null)
            $model->setScenario($scenario);
        $model->author_id = Yii::app()->user->id;
        $model->fs_name = $this->copyUserFile($file['name'], $file['tmp_name'], $model->author_id);
        $model->file_name = $file['name'];
        $model->hidden = $hidden;
        $model->save();

        return $model;
    }

    /**
     * Копирует загруженный пользователем файл в директорию пользователя для загруженных файлов
     * Возвращает название созданного файла
     *
     * @param $name
     * @param $temp_name
     * @param $user_id
     * @return string
     */
    private function copyUserFile($name, $temp_name, $user_id)
    {
        $ext = pathinfo($name, PATHINFO_EXTENSION);
        list($this->width, $this->height) = @getimagesize($temp_name);
        $dir = Yii::getPathOfAlias('site.common.uploads.photos');
        $model_dir = $dir . DIRECTORY_SEPARATOR . $this->original_folder . DIRECTORY_SEPARATOR . $user_id;
        if (!file_exists($model_dir))
            mkdir($model_dir);

        $file_name = md5(time());
        while (file_exists($model_dir . DIRECTORY_SEPARATOR . $file_name . '.' . $ext))
            $file_name = md5($file_name . microtime());
        copy($temp_name, $model_dir . DIRECTORY_SEPARATOR . $file_name . '.' . $ext);

        return $file_name . '.' . $ext;
    }

    /**
     * @param string $url
     * @return AlbumPhoto|null
     */
    public static function getPhotoFromUrl($url)
    {
        if (preg_match('/' . preg_quote(Yii::app()->params['photos_url'], '/') . '\/thumbs\/[\d]+x[\d]+\/([\d]+)\/([^\"]+)/', $url, $m)) {
            $user_id = $m[1];
            $photo_name = $m[2];
            return AlbumPhoto::model()->findByAttributes(array('author_id' => $user_id, 'fs_name' => $photo_name));
        }

        return null;
    }

    protected function getHost()
    {
        return Yii::app()->params['photos_url'];
//
//        $hosts = array(
//            'http://img1.happy-giraffe.ru',
//            'http://img2.happy-giraffe.ru',
//            'http://img3.happy-giraffe.ru',
//            'http://img4.happy-giraffe.ru',
//            'http://img5.happy-giraffe.ru',
//            'http://img6.happy-giraffe.ru',
//            'http://img7.happy-giraffe.ru',
//        );
//
//        return $hosts[array_rand($hosts)];
    }

    public function getCommentsCount()
    {
        return $this->commentsCount;
    }

    public function generatePhotoViewPhotos()
    {
        foreach (self::$photoViewDimensions as $dimensions)
            $this->getPreviewPath($dimensions['width'], $dimensions['height'], Image::AUTO);
    }

    public function getPhotoViewUrl()
    {
        $dimension = Yii::app()->user->getState('dimension', self::PHOTO_VIEW_MEDIUM);
        return $this->getPreviewUrl(self::$photoViewDimensions[$dimension]['width'], self::$photoViewDimensions[$dimension]['height'], Image::AUTO);
    }

    public function __clone()
    {
        $this->id = null;
        $this->setIsNewRecord(true);
        $ext = substr($this->fs_name, strpos($this->fs_name, ".") + 1);
        $source = $this->getOriginalPath();
        $this->fs_name = md5($this->file_name . time()) . '.' . $ext;
        $dest = $this->getOriginalPath();
        copy($source, $dest);
        $this->save();
    }
    
    public function getType_id()
    {
        return CommunityContent::TYPE_PHOTO;
    }
}