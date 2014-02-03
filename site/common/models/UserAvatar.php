<?php

/**
 * This is the model class for table "user__avatars".
 *
 * The followings are the available columns in table 'user__avatars':
 * @property string $avatar_id
 * @property string $source_id
 * @property string $x
 * @property string $y
 * @property string $w
 * @property string $h
 *
 * The followings are the available model relations:
 * @property AlbumPhoto $source
 * @property AlbumPhoto $avatar
 */
class UserAvatar extends CActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return UserAvatar the static model class
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
        return 'user__avatars';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return array(
            array('avatar_id, source_id, x, y, w, h', 'required'),
            array('avatar_id, source_id', 'length', 'max' => 11),
            array('avatar_id, source_id, x, y, w, h', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        return array(
            'source' => array(self::BELONGS_TO, 'AlbumPhoto', 'source_id'),
            'avatar' => array(self::BELONGS_TO, 'AlbumPhoto', 'avatar_id'),
        );
    }

    /**
     * Создание аватарки пользователя
     *
     * @param int $user_id
     * @param int $source_id фото-источник для вырезания
     * @param int $x левый верхний угол аватары
     * @param int $y левый верхний угол аватары
     * @param int $w ширина
     * @param int $h высота
     * @return AlbumPhoto
     */
    public static function createUserAvatar($user_id, $source_id, $x, $y, $w, $h)
    {
        $source = AlbumPhoto::model()->findByPk($source_id);

        $ava = new AlbumPhoto();
        $ava->author_id = $user_id;
        $ava->album_id = Album::getAlbumByType($user_id, Album::TYPE_PRIVATE)->id;
        $ava->file_name = $source->file_name;
        $ava->fs_name = 'ava' . $source->fs_name;
        $ava->hidden = 1;
        $ava->savePhotoFromPhpThumb(self::createAvatarFile($source, $x, $y, $w, $h));

        User::model()->updateByPk(Yii::app()->user->id, array('avatar_id' => $ava->id));
        self::saveCoordinates($source_id, $x, $y, $w, $h, $ava);

        $source->hidden = 0;
        $source->album_id = Album::getAlbumByType($user_id, Album::TYPE_PRIVATE)->id;
        $source->update(array('hidden', 'album_id'));

        $comet = new CometModel();
        $comet->send($user_id, array(
            'userId' => $user_id,
            'src' => array(
                'micro' => $ava->getPreviewUrl(Avatar::SIZE_MICRO, Avatar::SIZE_MICRO, Image::INVERT, true, AlbumPhoto::CROP_SIDE_TOP),
                'medium' => $ava->getPreviewUrl(Avatar::SIZE_MEDIUM, Avatar::SIZE_MEDIUM, Image::INVERT, true, AlbumPhoto::CROP_SIDE_TOP),
                'large' => $ava->getPreviewUrl(Avatar::SIZE_LARGE, Avatar::SIZE_LARGE, Image::INVERT, true, AlbumPhoto::CROP_SIDE_TOP),
            ),
        ), CometModel::AVATAR_UPLOADED);

        return $ava;
    }

    /**
     * Вырезание изображения для аватарки
     * @param $source
     * @param $x
     * @param $y
     * @param $w
     * @param $h
     * @return PhpThumb
     */
    public static function createAvatarFile($source, $x, $y, $w, $h)
    {
        Yii::import('site.frontend.extensions.EPhpThumb.*');
        $image = new EPhpThumb();
        $image->init();
        $image = $image->create($source->getOriginalPath())->crop($x, $y, $w, $h);

        return $image;
    }

    public static function saveCoordinates($source_id, $x, $y, $w, $h, $ava)
    {
        $userAvatar = new UserAvatar();
        $userAvatar->avatar_id = $ava->id;
        $userAvatar->source_id = $source_id;
        $userAvatar->x = $x;
        $userAvatar->y = $y;
        $userAvatar->w = $w;
        $userAvatar->h = $h;
        $userAvatar->save();
    }
}