<?php

/**
 * This is the model class for table "{{contest_work}}".
 *
 * The followings are the available columns in table '{{contest_work}}':
 * @property string $work_id
 * @property string $work_user_id
 * @property string $work_contest_id
 * @property string $work_title
 * @property string $work_text
 * @property string $work_image
 * @property string $work_time
 * @property string $work_rate
 * @property integer $work_status
 *
 * rel
 * @property User $user
 * @property Contest $contest
 * @property array[int]ContestWorkComment $comments
 * @property int $commentCount
 *
 */
class ContestWork extends CActiveRecord
{
	public function behaviors()
	{
		return array(
			'behavior_ufiles' => array(
				'class' => 'ext.ufile.UFileBehavior',
				'fileAttributes'=>array(
					'work_image'=>array(
						'fileName'=>'upload/contest/*/<date>-{work_id}-<name>.<ext>',
						'fileItems'=>array(
							'thumb' => array(
								'fileHandler' => array('FileHandler', 'run'),
								'resize' => array(
									'width' => 170,
									'height' => 180,
								),
							),
							'big' => array(
								'fileHandler' => array('FileHandler', 'run'),
								'resize' => array(
									'width' => 700,
									'height' => 9999,
									'master' => Image::WIDTH,
								),
							),
							'original' => array(
								'fileHandler' => array('FileHandler', 'run'),
							),
						)
					),
				),
			),
//			'attribute_set' => array(
//				'class'=>'attribute.AttributeSetBehavior',
//				'table'=>'shop_product_attribute_set',
//				'attribute'=>'product_attribute_set_id',
//			),
			'getUrl' => array(
				'class' => 'ext.geturl.EGetUrlBehavior',
				'route' => 'product/view',
				'dataField' => array(
					'id' => 'product_id',
					'title' => 'product_slug',
				),
			),
			'statuses' => array(
				'class' => 'ext.status.EStatusBehavior',
				// Поле зарезервированное для статуса
				'statusField' => 'product_status',
				'statuses' => array(
					0 => 'deleted',
					1 => 'published',
					2 => 'view only',
				),
			),
		);
	}

	/**
	 * Returns the static model of the specified AR class.
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
		return '{{club_contest_work}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('work_title, work_image', 'required'),
			array('work_status, work_rate', 'numerical', 'integerOnly'=>true),
			array('work_user_id, work_contest_id', 'length', 'max'=>10),
			array('work_title, work_image', 'length', 'max'=>250),
			array('work_text', 'safe'),

			array('work_time', 'default', 'value' => time()),
			array('work_status', 'default', 'value' => 1),
			array('work_rate', 'default', 'value' => 0),
			array('work_user_id', 'default', 'value' => Yii::app()->user->id),
//----------------------SImageUploadBehavior------------------------
			array('work_image', 'file', 'types'=>'jpg, gif, png'), //Опционально
			array('work_image', 'unsafe'), //Обязательно
//----------------------SImageUploadBehavior------------------------
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('work_id, work_user_id, work_contest_id, work_title, work_text, work_image, work_time, work_rate, work_status', 'safe', 'on'=>'search'),
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
			'author' => array(self::BELONGS_TO, 'User', 'work_user_id'),
			'contest' => array(self::BELONGS_TO, 'Contest', 'work_contest_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'work_id' => 'Work',
			'work_user_id' => 'Work User',
			'work_contest_id' => 'Work Contest',
			'work_title' => 'Work Title',
			'work_text' => 'Work Text',
			'work_image' => 'Work Image',
			'work_time' => 'Work Time',
			'work_rate' => 'Work Rate',
			'work_status' => 'Work Status',
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

		$criteria->compare('work_id',$this->work_id,true);
		$criteria->compare('work_user_id',$this->work_user_id,true);
		$criteria->compare('work_contest_id',$this->work_contest_id,true);
		$criteria->compare('work_title',$this->work_title,true);
		$criteria->compare('work_text',$this->work_text,true);
		$criteria->compare('work_image',$this->work_image,true);
		$criteria->compare('work_time',$this->work_time,true);
		$criteria->compare('work_rate',$this->work_rate,true);
		$criteria->compare('work_status',$this->work_status);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	protected function beforeSave()
	{
		if($this->getIsNewRecord())
		{
			$command = Yii::app()->db->createCommand();

			$contestUser = new ContestUser;

			$contestUser = $command
				->update($contestUser->tableName(), array(
					'user_work_count'=>new CDbExpression('user_work_count+1'),
				), 'user_user_id=:user_user_id AND user_contest_id=:user_contest_id',array(
					':user_user_id'=>Yii::app()->user->id,
					':user_contest_id'=>$this->work_contest_id,
				));
		}
		return parent::beforeSave();
	}
	
	public function get($contest_id, $sort)
	{
		return new CActiveDataProvider('ContestWork', array(
			'criteria' => array(
				'condition' => 'work_contest_id=:contest_id',
				'params' => array(':contest_id' => $contest_id),
				'order' => $sort . ' DESC',
			),
			'pagination' => array(
				'pageSize' => 15,
			),
		));
	}
}