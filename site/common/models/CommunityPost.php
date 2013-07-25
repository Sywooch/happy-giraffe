<?php

/**
 * This is the model class for table "community__posts".
 *
 * The followings are the available columns in table 'community__posts':
 * @property string $id
 * @property string $text
 * @property string $content_id
 * @property string $photo_id
 *
 * @property CommunityContent $content
 * @property AlbumPhoto $photo
 */
class CommunityPost extends HActiveRecord
{
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
        return array(
            'preview' => array(
                'class' => 'site.common.behaviors.PreviewBehavior',
                'small_preview' => true,
            ),
            'addImageTags' => array(
                'class' => 'site.common.behaviors.AddImageTagsBehavior',
            ),
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
//            'externalImages' => array(
//                'class' => 'site.common.behaviors.ExternalImagesBehavior',
//                'attributes' => array('text'),
//            ),
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

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id, true);
        $criteria->compare('text', $this->text, true);
        $criteria->compare('content_id', $this->content_id, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    protected function afterSave()
    {
        if ($this->isNewRecord && ($this->content->author->group == UserGroup::USER
            || $this->content->author->group == UserGroup::ENGINEER)) {

            if (strlen($this->text) > 250){
                $this->content->uniqueness = CopyScape::getUniquenessByText($this->text);
                $this->content->update(array('uniqueness'));
            }else{
                $this->content->uniqueness = 1;
                $this->content->update(array('uniqueness'));
            }
        }

        parent::afterSave();
    }


    protected function afterFind()
    {
        if (isset(Yii::app()->controller->route) && Yii::app()->controller->route == 'community/edit')
            $this->text = str_replace('<!--gallery-->', '<hr class="gallery" />', $this->text);

        parent::afterFind();
    }

    protected function beforeSave()
    {
        if ($this->isNewRecord)
            $this->searchImage(Yii::app()->user->id);
        else {
            if (isset($this->content->author_id))
                $this->searchImage($this->content->author_id);
        }

        $this->text = str_replace('<hr class="gallery" />', '<!--gallery-->', $this->text);

        return parent::beforeSave();
    }

    public function getPhoto(){
        return $this->photo;
    }

    public function searchImage($author_id)
    {
        if (!empty($this->photo_id))
            return ;

        if (preg_match('/http:\/\/img.happy-giraffe.ru\/thumbs\/[\d]+x[\d]+\/[\d]+\/([^\"]+)/', $this->text, $m)) {
            $photo = AlbumPhoto::model()->findByAttributes(array('fs_name' => $m[1]));
            if (isset($photo)) {
                $this->photo_id = $photo->id;
            }
        }

        if (empty($this->photo_id))
            if (preg_match_all('/src="([^"]+)"/', $this->text, $matches)) {
                if (!empty($matches[0])) {
                    $image = false;
                    for ($i = 0; $i < count($matches[0]); $i++) {
                        $image_url = $matches[1][$i];
                        if (strpos($image_url, '/images/widget/smiles/') !== 0) {
                            $image = $image_url;
                            break;
                        }
                    }
                }
                if (isset($image) && $image !== false && strpos($image, 'http://') !== 0)
                    $image = 'http://www.happy-giraffe.ru' . $image;

                if (isset($image) && $image !== false) {
                    $photo = AlbumPhoto::createByUrl($image, $author_id, 6);
                    if ($photo)
                        $this->photo_id = $photo->id;
                }
            }

        //если не нашли проверяем возможно прикрученную фотогалерею
        if (empty($this->photo_id)){
            if (isset($this->content) && isset($this->content->gallery) && isset($this->content->gallery->items[0])){
                $this->photo_id = $this->content->gallery->items[0]->photo_id;
            }
        }
    }
}