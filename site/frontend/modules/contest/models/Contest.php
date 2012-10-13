<?php

/**
 * This is the model class for table "{{contest}}".
 *
 * The followings are the available columns in table '{{contest}}':
 * @property string $id
 * @property string $title
 * @property string $text
 * @property string $image
 * @property string $from_time
 * @property string $till_time
 * @property integer $status
 * @property string $time
 * @property string $user_id
 * @property string $stop_reason
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
class Contest extends HActiveRecord
{
    const STATEMENT_GUEST = 0;
    const STATEMENT_STEPS = 1;

	public function behaviors()
	{
		return array(
			'getUrl' => array(
				'class' => 'ext.geturl.EGetUrlBehavior',
				'route' => '/contest/contest/view',
				'dataField' => array(
					'id' => 'id',
//					'title' => 'item_slug',
				),
			),
			'statuses' => array(
                'class' => 'ext.status.EStatusBehavior',
                'statusField' => 'status',
                'statuses' => array(
					0 => Yii::t('models', 'Not actived'),
					1 => Yii::t('models', 'Actived'),
					2 => Yii::t('models', 'Stopped'),
				),
            ),
			'SImageUploadBehavior' => array(
				'class' => 'ext.SImageUploadBehavior.SImageUploadBehavior',
				'fileAttribute' => 'image',
				'nameAttribute' => 'title',
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
		return 'contest__contests';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('status', 'numerical', 'integerOnly'=>true),
			array('title', 'length', 'max'=>250),
			array('time, user_id', 'length', 'max'=>10),
			array('text, stop_reason', 'safe'),
			array('from_time, till_time', 'date', 'format'=>'dd.MM.yyyy'),

			array('time', 'default', 'value' => time()),
			array('user_id', 'default', 'value' => Yii::app()->user->id),

//----------------------SImageUploadBehavior------------------------
			array('image', 'file', 'types'=>'jpg, gif, png','allowEmpty'=>true), //Опционально
			array('image', 'unsafe'), //Обязательно
//----------------------SImageUploadBehavior------------------------
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, title, text, image, from_time, till_time, status, time, user_id', 'safe', 'on'=>'search'),
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
			'prizes' => array(self::HAS_MANY, 'ContestPrize', 'contest_id'),
			'works' => array(self::HAS_MANY, 'ContestWork', 'contest_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'Contest',
			'title' => 'Contest Title',
			'text' => 'Contest Text',
			'image' => 'Contest Image',
			'from_time' => 'Contest From Time',
			'till_time' => 'Contest Till Time',
			'status' => 'Contest Status',
			'time' => 'Contest Time',
			'user_id' => 'Contest User',
			'stop_reason' => 'Contest Stop Reason',
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
		$criteria->compare('text',$this->text,true);
		$criteria->compare('image',$this->image,true);
		$criteria->compare('from_time',$this->from_time,true);
		$criteria->compare('till_time',$this->till_time,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('time',$this->time,true);
		$criteria->compare('user_id',$this->user_id,true);
		$criteria->compare('stop_reason',$this->stop_reason,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    public function getIsStatement()
    {
        if (Yii::app()->user->isGuest)
            return self::STATEMENT_GUEST;
        if (Yii::app()->user->model->getScores()->full != 2)
            return self::STATEMENT_STEPS;
        if (ContestWork::model()->findByAttributes(array('user_id' => Yii::app()->user->id, 'contest_id' => $this->id)))
            return false;
        if (time() > strtotime($this->till_time))
            return false;
        return true;
    }

	public function getWorkCount()
	{
		$contestWork = new ContestWork;
		return Yii::app()->db->createCommand()
			->select('COUNT(id)')
			->from($contestWork->tableName())
			->where('contest_id=:contest_id', array(
				':contest_id'=>$this->id,
			))
			->queryScalar();
	}

	protected function beforeSave()
	{
		$this->from_time = preg_replace('/(\d{2})\.(\d{2})\.(\d{4})/', '$3-$2-$1', $this->from_time);
		$this->till_time = preg_replace('/(\d{2})\.(\d{2})\.(\d{4})/', '$3-$2-$1', $this->till_time);

		return parent::beforeSave();
	}

	protected function afterSave()
	{
		$this->from_time = preg_replace('/(\d{4})-(\d{2})-(\d{2})/', '$3.$2.$1', $this->from_time);
		$this->till_time = preg_replace('/(\d{4})-(\d{2})-(\d{2})/', '$3.$2.$1', $this->till_time);

		parent::afterSave();
	}

	protected function afterFind()
	{
		$this->from_time = preg_replace('/(\d{4})-(\d{2})-(\d{2})/', '$3.$2.$1', $this->from_time);
		$this->till_time = preg_replace('/(\d{4})-(\d{2})-(\d{2})/', '$3.$2.$1', $this->till_time);

		return parent::afterFind();
	}

    public function getPhotoCollection()
    {
        $criteria = new CDbCriteria(array(
            'with' => array(
                'photo' => array(
                    'with' => array(
                        'photo' => array(
                            'alias' => 'albumphoto',
                            'with' => array(
                                'author' => array(
                                    'with' => 'avatar',
                                ),
                            ),
                        ),
                    ),
                ),
            ),
            'condition' => 'contest_id = :contest_id',
            'params' => array(':contest_id' => $this->id),
        ));

        $criteria->order = 't.' . Yii::app()->request->getQuery('sort') . ' DESC';

        $works = ContestWork::model()->findAll($criteria);

        $photos = array();
        foreach ($works as $w) {
            $p = $w->photo->photo;
            $p->w_title = $w->title;
            $photos[] = $p;
        }

        return array(
            'title' => 'Фотоальбом ' . CHtml::link($this->title, $this->url),
            'photos' => $photos,
        );
    }
}