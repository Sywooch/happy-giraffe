<?php

/**
 * This is the model class for table "traffic__sections".
 *
 * The followings are the available columns in table 'traffic__sections':
 * @property string $id
 * @property string $url
 * @property string $title
 *
 * The followings are the available model relations:
 * @property TrafficSection $parent
 * @property TrafficSection[] $sections
 * @property TrafficStatisctic[] $stat
 */
class TrafficSection extends HActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return TrafficSection the static model class
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
        return 'traffic__sections';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('url, title', 'required'),
            array('url', 'length', 'max' => 100),
            array('title', 'length', 'max' => 256),
            array('id, url, title, parent_id', 'safe'),
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
            'parent' => array(self::BELONGS_TO, 'TrafficSection', 'parent_id'),
            'sections' => array(self::HAS_MANY, 'TrafficSection', 'parent_id'),
            'stat' => array(self::HAS_MANY, 'TrafficStatisctic', 'section_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'url' => 'Url',
            'title' => 'Title',
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
        $criteria->compare('url', $this->url, true);
        $criteria->compare('title', $this->title, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * @param $date1
     * @param $date2
     * @return int
     */
    public function getVisitsCount($date1, $date2)
    {
        return Yii::app()->db_seo->createCommand()
            ->select('sum(value)')
            ->from('traffic__statisctics')
            ->where('`date`>=:date1 AND `date` <= :date2 AND section_id = :section_id',
            array(':date1' => $date1, ':date2' => $date2, ':section_id' => $this->id))
            ->queryScalar();
    }
}