<?php

/**
 * This is the model class for table "community__content_gallery".
 *
 * The followings are the available columns in table 'community__content_gallery':
 * @property string $id
 * @property string $content_id
 * @property string $title
 * @property string $created
 *
 * The followings are the available model relations:
 * @property CommunityContent $content
 * @property CommunityContentGalleryItem[] $items
 */
class CommunityContentGallery extends HActiveRecord
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'community__content_gallery';
	}

	public function rules()
	{
		return array(
			array('content_id, title', 'required'),
			array('content_id', 'length', 'max'=>10),
			array('title', 'length', 'max'=>255),
            array('created', 'safe'),
		);
	}

	public function relations()
	{
		return array(
			'content' => array(self::BELONGS_TO, 'CommunityContents', 'content_id'),
			'items' => array(self::HAS_MANY, 'CommunityContentGalleryItem', 'gallery_id'),
		);
	}

    public function behaviors()
    {
        return array(
            'CTimestampBehavior' => array(
                'class' => 'zii.behaviors.CTimestampBehavior',
                'createAttribute' => 'created',
                'updateAttribute' => null,
            )
        );
    }

    public function getPhotoCollection()
    {
        $photos = array();
        foreach ($this->items as $i => $model)
        {
            $model->photo->w_title = $model->content->title . ' - фото ' . $i + 1;
            $model->photo->w_description = $model->description;
            $photos[] = $model->photo;
        }
        return array(
            'title' => 'Альбом  «' . $this->title . '»',
            'photos' => $photos,
        );
    }
}