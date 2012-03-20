<?php

/**
 * This is the model class for table "club_contest_work".
 *
 * The followings are the available columns in table 'club_contest_work':
 * @property string $id
 * @property string $contest_id
 * @property string $user_id
 * @property integer $title
 * @property string $created
 * @property integer $rate
 *
 * The followings are the available model relations:
 * @property User $user
 * @property ClubContest $contest
 */
class ContestWork extends CActiveRecord
{
    public $file;

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ContestWork the static model class
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
		return 'club_contest_work';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('contest_id, user_id, title', 'required'),
			array('id, contest_id, user_id, rate', 'length', 'max'=>10),
            array('file', 'required', 'on' => 'upload'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, contest_id, user_id, title, created', 'safe', 'on'=>'search'),
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
			'author' => array(self::BELONGS_TO, 'User', 'user_id'),
			'contest' => array(self::BELONGS_TO, 'Contest', 'contest_id'),
            'photo' => array(self::HAS_ONE, 'AttachPhoto', 'entity_id', 'condition' => '`photo`.`entity` = :entity', 'params' => array(':entity' => get_class($this)))
		);
	}

    public function behaviors()
    {
        return array(
            'CTimestampBehavior' => array(
                'class' => 'zii.behaviors.CTimestampBehavior',
                'createAttribute' => 'created',
                'updateAttribute' => null,
            )
        );
    }

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'contest_id' => 'Contest',
			'user_id' => 'User',
			'title' => 'Title',
			'created' => 'Created',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search($sort = false)
	{
		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('contest_id',$this->contest_id,true);
		$criteria->compare('user_id',$this->user_id,true);
		$criteria->compare('title',$this->title);
		$criteria->compare('created',$this->created,true);

        if($sort)
        {
            $criteria->order = $sort . ' desc';
        }

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    public function getNeighboringWorks()
    {
        $prev = Yii::app()->db->createCommand('select id from ' . $this->tableName() . ' where contest_id = ' . $this->contest_id . ' and id < ' . $this->id . ' limit 1')->queryRow();
        $next = Yii::app()->db->createCommand('select id from ' . $this->tableName() . ' where contest_id = ' . $this->contest_id . ' and id > ' . $this->id . ' limit 1')->queryRow();
        return array(
            'prev' => $prev ? $prev['id'] : false,
            'next' => $next ? $next['id'] : false
        );
    }
}