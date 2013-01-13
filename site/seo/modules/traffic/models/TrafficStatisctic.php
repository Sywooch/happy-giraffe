<?php

/**
 * This is the model class for table "traffic__statisctics".
 *
 * The followings are the available columns in table 'traffic__statisctics':
 * @property string $section_id
 * @property string $date
 * @property integer $value
 * @property integer $full
 *
 * The followings are the available model relations:
 * @property TrafficSection $section
 */
class TrafficStatisctic extends HActiveRecord
{
    private $sections;
    private $ga;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return TrafficStatisctic the static model class
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
        return 'traffic__statisctics';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('section_id, date, value', 'required'),
            array('value', 'numerical', 'integerOnly' => true),
            array('section_id', 'length', 'max' => 10),
            array('section_id+date', 'uniqueMultiColumnValidator'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        return array(
            'section' => array(self::BELONGS_TO, 'TrafficSection', 'section_id'),
        );
    }

    public function attributeLabels()
    {
        return array(
            'section_id' => 'Section',
            'date' => 'Date',
            'value' => 'Value',
        );
    }

    public function parse()
    {
        Yii::import('site.frontend.components.*');
        Yii::import('site.frontend.extensions.GoogleAnalytics');

        $this->sections = TrafficSection::model()->findAll();

        //start with month ago
        $date = date("Y-m-d", strtotime('-1 month'));

        $this->ga = new GoogleAnalytics('alexk984@gmail.com', Yii::app()->params['gaPass']);
        $this->ga->setProfile('ga:53688414');

        while (strtotime($date) < time()) {
            $this->parseDate($date);
            $date = date("Y-m-d", strtotime('+1 day', strtotime($date)));
        }
    }

    public function parseDate($date)
    {
        echo $date . "\n";

        foreach ($this->sections as $section) {
            $traffic = TrafficStatisctic::model()->findByAttributes(array('date' => $date, 'section_id' => $section->id));
            if ($traffic === null || $traffic->full == false) {
                if (!empty($section->url))
                    $value = GApi::getUrlOrganicSearches($this->ga, $date, $date, '/' . $section->url . '/');
                else
                    $value = GApi::getUrlOrganicSearches($this->ga, $date, $date, '/');

                echo $section->url . ' - ' . $value . "\n";
                if ($traffic === null) {
                    $traffic = new TrafficStatisctic();
                    $traffic->section_id = $section->id;
                    $traffic->date = $date;
                }
                $traffic->value = $value;
                if ($date != date("Y-m-d"))
                    $traffic->full = 1;
                $traffic->save();
            }
        }
    }
}