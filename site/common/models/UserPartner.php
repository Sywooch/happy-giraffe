<?php

/**
 * This is the model class for table "user_partner".
 *
 * The followings are the available columns in table 'user_partner':
 * @property string $user_id
 * @property string $name
 * @property string $notice
 * @property string $birthday
 *
 * The followings are the available model relations:
 * @property User $user
 * @property AttachPhoto $photos
 */
class UserPartner extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return UserPartner the static model class
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
		return 'user_partner';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id', 'required'),
			array('user_id', 'length', 'max'=>11),
			array('name', 'length', 'max'=>255),
			array('notice', 'length', 'max'=>1024),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('user_id, name, notice', 'safe', 'on'=>'search'),
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
			'user' => array(self::BELONGS_TO, 'User', 'user_id'),
            'photos' => array(self::HAS_MANY, 'AttachPhoto', 'entity_id', 'condition' => 'entity=:modelName', 'params' => array(':modelName' => get_class($this))),
        );
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'user_id' => 'User',
			'name' => 'Name',
			'notice' => 'Notice',
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

		$criteria->compare('user_id',$this->user_id,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('notice',$this->notice,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    public static function savePartner($user_id)
    {
        $model = self::model()->find('user_id='.$user_id);
        if (!isset($model)){
            $model = new UserPartner();
            $model->user_id = $user_id;
        }
        if (isset($_POST['User']['partner_name']))
            $model->name = $_POST['User']['partner_name'];
        if (isset($_POST['User']['partner_notice']))
            $model->notice = $_POST['User']['partner_notice'];
        if (!empty($model->name)){
            UserScores::checkProfileScores(Yii::app()->user->id, ScoreActions::ACTION_PROFILE_FAMILY);
        }

        $model->save();
    }

    public function getAge()
    {
        if ($this->birthday === null) return '';

        $date1 = new DateTime($this->birthday);
        $date2 = new DateTime(date('Y-m-d'));
        $interval = $date1->diff($date2);
        return $interval->y.' '.HDate::GenerateNoun(array('год', 'года', 'лет'), $interval->y);
    }

    public function getBDatePart($part)
    {
        if (empty($this->birthday))
            return '';
        return date($part, strtotime($this->birthday));
    }

    public function getRandomPhotoUrl()
    {
        if (count($this->photos) == 0)
            return '';

        $i = rand(0, count($this->photos)-1);
        return $this->photos[$i]->photo->getPreviewUrl(180, 180);
    }
}