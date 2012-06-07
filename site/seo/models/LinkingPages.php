<?php

/**
 * This is the model class for table "linking_pages".
 *
 * The followings are the available columns in table 'linking_pages':
 * @property string $id
 * @property string $entity
 * @property string $entity_id
 * @property string $url
 *
 * The followings are the available model relations:
 * @property LinkingPagesPages[] $linkingTo
 * @property LinkingPagesPages[] $linkingFrom
 */
class LinkingPages extends CActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return LinkingPages the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function getDbConnection()
    {
        return Yii::app()->db_seo;
    }

    public function tableName()
    {
        return 'happy_giraffe_seo.linking_pages';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('entity, entity_id', 'required'),
            array('entity', 'length', 'max' => 16),
            array('entity_id', 'length', 'max' => 10),
            array('url', 'length', 'max' => 255),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, entity, entity_id, url', 'safe', 'on' => 'search'),
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
            'linkingTo' => array(self::HAS_MANY, 'LinkingPagesPages', 'page_id'),
            'linkingFrom' => array(self::HAS_MANY, 'LinkingPagesPages', 'linkto_page_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'entity' => 'Entity',
            'entity_id' => 'Entity',
            'url' => 'Url',
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
        $criteria->compare('entity', $this->entity, true);
        $criteria->compare('entity_id', $this->entity_id, true);
        $criteria->compare('url', $this->url, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function getPageUrl()
    {
        $model = CActiveRecord::model($this->entity)->findByPk($this->entity_id);
        if ($model === null)
            return null;
        return $model->url;
    }

    public function hasLinkFrom($entity, $entity_id)
    {
        foreach ($this->linkingFrom as $link)
            if ($link->page->entity == $entity && $link->page->entity_id == $entity_id)
                return true;

        return false;
    }

    public function hasLinkKeyword($keyword_id)
    {
        foreach ($this->linkingFrom as $link)
            if ($link->keyword_id == $keyword_id)
                return true;

        return false;
    }

    public static function OutLinksCount($entity, $entity_id){
        $linkingPageFrom = LinkingPages::model()->findByPk(array(
            'entity' => $entity,
            'entity_id' => $entity_id
        ));
        if ($linkingPageFrom === null)
            return 0;
        else
            return count($linkingPageFrom->linkingTo);
    }
}