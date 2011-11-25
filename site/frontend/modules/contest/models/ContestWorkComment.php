<?php

/**
 * This is the model class for table "{{contest_work_comment}}".
 *
 * The followings are the available columns in table '{{contest_work_comment}}':
 * @property string $comment_id
 * @property string $comment_user_id
 * @property string $comment_work_id
 * @property string $comment_text
 * @property integer $comment_status
 * @property string $comment_time
 * @property string $comment_answer
 *
 * rel
 * @property User $user
 * @property ContestWork $work
 *
 */
class ContestWorkComment extends CActiveRecord
{

	public function behaviors()
	{
		return array(
			'statuses' => array(
                'class' => 'ext.status.EStatusBehavior',
                'statusField' => 'comment_status',
                'statuses' => array(
					1 => Yii::t('models', 'Actived'),
					0 => Yii::t('models', 'Not actived'),
				),
            ),
		);
	}

	/**
	 * Returns the static model of the specified AR class.
	 * @return ContestWorkComment the static model class
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
		return '{{club_contest_work_comment}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('comment_text', 'required'),
			
			array('comment_status', 'numerical', 'integerOnly'=>true),
			array('comment_user_id, comment_work_id, comment_time', 'length', 'max'=>10),
			array('comment_text, comment_answer', 'safe'),

			array('comment_user_id', 'default', 'value' => Yii::app()->user->id),
			array('comment_status', 'default', 'value' => 1),
			array('comment_time', 'default', 'value' => time()),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('comment_id, comment_user_id, comment_work_id, comment_text, comment_status, comment_time, comment_answer', 'safe', 'on'=>'search'),
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
			'user' => array(self::BELONGS_TO, 'User', 'comment_user_id'),
			'work' => array(self::BELONGS_TO, 'ContestWork', 'comment_work_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'comment_id' => 'Comment',
			'comment_user_id' => 'Comment User',
			'comment_work_id' => 'Comment Work',
			'comment_text' => 'Comment Text',
			'comment_status' => 'Comment Status',
			'comment_time' => 'Comment Time',
			'comment_answer' => 'Comment Answer',
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

		$criteria->compare('comment_id',$this->comment_id,true);
		$criteria->compare('comment_user_id',$this->comment_user_id,true);
		$criteria->compare('comment_work_id',$this->comment_work_id,true);
		$criteria->compare('comment_text',$this->comment_text,true);
		$criteria->compare('comment_status',$this->comment_status);
		$criteria->compare('comment_time',$this->comment_time,true);
		$criteria->compare('comment_answer',$this->comment_answer,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}