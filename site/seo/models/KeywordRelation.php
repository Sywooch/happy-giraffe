<?php

/**
 * This is the model class for table "keywords__relations".
 *
 * The followings are the available columns in table 'keywords__relations':
 * @property integer $keyword_from_id
 * @property integer $keyword_to_id
 *
 * The followings are the available model relations:
 * @property Keyword $to
 * @property Keyword $from
 */
class KeywordRelation extends CActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return KeywordRelation the static model class
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
        return Yii::app()->db_keywords;
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'keywords__relations';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('keyword_from_id, keyword_to_id', 'required'),
            array('keyword_from_id, keyword_to_id', 'numerical', 'integerOnly' => true),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('keyword_from_id, keyword_to_id', 'safe', 'on' => 'search'),
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
            'to' => array(self::BELONGS_TO, 'Keyword', 'keyword_to_id'),
            'from' => array(self::BELONGS_TO, 'Keyword', 'keyword_from_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'keyword_from_id' => 'Keyword From',
            'keyword_to_id' => 'Keyword To',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search()
    {
        $criteria = new CDbCriteria;
        $criteria->compare('keyword_from_id', $this->keyword_from_id);
        $criteria->compare('keyword_to_id', $this->keyword_to_id);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public static function saveRelation($keyword_from_id, $keyword_to_id)
    {
        $exist = Yii::app()->db_keywords->createCommand()
            ->select('keyword_from_id')
            ->from(self::model()->tableName())
            ->where('keyword_from_id=:keyword_from_id AND keyword_to_id=:keyword_to_id',
            array(
                ':keyword_from_id' => $keyword_from_id,
                ':keyword_to_id' => $keyword_to_id,
            ))
            ->queryScalar();

        if (empty($exist)) {
            try {
                Yii::app()->db_keywords->createCommand()
                    ->insert(self::model()->tableName(),
                    array(
                        'keyword_from_id' => $keyword_from_id,
                        'keyword_to_id' => $keyword_to_id,
                    ));
            } catch (Exception $err) {

            }
        }
    }
}