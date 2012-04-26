<?php

/**
 * This is the model class for table "yarn_projects".
 *
 * The followings are the available columns in table 'yarn_projects':
 * @property integer $id
 * @property string $name
 * @property integer $sizes_id
 * @property integer $loop_type_id
 */
class YarnProjects extends HActiveRecord
{
    public $sizes = array(
        1 => array(1 => '50.5 см размер груди (6 месяцев)',
            2 => '56 см размер груди (12 месяцев)',
            3 => '61 см размер груди (18 месяцев)',
            4 => '63.5 см размер груди (35)',
            5 => '68.5 см размер груди (36)',
            6 => '73.5 см размер груди (37)',
            7 => '78.5 см размер груди (38)',
            8 => '84 см размер груди (39)',
            9 => '89 см размер груди (40,5)'),
        2 => array(1 => '9 - 11.5 см размер (младенец 1 - 4)',
            2 => '11.5 - 15 см размер (малыш 5 - 9)',
            3 => '17 - 19 см размер (малыш 10 - 13)',
            4 => '19 - 24 см размер (ребенок 1 - 6)'),
        3 => array(1 => '61 x 76 см размер',
            2 => '71 x 92 см размер',
            3 => '92 x 92 см размер',
            4 => '92 x 122 см размер',
            5 => '122 x 153 см размер',
            6 => '132 x 178 см размер'),
        4 => array(1 => '35.5 см охват головы (младенец)',
            2 => '40.5 см охват головы (ребенок)',
            3 => '45.5 см охват головы (маленькая женщина)',
            4 => '51 см охват головы (женщина)',
            5 => '56 см охват головы (Мужчина)'),
        5 => array(1 => '91.5 см размер груди (XS)',
            2 => '101.5 см размер груди (S)',
            3 => '111.5 см размер груди (M)',
            4 => '122 см размер груди (L)',
            5 => '132 см размер груди (XL)',
            6 => '142 см размер груди (2XL)'),
        6 => array(1 => 'Детский S',
            2 => 'Детский L',
            3 => 'Взрослый S',
            4 => 'Взрослый L'),
        7 => array(1 => '10 x 122 см',
            2 => '10 x 152 см',
            3 => '10 x 178 см',
            4 => '12.5 x 122 см',
            5 => '12.5 x 152 см',
            6 => '12.5 x 178 см',
            7 => '12.5 x 254 см',
            8 => '15 x 122 см',
            9 => '15 x 152 см',
            10 => '15 x 178 см',
            11 => '15 x 254 см',
            12 => '20 x 122 см',
            13 => '20 x 152 см',
            14 => '20 x 178 см',
            15 => '20 x 254 см'),
        8 => array(1 => '40.5 x 152 см',
            2 => '40.5 x 178 см',
            3 => '45.5 x 152 см',
            4 => '45.5 x 178 см',
            5 => '51 x 152 см',
            6 => '51 x 178 см',
            7 => '66 x 152 см',
            8 => '66 x 178 см'),
        9 => array(1 => 'Женская взрослая',
            2 => 'Мужская S / M',
            3 => 'Мужская L'),
        10 => array(1 => '81 см размер груди (XS)',
            2 => '91.5 см размер груди (S)',
            3 => '101.5 см размер груди (M)',
            4 => '111.5 см размер груди (L)',
            5 => '122 см размер груди (XL)',
            6 => '132 см размер груди (2XL)',
            7 => '142 см размер груди (3XL)')
    );

    public $gauges = array(
        1 => array(1 => '8 петель / 10 см (40-60 м. в 100 гр.)',
            2 => '12 петель / 10 см (70-90 м. в 100 гр.)',
            3 => '14 петель / 10 см (90-120 м. в 100 гр.)',
            4 => '16 петель / 10 см (120-180 м. в 100 гр.)',
            5 => '18 петель / 10 см (190-220 м. в 100 гр.)',
            6 => '20 петель / 10 см (230-300 м. в 100 гр.)',
            7 => '22 петли / 10 см (280-320 м. в 100 гр.)',
            8 => '24 петель / 10 см (310-350 м. в 100 гр.)'),
        2 => array(1 => '16 петель / 10 см (120-180 м. в 100 гр.)',
            2 => '18 петель / 10 см (190-220 м. в 100 гр.)',
            3 => '20 петель / 10 см (230-300 м. в 100 гр.)',
            4 => '22 петли / 10 см (280-320 м. в 100 гр.)',
            5 => '24 петель / 10 см (310-350 м. в 100 гр.)',
            6 => '28 петель / 10 см (380-450 м. в 100 гр.)',
            7 => '32 петли / 10 см (450-520 м. в 100 гр.)')
    );

    /**
     * Returns the static model of the specified AR class.
     * @return YarnProjects the static model class
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
        return 'sewing__yarn_projects';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name, sizes_id, loop_type_id', 'required'),
            array('sizes_id, loop_type_id', 'numerical', 'integerOnly' => true),
            array('name', 'length', 'max' => 256),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, name, sizes_id, loop_type_id', 'safe', 'on' => 'search'),
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
            'sizes_id' => 'Sizes',
            'loop_type_id' => 'Loop Type',
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

        $criteria->compare('id', $this->id);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('sizes_id', $this->sizes_id);
        $criteria->compare('loop_type_id', $this->loop_type_id);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }
}