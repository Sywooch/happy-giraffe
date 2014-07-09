<?php

/**
 * This is the model class for table "{{user_social_service}}".
 *
 * The followings are the available columns in table '{{user_social_service}}':
 * @property string $id
 * @property string $service
 * @property string $service_id
 * @property string $user_id
 */
class UserSocialService extends HActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return UserSocialService the static model class
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
		return 'user__social_services';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('service, service_id', 'required'),
			array('service, service_id', 'length', 'max'=>255),
			array('user_id', 'length', 'max'=>11),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, service, service_id, user_id', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'service' => 'Service',
			'service_id' => 'Service',
			'user_id' => 'User',
		);
	}

    public function findByUser($service_name, $user_id)
    {
        return UserSocialService::model()->findByAttributes(array(
                'service' => $service_name,
                'user_id' => $user_id,
            ));
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
		$criteria->compare('service',$this->service,true);
		$criteria->compare('service_id',$this->service_id,true);
		$criteria->compare('user_id',$this->user_id,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    public function getUrlString()
    {
        switch ($this->service) {
            case 'vkontakte':
                $url = 'http://vk.com/id' . $this->service_id;
                break;
            case 'facebook':
                $url = 'http://www.facebook.com/profile.php?id=' . $this->service_id;
                break;
            case 'odnoklassniki':
                $url = 'http://www.odnoklassniki.ru/profile/' . $this->service_id;
                break;
            case 'google_oauth':
                $url = 'https://plus.google.com/' . $this->service_id;
                break;
            default:
                $url = '';
        }

        return $url;
    }

    public function getNameString()
    {
        return (! empty($this->name)) ? $this->name : $this->getUrlString();
    }
}