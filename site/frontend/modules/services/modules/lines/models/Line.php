<?php

/**
 * This is the model class for table "services__lines".
 *
 * The followings are the available columns in table 'services__lines':
 * @property string $id
 * @property integer $type
 * @property integer $image_id
 * @property string $title
 * @property string $date
 */
class Line extends HActiveRecord
{
    const TYPE_LOVE = 1;
    const TYPE_WEDDING = 2;
    const TYPE_PREGNANCY = 3;
    const TYPE_BABY = 4;

    public $text_types = array(1 => 'Любовь', 2 => 'Свадьба', 3 => 'Беременность', 4 => 'Ребенок');

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Line the static model class
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
        return 'services__lines';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('type, image_id, title, date', 'required'),
            array('type, image_id', 'numerical', 'integerOnly' => true),
            array('title', 'length', 'max' => 255),
            array('id', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, type, image_id, title, date', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array();
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'type' => 'Type',
            'image_id' => 'Image',
            'title' => 'Title',
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
        $criteria->compare('type', $this->type);
        $criteria->compare('image_id', $this->image_id);
        $criteria->compare('title', $this->title, true);
        $criteria->compare('date', $this->date, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }


    public function getTextType()
    {
        return $this->text_types[$this->type];
    }

    public function getDateText()
    {
        $result = '';
        switch ($this->type) {
            case self::TYPE_PREGNANCY:
                $days_count = round(time() - strtotime($this->date)) / 86400;
                if ($days_count > 6) {
                    $result .= floor($days_count / 7) . ' ' . Str::GenerateNoun(array('неделя', 'недели', 'недель'), floor($days_count / 7)) . ' и ';
                    $days_count = $days_count % 7;
                }
                return $result . $days_count . ' ' . Str::GenerateNoun(array('день', 'дня', 'дней'), $days_count);

            case self::TYPE_BABY:
            case self::TYPE_LOVE:
                return $this->getSpentTimeString();
        }

        return '';
    }

    public function getImage()
    {
        switch ($this->type) {
            case self::TYPE_LOVE:
                return 'love.jpg';
            case self::TYPE_WEDDING:
                return 'wedding.jpg';
            case self::TYPE_PREGNANCY:
                return 'pregnancy.jpg';
            case self::TYPE_BABY:
                return 'baby.jpg';
            default:
                return 'baby.jpg';
        }
    }

    public function getSpentTimeString()
    {
        $month_len = 29.5305882;
        $days_count = floor((time() - strtotime($this->date)) / 86400);
        if ($days_count < 30)
            return $days_count . ' ' . Str::GenerateNoun(array('день', 'дня', 'дней'), $days_count);

        $month_count = floor($days_count / $month_len);
        if ($month_count < 12) {
            $days_count = floor($days_count - $month_count * $month_len);

            return $month_count . ' ' . Str::GenerateNoun(array('месяц', 'месяца', 'месяцев'), $month_count) . ' и '
                . $days_count . ' ' . Str::GenerateNoun(array('день', 'дня', 'дней'), $days_count);
        }

        $years_count = floor($month_count / 12);
        $month_count = $month_count % 12;
        return $years_count . ' ' . Str::GenerateNoun(array('год', 'года', 'лет'), $years_count) . ' и '
            . $month_count . ' ' . Str::GenerateNoun(array('месяц', 'месяца', 'месяцев'), $month_count);
    }
}