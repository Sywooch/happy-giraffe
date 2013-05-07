<?php

/**
 * This is the model class for table "pages_search_phrases_positions".
 *
 * The followings are the available columns in table 'pages_search_phrases_positions':
 * @property string $id
 * @property string $search_phrase_id
 * @property string $se_id
 * @property integer $position
 * @property string $date
 *
 * The followings are the available model relations:
 * @property PagesSearchPhrase $phrase
 */
class SearchPhrasePosition extends HActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return SearchPhrasePosition the static model class
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
        return 'pages_search_phrases_positions';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('search_phrase_id, se_id, position', 'required'),
            array('position', 'numerical', 'integerOnly' => true),
            array('search_phrase_id, se_id', 'length', 'max' => 11),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, search_phrase_id, se_id, position, date', 'safe', 'on' => 'search'),
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
            'phrase' => array(self::BELONGS_TO, 'PagesSearchPhrase', 'search_phrase_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'search_phrase_id' => 'Search Phrase',
            'se_id' => 'Se',
            'position' => 'Position',
            'date' => 'Date',
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
        $criteria->compare('search_phrase_id', $this->search_phrase_id, true);
        $criteria->compare('se_id', $this->se_id, true);
        $criteria->compare('position', $this->position);
        $criteria->compare('date', $this->date, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function beforeSave()
    {
        if ($this->isNewRecord) {
            $model = self::model()->findByAttributes(array(
                'search_phrase_id' => $this->search_phrase_id,
                'se_id' => $this->se_id,
                'date' => date("Y-m-d")
            ));
            $this->date = date("Y-m-d");
            if ($model !== null) {
                $model->position = $this->position;
                $model->save();
                return false;
            }
        }

        return parent::beforeSave();
    }

    public function getSe()
    {
        if ($this->se_id == 2) return 'yandex';
        if ($this->se_id == 3) return 'google';
        return $this->se_id;
    }
}