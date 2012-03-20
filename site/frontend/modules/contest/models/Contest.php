<?php

/**
 * This is the model class for table "{{contest}}".
 *
 * The followings are the available columns in table '{{contest}}':
 * @property string $contest_id
 * @property string $contest_title
 * @property string $contest_text
 * @property string $contest_image
 * @property string $contest_from_time
 * @property string $contest_till_time
 * @property integer $contest_status
 * @property string $contest_time
 * @property string $contest_user_id
 * @property string $contest_stop_reason
 *
 * getter
 * @property integer $workCount
 * @property integer $userCount
 *
 * behaviors
 * @property string $url
 * @property array[int]string $statuses
 *
 * relations
 * @property array[int]ContestPrize $prizes
 * @property array[int]ContestUser $users
 * @property array[int]ContestWinner $winners
 * @property array[int]ContestWork $works
 * @property User $user
 *
 */
class Contest extends CActiveRecord
{

	public function behaviors()
	{
		return array(
			'getUrl' => array(
				'class' => 'ext.geturl.EGetUrlBehavior',
				'route' => '/contest/contest/view',
				'dataField' => array(
					'id' => 'contest_id',
//					'title' => 'item_slug',
				),
			),
			'statuses' => array(
                'class' => 'ext.status.EStatusBehavior',
                'statusField' => 'contest_status',
                'statuses' => array(
					0 => Yii::t('models', 'Not actived'),
					1 => Yii::t('models', 'Actived'),
					2 => Yii::t('models', 'Stopped'),
				),
            ),
			'SImageUploadBehavior' => array(
				'class' => 'ext.SImageUploadBehavior.SImageUploadBehavior',
				'fileAttribute' => 'contest_image',
				'nameAttribute' => 'contest_title',
				'webPath' => 'www/club/',
				'folder' => 'upload/contest',
				'mkdir' => true,
				'useDateForName' => true,
				'useUrlForName' => false,
				'imagesRequired' => array(
					'thumb' => array('width' => 100, 'height' => 46, 'folder' => 'thumb'),
					'middle' => array('width' => 200, 'height' => 93, 'folder' => 'middle'),
					'big' => array('width' => 400, 'height' => 186, 'folder' => 'big'),
					'full' => array('width' => 790, 'height' => 372, 'folder' => 'full', 'smartResize' => false),
				),
			),
		);
	}
	/**
	 * Returns the static model of the specified AR class.
	 * @return Contest the static model class
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
		return '{{club_contest}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('contest_status', 'numerical', 'integerOnly'=>true),
			array('contest_title', 'length', 'max'=>250),
			array('contest_time, contest_user_id', 'length', 'max'=>10),
			array('contest_text, contest_stop_reason', 'safe'),
			array('contest_from_time, contest_till_time', 'date', 'format'=>'dd.MM.yyyy'),

			array('contest_time', 'default', 'value' => time()),
			array('contest_user_id', 'default', 'value' => Yii::app()->user->id),

//----------------------SImageUploadBehavior------------------------
			array('contest_image', 'file', 'types'=>'jpg, gif, png','allowEmpty'=>true), //Опционально
			array('contest_image', 'unsafe'), //Обязательно
//----------------------SImageUploadBehavior------------------------
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('contest_id, contest_title, contest_text, contest_image, contest_from_time, contest_till_time, contest_status, contest_time, contest_user_id', 'safe', 'on'=>'search'),
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
			'prizes' => array(self::HAS_MANY, 'ContestPrize', 'prize_contest_id'),
			'users' => array(self::HAS_MANY, 'ContestUser', 'user_contest_id'),
			'works' => array(self::HAS_MANY, 'ContestWork', 'contest_id'),
			'user' => array(self::BELONGS_TO, 'User', 'contest_user_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'contest_id' => 'Contest',
			'contest_title' => 'Contest Title',
			'contest_text' => 'Contest Text',
			'contest_image' => 'Contest Image',
			'contest_from_time' => 'Contest From Time',
			'contest_till_time' => 'Contest Till Time',
			'contest_status' => 'Contest Status',
			'contest_time' => 'Contest Time',
			'contest_user_id' => 'Contest User',
			'contest_stop_reason' => 'Contest Stop Reason',
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

		$criteria->compare('contest_id',$this->contest_id,true);
		$criteria->compare('contest_title',$this->contest_title,true);
		$criteria->compare('contest_text',$this->contest_text,true);
		$criteria->compare('contest_image',$this->contest_image,true);
		$criteria->compare('contest_from_time',$this->contest_from_time,true);
		$criteria->compare('contest_till_time',$this->contest_till_time,true);
		$criteria->compare('contest_status',$this->contest_status);
		$criteria->compare('contest_time',$this->contest_time,true);
		$criteria->compare('contest_user_id',$this->contest_user_id,true);
		$criteria->compare('contest_stop_reason',$this->contest_stop_reason,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    public function getIsStatement()
    {
        if(Yii::app()->user->isGuest)
            return false;
        if(ContestWork::model()->findByAttributes(array('user_id' => Yii::app()->user->id, 'contest_id' => $this->primaryKey)))
            return false;
        if(time() > strtotime($this->contest_till_time))
            return false;
        return true;
    }

	public function getUserCount()
	{
		$contestUser = new ContestUser;
		return Yii::app()->db->createCommand()
			->select('COUNT(user_id)')
			->from($contestUser->tableName())
			->where('user_contest_id=:user_contest_id', array(
				':user_contest_id'=>$this->contest_id,
			))
			->queryScalar();
	}

	public function getWorkCount()
	{
		$contestWork = new ContestWork;
		return Yii::app()->db->createCommand()
			->select('COUNT(id)')
			->from($contestWork->tableName())
			->where('contest_id=:contest_id', array(
				':contest_id'=>$this->contest_id,
			))
			->queryScalar();
	}

	protected function beforeSave()
	{
		$this->contest_from_time = preg_replace('/(\d{2})\.(\d{2})\.(\d{4})/', '$3-$2-$1', $this->contest_from_time);
		$this->contest_till_time = preg_replace('/(\d{2})\.(\d{2})\.(\d{4})/', '$3-$2-$1', $this->contest_till_time);

		return parent::beforeSave();
	}

	protected function afterSave()
	{
		$this->contest_from_time = preg_replace('/(\d{4})-(\d{2})-(\d{2})/', '$3.$2.$1', $this->contest_from_time);
		$this->contest_till_time = preg_replace('/(\d{4})-(\d{2})-(\d{2})/', '$3.$2.$1', $this->contest_till_time);

		parent::afterSave();
	}

	protected function afterFind()
	{
		$this->contest_from_time = preg_replace('/(\d{4})-(\d{2})-(\d{2})/', '$3.$2.$1', $this->contest_from_time);
		$this->contest_till_time = preg_replace('/(\d{4})-(\d{2})-(\d{2})/', '$3.$2.$1', $this->contest_till_time);

		return parent::afterFind();
	}
}