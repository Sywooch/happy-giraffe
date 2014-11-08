<?php

/**
 * This is the model class for table "community__content_gallery_items".
 *
 * The followings are the available columns in table 'community__content_gallery_items':
 * @property string $id
 * @property string $gallery_id
 * @property string $photo_id
 * @property string $description
 *
 * The followings are the available model relations:
 * @property AlbumPhoto $photo
 * @property CommunityContentGallery $gallery
 */
class CommunityContentGalleryItem extends CActiveRecord implements IPreview
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'community__content_gallery_items';
	}

	public function rules()
	{
		return array(
			array('gallery_id, photo_id', 'required'),
			array('gallery_id, photo_id', 'length', 'max'=>10),
			array('description', 'length', 'max'=>1000),
		);
	}

	public function relations()
	{
		return array(
			'photo' => array(self::BELONGS_TO, 'AlbumPhoto', 'photo_id'),
			'gallery' => array(self::BELONGS_TO, 'CommunityContentGallery', 'gallery_id'),
		);
	}

    /**
     * @return mixed|string
     */
    public function getPreviewText()
    {
        $postDescription = $this->gallery->content->getPreviewText();
        return (strlen($postDescription) == 0) ? $this->description : $postDescription;
    }

    public function getPreviewPhoto()
    {
        return $this->photo;
    }

    protected function afterSave()
    {
        $data = array(
            'oldPhotoId' => $this->photo_id,
            'attributes' => array(
                'description' => $this->description,
            ),
        );
        \Yii::app()->gearman->client()->doBackground('updatePhotoPostPhoto', serialize($data));
    }
}