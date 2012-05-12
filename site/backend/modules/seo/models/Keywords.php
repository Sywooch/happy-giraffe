<?php

/**
 * This is the model class for table "seo_keywords".
 *
 * The followings are the available columns in table 'seo_keywords':
 * @property integer $id
 * @property string $name
 *
 * The followings are the available model relations:
 * @property Stats[] $seoStats
 * @property KeywordGroup[] $keywordGroups
 * @property YandexPopularity $yandexPopularity
 */
class Keywords extends HActiveRecord
{
    public $btns;

    /**
     * Returns the static model of the specified AR class.
     * @return Keywords the static model class
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
        return 'happy_giraffe_seo.keywords';
    }

    public function getDbConnection()
    {
        return Yii::app()->db_seo;
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name', 'length', 'max' => 1024),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, name', 'safe', 'on' => 'search'),
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
            'seoStats' => array(self::HAS_MANY, 'Stats', 'keyword_id'),
            'keywordGroups' => array(self::MANY_MANY, 'KeywordGroup', 'keyword_group_keywords(keyword_id, group_id)'),
            'yandexPopularity' => array(self::HAS_ONE, 'YandexPopularity', 'keyword_id'),
            'tempKeyword' => array(self::HAS_ONE, 'TempKeywords', 'id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'name' => 'Name',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search()
    {
        $criteria = new CDbCriteria;
        //$criteria->compare('t.id', $this->id);
        if (!empty($this->name)) {
            $allSearch = Yii::app()->search
                ->select('*')
                ->from('keywords')
                ->where('* ' . $this->name . ' *')
                ->limit(0, 100000)
                ->searchRaw();
            $ids = array();
            foreach ($allSearch['matches'] as $key => $m) {
                $ids [] = $key;
            }
            if (!empty($ids))
                $criteria->compare('t.id', $ids);
            else
                $criteria->compare('t.id', 835768577);
        }
        $criteria->with = array('keywordGroups', 'yandexPopularity', 'tempKeyword');

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array('pageSize' => 20),
        ));
    }

    /**
     * @static
     * @param string $word
     * @return Keywords
     * @throws CHttpException
     */
    public static function GetKeyword($word)
    {
        $word = trim($word);
        $model = self::sphinxSearch($word);
        if ($model !== null)
            return $model;

        $model = new Keywords();
        $model->name = $word;
        if (!$model->save())
            throw new CHttpException(404, 'Кейворд не сохранен. ' . $word);

        return $model;
    }

    public static function sphinxSearch($word)
    {
        $allSearch = Yii::app()->search
            ->select('*')
            ->from('keywords')
            ->where($word)
            ->limit(0, 1000)
            ->searchRaw();

        if (!empty($allSearch['matches']))

            foreach ($allSearch['matches'] as $key => $m) {
                return Keywords::model()->findByPk($key);
            }

        return null;
    }

    public function hasOpenedTask()
    {
        foreach ($this->keywordGroups as $group) {
            if ($group->newTaskCount > 0)
                return true;
        }

        return false;
    }

    public function used()
    {
        foreach ($this->keywordGroups as $group) {
            if (!empty($group->seoArticleKeywords))
                return true;
        }

        if (!empty($this->tempKeyword))
            return true;

        return false;
    }

    public function getButtons()
    {
        if (!$this->used()) {
            echo CHtml::hiddenField('id', $this->id);
            echo CHtml::link('выбрать', '#', array('onclick' => 'return SeoKeywords.Select(this);'));
        }
    }

    public function getClass()
    {
        if ($this->used()) return 'used';
        elseif ($this->hasOpenedTask()) return 'active';
        return 'default';
    }
}