<?php

/**
 * This is the model class for table "seo__article_keywords".
 *
 * The followings are the available columns in table 'seo__article_keywords':
 * @property string $id
 * @property string $entity
 * @property string $entity_id
 * @property string $url
 * @property string $keyword_group_id
 * @property int $number
 *
 * The followings are the available model relations:
 * @property KeywordGroup $keywordGroup
 */
class ArticleKeywords extends CActiveRecord
{
    public $keywords;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return ArticleKeywords the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function getDbConnection()
    {
        return Yii::app()->db_seo;
    }

    public function tableName()
    {
        return 'happy_giraffe_seo.article_keywords';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('url', 'required'),
            array('keywords', 'required', 'on' => 'check'),
            array('keywords', 'safe', 'on' => 'check'),
            array('entity', 'length', 'max' => 255),
            array('url', 'unique'),
            array('url', 'url'),
            array('entity_id, keyword_group_id', 'length', 'max' => 10),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, entity, entity_id, keyword_group_id', 'safe', 'on' => 'search'),
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
            'keywordGroup' => array(self::BELONGS_TO, 'KeywordGroup', 'keyword_group_id'),
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
            'keyword_group_id' => 'Keyword Group',
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
        $criteria->compare('keyword_group_id', $this->keyword_group_id, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function beforeSave()
    {
        $this->number = self::getDbConnection()->createCommand('select MAX(number) from ' . $this->tableName())->queryScalar() + 1;
        return parent::beforeSave();
    }

    public function beforeDelete()
    {
        $this->keywordGroup->delete();
        Yii::app()->db_seo->createCommand(' update article_keywords set number = number - 1 WHERE id >' . $this->id)->execute();
        return parent::beforeDelete();
    }

    public function getArticle()
    {
        $model = CActiveRecord::model($this->entity)->findByPk($this->entity_id);
        if ($model === null)
            return null;
        return $model;
    }

    public function getKeywords()
    {
        $keys = array();
        foreach ($this->keywordGroup->keywords as $keyword) {
            $keys [] = $keyword->name;
        }

        return implode('<br>', $keys);
    }

    public function getArticleLink()
    {
        $model = CActiveRecord::model($this->entity)->findByPk($this->entity_id);
        if ($model === null)
            return '';
        return CHtml::link($model->title, $model->getUrl());
    }
}