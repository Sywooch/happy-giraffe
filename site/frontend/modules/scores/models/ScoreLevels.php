<?php

/**
 * This is the model class for table "score__levels".
 *
 * The followings are the available columns in table 'score__levels':
 * @property string $id
 * @property string $title
 * @property string $css_class
 * @property integer $score_cost
 *
 * The followings are the available model relations:
 * @property UserScores[] $userScores
 */
class ScoreLevels extends HActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return ScoreLevels the static model class
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
        return 'score__levels';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('score_cost', 'required'),
            array('score_cost', 'numerical', 'integerOnly' => true),
            array('title, css_class', 'length', 'max' => 256),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, title, css_class, score_cost', 'safe', 'on' => 'search'),
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
            'userScores' => array(self::HAS_MANY, 'UserScores', 'level_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'title' => 'Name',
            'css_class' => 'Css Class',
            'score_cost' => 'Score Cost',
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
        $criteria->compare('title', $this->title, true);
        $criteria->compare('css_class', $this->css_class, true);
        $criteria->compare('score_cost', $this->score_cost);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public static function getLevelInfo($id)
    {
        $cache_id = 'ScoreLevels' . $id;
        $value = Yii::app()->cache->get($cache_id);
        if ($value === false) {
            $model = self::findByPk($id);
            $value = $model->attributes;
            Yii::app()->cache->set($cache_id, $value, 3600);
        }

        return $value;
    }
}