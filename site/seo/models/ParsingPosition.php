<?php

/**
 * This is the model class for table "parsing_positions".
 *
 * The followings are the available columns in table 'parsing_positions':
 * @property integer $keyword_id
 * @property integer $active
 * @property integer $yandex
 * @property integer $google
 *
 * The followings are the available model relations:
 * @property Keyword $keyword
 */
class ParsingPosition extends HActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return ParsingPosition the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return CDbConnection database connection
     */
    public function getDbConnection()
    {
        return Yii::app()->db_seo;
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'parsing_positions';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('keyword_id', 'numerical', 'integerOnly' => true),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('keyword_id, active, yandex, google', 'safe', 'on' => 'search'),
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
            'keyword' => array(self::BELONGS_TO, 'Keyword', 'keyword_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'keyword_id' => 'Keyword',
            'active' => 'Active',
            'yandex' => 'Yandex',
            'google' => 'Google',
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

        $criteria->compare('keyword_id', $this->keyword_id);
        $criteria->compare('active', $this->active);
        $criteria->compare('yandex', $this->yandex);
        $criteria->compare('google', $this->google);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public static function collectKeywords()
    {
        //берем кейворды по которым заходили за последние 4 недели
        $keywords = Yii::app()->db_seo->createCommand()
            ->select('keyword_id')
            ->from('queries')
            ->where('week >= :week', array(':week' => (date('W') - 4)))
            ->queryColumn();

        $keywords = array_unique($keywords);

        foreach ($keywords as $keyword) {
            $p = new ParsingPosition;
            $p->keyword_id = $keyword;
            try{
                $p->save();
            }catch (Exception $err){

            }
        }
    }

    public static function collectPagesKeywords()
    {
        //берем кейворды по которым заходили за последние 4 недели
        $criteria = new CDbCriteria;
        $criteria->limit = 100;
        $criteria->offset = 0;

        $keywords = array();

        $i = 0;
        $models = array(0);
        while (!empty($models)) {
            $models = Page::model()->with('keywordGroup', 'keywordGroup.keywords')->findAll($criteria);

            foreach ($models as $model)
                if (!empty($model->keywordGroup))
                    foreach ($model->keywordGroup->keywords as $keyword)
                        $keywords[] = $keyword->id;

            $i++;
            $criteria->offset = $i * 100;
        }

        $keywords = array_unique($keywords);
        foreach ($keywords as $keyword) {
            $p = new ParsingPosition;
            $p->keyword_id = $keyword;
            $p->save();
        }
    }
}