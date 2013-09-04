<?php

/**
 * This is the model class for table "community__photo_posts".
 *
 * The followings are the available columns in table 'community__photo_posts':
 * @property string $content_id
 * @property string $text
 * @property string $photo_id
 *
 * The followings are the available model relations:
 * @property AlbumPhoto $photo
 * @property CommunityContent $content
 * @property AttachPhoto[] $photoAttaches
 */
class CommunityPhotoPost extends HActiveRecord
{
    public $photos;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return CommunityPhotoPost the static model class
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
        return 'community__photo_posts';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return array(
            array('content_id', 'required', 'on' => 'edit'),
            array('content_id, photo_id', 'length', 'max' => 11),
            array('text, photos', 'safe'),
            array('content_id, text, photo_id', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        return array(
            'photo' => array(self::BELONGS_TO, 'AlbumPhoto', 'photo_id'),
            'content' => array(self::BELONGS_TO, 'CommunityContent', 'content_id'),
        );
    }

    public function behaviors()
    {
        return array(
            'previewSave' => array(
                'class' => 'site.common.behaviors.PreviewBehavior',
                'small_preview' => true,
            ),
        );
    }

    public function beforeValidate()
    {
        $this->photos = explode(',', $this->photos);
        if (count($this->photos) < 3)
            $this->addError('photos', 'Добавьте хотя бы 3 фото');

        return parent::beforeValidate();
    }

    public function beforeSave()
    {
        $this->photo_id = $this->photos[0];
        $this->text = strip_tags($this->text);

        return parent::beforeSave();
    }

    /**
     * Привязываем фотки к посту
     */
    public function afterSave()
    {
        if ($this->isNewRecord) {
            $gallery = new CommunityContentGallery();
            $gallery->content_id = $this->content_id;
            $gallery->title = $this->content->title;
            $gallery->save();
            foreach ($this->photos as $photoId)
                $this->addPhoto($photoId);
        } else {
            //удаляем удаленные
            foreach ($this->content->gallery->items as $gallery_item)
                if (!in_array($gallery_item->photo_id, $this->photos))
                    $gallery_item->delete();

            ///добавляем новые
            foreach ($this->photos as $photoId) {
                $new = true;
                foreach ($this->content->gallery->items as $gallery_item)
                    if ($gallery_item->photo_id == $photoId)
                        $new = false;

                if ($new)
                    $this->addPhoto($photoId);
            }
        }

        parent::afterSave();
    }

    private function addPhoto($photoId)
    {
        $model = new CommunityContentGalleryItem();
        $model->gallery_id = $this->content->gallery->id;
        $model->photo_id = $photoId;
        $model->save();
    }


    /**
     * @return AlbumPhoto
     */
    public function getPhoto()
    {
        return $this->photo;
    }

    /**
     * Возвращает данные о фотках для js
     */
    public function getPhotoPostData()
    {
        $data = array();
        foreach ($this->getPhotos() as $photo)
            $data[] = array('id' => $photo->id, 'url' => $photo->getPreviewUrl(480, 250));

        return $data;
    }

    /**
     * Возвращает активные фотки поста
     * @return AlbumPhoto[]
     */
    public function getPhotos()
    {
        $data = array();
        foreach ($this->content->gallery->items as $gallery_item)
            $data[] = $gallery_item->photo;

        return $data;
    }
}