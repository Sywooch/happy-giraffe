<?php

/**
 * This is the model class for table "interest".
 *
 * The followings are the available columns in table 'interest':
 * @property string $id
 * @property string $name
 * @property string $category_id
 *
 * The followings are the available model relations:
 * @property InterestCategory $category
 * @property User[] $users
 */
class Interest extends HActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Interest the static model class
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
		return 'interest__interests';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('title, category_id', 'required'),
			array('title', 'length', 'max'=>255),
			array('category_id', 'length', 'max'=>2),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, title, category_id', 'safe', 'on'=>'search'),
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
			'category' => array(self::BELONGS_TO, 'InterestCategory', 'category_id'),
			'users' => array(self::MANY_MANY, 'User', 'interest__users_interests(interest_id, user_id)'),
            'usersCount' => array(self::STAT, 'User', 'interest__users_interests(interest_id, user_id)'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'title' => 'Name',
			'category_id' => 'Category',
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
		$criteria->compare('title',$this->title,true);
		$criteria->compare('category_id',$this->category_id,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    public static function findAllByUser($user_id)
    {
        $list = Yii::app()->db->createCommand('select interest_id from interest__users_interests where user_id = :user_id')
            ->bindParam(":user_id", $user_id, PDO::PARAM_INT)
            ->queryAll();
        $interests = array();
        foreach($list as $item)
        {
            $interests[$item['interest_id']] = $user_id;
        }
        return $interests;
    }

    public static function saveByUser($user_id, $interests)
    {
        $old_interests = self::findAllByUser($user_id);
        $command = Yii::app()->db->createCommand('delete from interest__users_interests where user_id = :user_id');
        $command->bindParam(":user_id", $user_id, PDO::PARAM_INT);
        $command->execute();

        if($interests)
        {
            foreach($interests as $interest_id => $value)
            {
                Yii::app()->db->createCommand()->insert('interest__users_interests', array(
                    'interest_id' => $interest_id,
                    'user_id' => $user_id,
                ));
                if (! array_key_exists($interest_id, $old_interests)) {
                    UserAction::model()->add($user_id, UserAction::USER_ACTION_INTERESTS_ADDED, array('id' => $interest_id));
                    FriendEventManager::add(FriendEvent::TYPE_INTERESTS_ADDED, array('id' => $interest_id, 'user_id' => $user_id));
                }
            }

            UserScores::checkProfileScores($user_id, ScoreAction::ACTION_PROFILE_INTERESTS);
            User::model()->UpdateUser($user_id);
            return true;
        }
        return false;
    }
}