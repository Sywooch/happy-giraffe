<?php

/**
 * This is the model class for table "services__horoscope_compatibility".
 *
 * The followings are the available columns in table 'services__horoscope_compatibility':
 * @property string $id
 * @property integer $zodiac1
 * @property integer $zodiac2
 * @property string $text
 */
class HoroscopeCompatibility extends HActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return HoroscopeCompatibility the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'services__horoscope_compatibility';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('zodiac1, zodiac2', 'required', 'message'=>'Укажите знак зодиака'),
			array('zodiac1, zodiac2', 'numerical', 'integerOnly'=>true),
			array('text', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, zodiac1, zodiac2, text', 'safe', 'on'=>'search'),
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
			'zodiac1' => 'Зодиак 1',
			'zodiac2' => 'Зодиак 2',
			'text' => 'Текст',
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

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('zodiac1',$this->zodiac1);
		$criteria->compare('zodiac2',$this->zodiac2);
		$criteria->compare('text',$this->text,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    public function getFormattedText()
    {
        return Str::strToParagraph($this->text);
    }

    public function getZodiacText($zodiac)
    {
        return Horoscope::model()->zodiac_list[$zodiac];
    }

    public function getUrl($zodiac1, $zodiac2 = null)
    {
        if ($zodiac2 !== null){
            return Yii::app()->createUrl('/services/horoscope/default/compatibility', array(
                'zodiac1'=>Horoscope::model()->zodiac_list_eng[$zodiac1],
                'zodiac2'=>Horoscope::model()->zodiac_list_eng[$zodiac2],
            ));
        }
        return Yii::app()->createUrl('/services/horoscope/default/compatibility', array(
            'zodiac1'=>Horoscope::model()->zodiac_list_eng[$zodiac1],
        ));
    }
}