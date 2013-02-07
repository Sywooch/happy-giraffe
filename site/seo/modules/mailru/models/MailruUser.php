<?php

/**
 * This is the model class for table "mailru__users".
 *
 * The followings are the available columns in table 'mailru__users':
 * @property string $id
 * @property string $name
 * @property string $email
 * @property string $deti_url
 * @property string $moi_mir_url
 * @property string $birthday
 * @property string $location
 * @property string $last_visit
 * @property int $parse_friends
 * @property int $active
 *
 * The followings are the available model relations:
 * @property MailruBaby[] $babies
 */
class MailruUser extends HActiveRecord
{
    const STATUS_DEFAULT = 0;
    const STATUS_NOT_OPEN = 2;


	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return MailruUser the static model class
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
		return 'mailru__users';
	}

    public function getDbConnection()
    {
        return Yii::app()->db_seo;
    }

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, email', 'required'),
			array('name, email, deti_url, moi_mir_url, location', 'length', 'max'=>255),
			array('birthday, last_visit', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, email, deti_url, moi_mir_url, birthday, location, last_visit', 'safe', 'on'=>'search'),
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
			'babies' => array(self::HAS_MANY, 'MailruBaby', 'parent_id'),
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
			'email' => 'Email',
			'deti_url' => 'Deti Url',
			'moi_mir_url' => 'Moi Mir Url',
			'birthday' => 'Birthday',
			'location' => 'Location',
			'last_visit' => 'Last Visit',
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
		$criteria->compare('name',$this->name,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('deti_url',$this->deti_url,true);
		$criteria->compare('moi_mir_url',$this->moi_mir_url,true);
		$criteria->compare('birthday',$this->birthday,true);
		$criteria->compare('location',$this->location,true);
		$criteria->compare('last_visit',$this->last_visit,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    public function calculateEmail()
    {
        preg_match('/http:\/\/deti.mail.ru\/(.+)\/(.+)\//', $this->deti_url, $match);
        if (count($match) == 3){
            return trim($match[2].'@'.$match[1].'.ru');
        }

        return null;
    }

    public function calculateEmail2()
    {
        preg_match('/\/(.+)\/(.+)\//', $this->deti_url, $match);
        if (count($match) == 3){
            return trim($match[2].'@'.$match[1].'.ru');
        }

        return null;
    }

    public function test()
    {
        $this->deti_url = 'http://deti.mail.ru/mail/annettehcom';
        echo $this->calculateEmail().'<br>';
        $this->deti_url = 'http://deti.mail.ru/mail/tanya-shamorkina';
        echo $this->calculateEmail().'<br>';
        $this->deti_url = 'http://deti.mail.ru/inbox/nazvanova';
        echo $this->calculateEmail().'<br>';

        $this->deti_url = 'http://deti.mail.ru/mail/anuta.71';
        echo $this->calculateEmail().'<br>';
        $this->deti_url = 'http://deti.mail.ru/mail/k_s_e_n_i_y_a_85';
        echo $this->calculateEmail().'<br>';
    }
}