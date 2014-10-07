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
class HoroscopeCompatibility extends HActiveRecord implements IPreview
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
			array('zodiac1', 'required', 'message'=>'Укажите свой знак Зодиака'),
            array('zodiac2', 'required', 'message'=>'Укажите знак Зодиака своего партнера'),
			array('zodiac1, zodiac2', 'numerical', 'integerOnly'=>true),
			array('text', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, zodiac1, zodiac2, text', 'safe', 'on'=>'search'),
            array('*', 'compositeUniqueKeysValidator', 'on'=>'create'),
		);
	}

    public function compositeUniqueKeysValidator() {
        $this->validateCompositeUniqueKeys();
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

    public function behaviors() {
        return array(
            'ECompositeUniqueKeyValidatable' => array(
                'class' => 'ECompositeUniqueKeyValidatable',
                'uniqueKeys' => array(
                    'attributes' => 'zodiac1, zodiac2',
                    'errorMessage' => 'такой гороскоп уже есть',
                    'errorAttributes' => 'zodiac1, zodiac2',
                )
            ),
        );
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
            return Yii::app()->createUrl('/services/horoscope/compatibility/index', array(
                'zodiac1'=>Horoscope::model()->zodiac_list_eng[$zodiac1],
                'zodiac2'=>Horoscope::model()->zodiac_list_eng[$zodiac2],
            ));
        }
        return Yii::app()->createUrl('/services/horoscope/compatibility/index', array(
            'zodiac1'=>Horoscope::model()->zodiac_list_eng[$zodiac1],
        ));
    }

    public function getAvailableZodiacs(){
        $a = Horoscope::model()->zodiac_list;
        foreach($a as $key=>$_a)
            if ($key < $this->zodiac1)
                unset($a[$key]);

        return $a;
    }

    public function getPreviewPhoto()
    {
        return '';
    }

    public function getPreviewText()
    {
        return $this->text;
    }
}