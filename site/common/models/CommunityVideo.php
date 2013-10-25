<?php

/**
 * This is the model class for table "{{community_video}}".
 *
 * The followings are the available columns in table '{{community_video}}':
 * @property string $id
 * @property string $link
 * @property string $text
 * @property string $content_id
 * @property string $photo_id
 * @property string $embed
 *
 * @property AlbumPhoto $photo
 * @property CommunityContent $content
 */
class CommunityVideo extends HActiveRecord
{

	/**
	 * Returns the static model of the specified AR class.
	 * @return CommunityVideo the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function behaviors()
	{
		return array(
            'previewSave' => array(
                'class' => 'site.common.behaviors.PreviewBehavior',
                'small_preview' => true,
            ),
            'purified' => array(
                'class' => 'site.common.behaviors.PurifiedBehavior',
                'attributes' => array('text'),
                'options' => array(
                    'AutoFormat.Linkify' => true,
                ),
                'show_video' => false,
            ),
		);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'community__videos';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('link, text', 'required'),
			array('link', 'length', 'max' => 255),
            array('link', 'url'),
            array('link', 'videoUrl'),
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
			'content' => array(self::BELONGS_TO, 'CommunityContent', 'content_id'),
			'photo' => array(self::BELONGS_TO, 'AlbumPhoto', 'photo_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
        return array(
            'id' => 'ID',
            'link' => 'Ссылка',
            'text' => 'Текст',
            'content_id' => 'Content',
            'photo_id' => 'Photo',
            'embed' => 'Embed',
        );
	}

    /**
     * @return AlbumPhoto
     */
    public function getPhoto(){
        return $this->photo;
    }

    protected function beforeSave()
    {
        try {
            $video = Video::factory($this->link);
            $this->embed = $video->embed;
            if (isset($this->content)){
                $photo = AlbumPhoto::createByUrl($video->thumbnail, $this->isNewRecord ? Yii::app()->user->id : $this->content->author_id, Album::TYPE_PREVIEW);
                $this->photo_id = $photo->id;
            }
            return parent::beforeValidate();
        }
        catch (CException $e) {
            return false;
        }
    }

    public function videoUrl($attribute, $params)
    {
        try {
            Video::factory($this->$attribute);
        }
        catch (CException $e) {
            $this->addError($attribute, 'Не удалось загрузить видео. <br>Возможно, URL указан неправильно либо ведет на неподдерживаемый сайт.');
        }
    }
}