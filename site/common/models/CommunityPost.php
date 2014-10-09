<?php

/**
 * This is the model class for table "community__posts".
 *
 * The followings are the available columns in table 'community__posts':
 * @property string $id
 * @property string $text
 * @property string $content_id
 * @property string $photo_id
 * @property string $video
 *
 * @property CommunityContent $content
 * @property AlbumPhoto $photo
 */
class CommunityPost extends HActiveRecord
{
    /**
     * Массив фото, содержащихся в тексте, заполняется поведением ProcessingImagesBehavior
     * @var array
     */
    public $processed_photos = array();
    public $isContestWork = false;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className
     * @return CommunityPost the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function behaviors()
    {
        if($this->scenario == 'advEditor')
            return array(
//                'PhotoCollectionBehavior' => array(
//                    'class' => 'site\frontend\modules\photo\components\PhotoCollectionBehavior',
//                    'attributeCollections' => array('text'),
//                ),
            );
        return array(
//            'PhotoCollectionBehavior' => array(
//                'class' => 'site\frontend\modules\photo\components\PhotoCollectionBehavior',
//            ),
            'purified' => array(
                'class' => 'site.common.behaviors.PurifiedBehavior',
                'attributes' => array('text'),
                'options' => array(
                    'HTML.AllowedComments' => array(
                        'gallery' => true,
                    ),
                    'AutoFormat.Linkify' => true,
                ),
            ),
            'processingImages' => array(
                'class' => 'site.common.behaviors.ProcessingImagesBehavior',
                'attributes' => array('text'),
                'searchPreviewPhoto' => true
            ),
            'previewSave' => array(
                'class' => 'site.common.behaviors.PreviewBehavior',
                'search_video' => true
            ),
            'forEdit' => array(
                'class' => 'site.common.behaviors.PrepareForEdit',
                'attributes' => array('text'),
            ),
        );
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'community__posts';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('text', 'required'),
            array('content_id', 'required', 'on' => 'edit'),
            array('content_id', 'length', 'max' => 11),
            array('content_id, photo_id', 'numerical', 'integerOnly' => true),
            array('content_id', 'exist', 'attributeName' => 'id', 'className' => 'CommunityContent'),

            //array('text', 'filter', 'filter' => array('Filters', 'add_nofollow')),
            array('id, text, photo_id, content_id', 'safe', 'on' => 'search'),
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
            'text' => 'Текст',
            'content_id' => 'Content',
        );
    }

    protected function afterSave()
    {
        if ($this->isNewRecord) {
            $this->content->uniqueness = CopyScape::getUniquenessByText($this->text);
            $this->content->update(array('uniqueness'));
        }

        parent::afterSave();
    }

    protected function afterFind()
    {
        if (isset(Yii::app()->controller->route) && Yii::app()->controller->route == 'community/edit')
            $this->text = str_replace('<!--gallery-->', '<hr class="gallery" />', $this->text);

        parent::afterFind();
    }

    public function getPhoto()
    {
        return $this->photo;
    }
}