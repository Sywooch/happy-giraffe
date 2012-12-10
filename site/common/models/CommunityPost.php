<?php

/**
 * This is the model class for table "community__posts".
 *
 * The followings are the available columns in table 'community__posts':
 * @property string $id
 * @property string $text
 * @property string $source_type
 * @property string $internet_link
 * @property string $internet_favicon
 * @property string $internet_title
 * @property string $book_author
 * @property string $book_name
 * @property string $content_id
 * @property string $photo_id
 *
 * @property CommunityContent $content
 * @property AlbumPhoto $photo
 */
class CommunityPost extends HActiveRecord
{
    public static $genres = array(
        'lenta' => 'lenta (короткое новостное сообщение, 50-80 символов)',
        'message' => 'message (более развёрнутое новостное сообщение)',
        'article' => 'article (статья)',
        'interview' => 'interview (интервью)',
    );

    /**
     * Returns the static model of the specified AR class.
     * @return CommunityPost the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function behaviors()
    {
        return array(
            'addImageTags' => array(
                'class' => 'site.common.behaviors.AddImageTagsBehavior',
            ),
            'cut' => array(
                'class' => 'site.common.behaviors.CutBehavior',
                'attributes' => array('text'),
                'edit_routes' => array('community/edit'),
            ),
            'purified' => array(
                'class' => 'site.common.behaviors.PurifiedBehavior',
                'attributes' => array('text', 'preview'),
                'options' => array(
                    'HTML.AllowedComments' => array(
                        'gallery' => true,
                    ),
                    'AutoFormat.Linkify' => true,
                ),
            ),
            'externalImages' => array(
                'class' => 'site.common.behaviors.ExternalImagesBehavior',
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
            array('internet_link, internet_favicon, internet_title, book_author, book_name', 'length', 'max' => 255),
            array('content_id', 'length', 'max' => 11),
            array('content_id, photo_id', 'numerical', 'integerOnly' => true),
            array('content_id', 'exist', 'attributeName' => 'id', 'className' => 'CommunityContent'),
            array('source_type', 'in', 'range' => array('me', 'internet', 'book')),
            array('genre', 'in', 'range' => array_keys(self::$genres)),
            array('genre', 'default', 'value' => null),

            //array('text', 'filter', 'filter' => array('Filters', 'add_nofollow')),

            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, text, source_type, internet_link, internet_favicon, internet_title, book_author, book_name, content_id', 'safe', 'on' => 'search'),
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
            'source_type' => 'Source Type',
            'internet_link' => 'Internet Link',
            'internet_favicon' => 'Internet Favicon',
            'internet_title' => 'Internet Title',
            'book_author' => 'Book Author',
            'book_name' => 'Book Name',
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
        $criteria->compare('source_type', $this->source_type, true);
        $criteria->compare('internet_link', $this->internet_link, true);
        $criteria->compare('internet_favicon', $this->internet_favicon, true);
        $criteria->compare('internet_title', $this->internet_title, true);
        $criteria->compare('book_author', $this->book_author, true);
        $criteria->compare('book_name', $this->book_name, true);
        $criteria->compare('content_id', $this->content_id, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    protected function afterSave()
    {
        if ($this->isNewRecord && ($this->content->contentAuthor->group == UserGroup::USER
            || $this->content->contentAuthor->group == UserGroup::ENGINEER)) {

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
                if ($image !== false && strpos($image, 'http://') !== 0)
                    $image = 'http://www.happy-giraffe.ru' . $image;

                if ($image !== false) {
                    $photo = AlbumPhoto::createByUrl($image, $author_id, 6);
                    if ($photo)
                        $this->photo_id = $photo->id;
                }
            }
    }
}