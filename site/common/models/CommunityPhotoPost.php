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
            'photoAttaches' => array(self::HAS_MANY, 'AttachPhoto', 'entity_id', 'condition' => 'entity = "CommunityContent"'),
        );
    }

    public function beforeSave()
    {
        $this->photos = explode(',', $this->photos);
        $this->photo_id = $this->photos[0];

        return parent::beforeSave();
    }

    /**
     * Привязываем фотки к посту
     */
    public function afterSave()
    {
        if ($this->isNewRecord)
            foreach ($this->photos as $photoId)
                $this->addPhoto($photoId);
        else {
            //удаляем удаленные
            foreach ($this->photoAttaches as $attach)
                if (!in_array($attach->photo_id, $this->photos))
                    $attach->photo->delete();

            ///добавляем новые
            foreach ($this->photos as $photoId) {
                $new = true;
                foreach ($this->photoAttaches as $attach)
                    if ($attach->photo_id == $photoId)
                        $new = false;

                if ($new)
                    $this->addPhoto($photoId);
            }
        }


        parent::afterSave();
    }

    private function addPhoto($photoId)
    {
        $model = new AttachPhoto();
        $model->photo_id = $photoId;
        $model->entity = 'CommunityContent';
        $model->entity_id = $this->content_id;
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
            $data[] = array('id' => $photo->id, 'url' => $photo->getPreviewUrl(162, 125));

        return $data;
    }

    /**
     * Возвращает активные фотки поста
     * @return AlbumPhoto[]
     */
    public function getPhotos()
    {
        $data = array();
        foreach ($this->photoAttaches as $attach)
            if (empty($attach->photo->removed))
                $data[] = $attach->photo;

        return $data;
    }
}