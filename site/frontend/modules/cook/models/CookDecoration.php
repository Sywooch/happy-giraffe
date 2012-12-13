<?php

/**
 * This is the model class for table "cook__decorations".
 *
 * The followings are the available columns in table 'cook__decorations':
 * @property string $id
 * @property string $photo_id
 * @property string $category_id
 * @property string $title
 * @property string $description
 *
 * The followings are the available model relations:
 * @property CookDecorationCategory $category
 * @property AlbumPhoto $photo
 */
class CookDecoration extends CActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return CookDecoration the static model class
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
        return 'cook__decorations';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('photo_id, category_id', 'required'),
            array('photo_id, category_id', 'length', 'max' => 11),
            array('photo_id', 'unique'),
            array('title', 'length', 'max' => 70),
            array('description', 'length', 'max' => 200),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, photo_id, category_id, title', 'safe', 'on' => 'search'),
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
            'category' => array(self::BELONGS_TO, 'CookDecorationCategory', 'category_id'),
            'photo' => array(self::BELONGS_TO, 'AlbumPhoto', 'photo_id'),
        );
    }

    public function behaviors()
    {
        return array(
            'pingable' => array(
                'class' => 'site.common.behaviors.PingableBehavior',
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
            'photo_id' => 'Photo',
            'category_id' => 'Category',
            'title' => 'Title',
            'description' => 'Description',
        );
    }

    public function defaultScope()
    {
        $alias = $this->getTableAlias(false, false);
        return array(
            'order' => !empty($alias) ? $alias . '.id desc' : 'id desc',
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
        $criteria->compare('photo_id', $this->photo_id, true);
        $criteria->compare('category_id', $this->category_id, true);
        $criteria->compare('title', $this->title, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function indexDataProvider($categoryId)
    {
        $dataProvider = new CActiveDataProvider('CookDecoration', array(
            'criteria' => array(
                'order' => 't.created DESC',
                'condition' => ($categoryId) ? 'category_id=:category_id' : '',
                'params' => array(':category_id' => $categoryId),
                'with' => array('photo'),
            ),
            'pagination' => array(
                'pageSize' => 20,
                'pageVar' => 'page',
                //'route' => '/cook/decor'
            ),
        ));
        return $dataProvider;
    }

    public function getLastDecorations($limit = 9)
    {
        $criteria = new CDbCriteria;
        $criteria->limit = $limit;
        $criteria->order = 't.created DESC';
        $criteria->with = array('photo');

        return $this->findAll($criteria);
    }


    public function getUrlParams()
    {
        return array(
            'albums/singlePhoto',
            array(
                'photo_id' => $this->photo->id,
                'entity' => 'CookDecorationCategory',
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

    public function getPreview($imageWidth = 240)
    {
        $preview = CHtml::link(CHtml::image($this->photo->getPreviewUrl($imageWidth, null, Image::WIDTH)), $this->url);
        return $preview;
    }

    public function getRssContent()
    {
        return CHtml::image($this->photo->getPreviewUrl(960, 627, Image::HEIGHT, true), $this->title);
    }

    public function getAuthor()
    {
        return $this->photo->author;
    }

    protected function afterSave()
    {
        if ($this->isNewRecord)
            $this->sendEvent();
        parent::afterSave();
    }

    public function getEvent()
    {
        $row = array(
            'id' => $this->id,
            'last_updated' => time(),
            'type' => Event::EVENT_COOK_DECOR,
        );

        $event = Event::factory(Event::EVENT_COOK_DECOR);
        $event->attributes = $row;
        return $event;
    }

    public function sendEvent()
    {
        $event = $this->event;
        $params = array(
            'blockId' => $event->blockId,
            'code' => $event->code,
        );

        $comet = new CometModel;
        $comet->send('whatsNewIndex', $params, CometModel::WHATS_NEW_UPDATE);
    }
}