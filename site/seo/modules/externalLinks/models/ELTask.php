<?php

/**
 * This is the model class for table "externallinks__tasks".
 *
 * The followings are the available columns in table 'externallinks__tasks':
 * @property string $id
 * @property string $site_id
 * @property integer $type
 * @property string $user_id
 * @property string $created
 * @property string $start_date
 * @property string $closed
 *
 * The followings are the available model relations:
 * @property SeoUser $user
 * @property ELSite $site
 */
class ELTask extends HActiveRecord
{
    const TYPE_REGISTER = 1;
    const TYPE_COMMENT = 2;
    const TYPE_POST_LINK = 3;

    const MINIMUM_COMMENTS = 1;
    const LINK_PROBABILITY = 50;

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ELTask the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return CDbConnection database connection
	 */
	public function getDbConnection()
	{
		return Yii::app()->db_seo;
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'externallinks__tasks';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('site_id, type, start_date', 'required'),
			array('type', 'numerical', 'integerOnly'=>true),
			array('site_id, user_id', 'length', 'max'=>11),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, site_id, type, user_id, created, closed', 'safe', 'on'=>'search'),
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
			'user' => array(self::BELONGS_TO, 'SeoUser', 'user_id'),
			'site' => array(self::BELONGS_TO, 'ELSite', 'site_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'site_id' => 'Site',
			'type' => 'Type',
			'user_id' => 'User',
			'created' => 'Created',
			'closed' => 'Closed',
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
		$criteria->compare('site_id',$this->site_id,true);
		$criteria->compare('type',$this->type);
		$criteria->compare('user_id',$this->user_id,true);
		$criteria->compare('created',$this->created,true);
		$criteria->compare('closed',$this->closed,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    public function behaviors()
    {
        return array(
            'CTimestampBehavior' => array(
                'class' => 'zii.behaviors.CTimestampBehavior',
                'createAttribute' => 'created',
                'updateAttribute' => null,
            ),
        );
    }

    /**
     * Create task for register forum
     *
     * @param $site_id int
     */
    public static function createRegisterTask($site_id)
    {
        $task = new ELTask();
        $task->type = ELTask::TYPE_REGISTER;
        $task->site_id = $site_id;
        $task->start_date = date("Y-m-d");
        if (!$task->save())
            var_dump($task->getErrors());
    }

    /**
     * Create comment task
     *
     * @param $date string
     */
    public function createCommentTask($date)
    {
        $task = new ELTask();
        $task->type = ELTask::TYPE_COMMENT;
        $task->start_date = $date;
        $task->site_id = $this->site_id;
        $task->save();
    }

    /**
     * Create link task
     *
     * @param $date string
     */
    public function createLinkTask($date)
    {
        $task = new ELTask();
        $task->type = ELTask::TYPE_POST_LINK;
        $task->start_date = $date;
        $task->site_id = $this->site_id;
        $task->save();
    }

    public function closeTask()
    {
        if ($this->type == self::TYPE_REGISTER){
            //create comment task instantly
            $this->createCommentTask(date("Y-m-d"));
        }elseif($this->type == self::TYPE_COMMENT){
            $comments_count = self::getCommentsCount($this->site_id);
            if ($comments_count > self::MINIMUM_COMMENTS){
                if (rand(0, 100) > self::LINK_PROBABILITY)
                    $this->createCommentTask(strtotime('+1 week'));
                else
                    $this->createLinkTask(strtotime('+1 week'));
            }else{
                $this->createCommentTask(strtotime('+1 day'));
            }
        }

        $this->closed = date("Y-m-d H:i:s");
        $this->user_id = Yii::app()->user->id;
        $this->save();
    }

    public static function getCommentsCount($site_id)
    {
        $criteria = new CDbCriteria;
        $criteria->condition = 'closed IS NOT NULL';
        $criteria->compare('site_id', $site_id);
        $criteria->compare('type', self::TYPE_COMMENT);

        return ELTask::model()->count($criteria);
    }

    /**
     * @return ELTask
     */
    public static function getNextTask()
    {
        //check register first
        $criteria = new CDbCriteria;
        $criteria->condition = 'closed IS NULL AND start_date >= :start_date';
        $criteria->params = array(':start_date'=>date("Y-m-d"));
        $criteria->compare('type', self::TYPE_REGISTER);

        $reg_task = ELTask::model()->find($criteria);

        if ($reg_task !== null)
            return $reg_task;

        $criteria = new CDbCriteria;
        $criteria->params = array(':start_date'=>date("Y-m-d"));
        $criteria->condition = 'closed IS NULL AND start_date >= :start_date';

        return ELTask::model()->find($criteria);
    }

    public static function showTaskCount()
    {
        $criteria = new CDbCriteria;
        $criteria->condition = 'closed IS NULL AND start_date >= :start_date';
        $criteria->params = array(':start_date'=>date("Y-m-d"));
        $criteria->compare('type', self::TYPE_REGISTER);

        $reg_task_count = ELTask::model()->count($criteria);

        $criteria->condition = 'closed IS NULL AND start_date >= :start_date AND type > 1';
        $criteria->params = array(':start_date'=>date("Y-m-d"));

        $tasks_count = ELTask::model()->count($criteria);

        return $reg_task_count*2 + $tasks_count - 1;
    }
}