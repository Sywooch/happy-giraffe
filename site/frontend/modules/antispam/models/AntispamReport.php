<?php

/**
 * This is the model class for table "antispam__report".
 *
 * The followings are the available columns in table 'antispam__report':
 * @property string $id
 * @property string $user_id
 * @property string $created
 * @property string $updated
 * @property integer $status
 * @property integer $type
 * @property string $reason
 * @property string $moderator_id
 *
 * The followings are the available model relations:
 * @property User $user
 * @property User $moderator
 */
class AntispamReport extends CActiveRecord
{
    const STATUS_PENDING = 0;
    const STATUS_CONSIDERED = 1;
    const TYPE_LIMIT = 10;
    const TYPE_ABUSE = 11;

    protected $types = array(
        self::TYPE_LIMIT => 'AntispamReportLimit',
        self::TYPE_ABUSE => 'AntispamReportAbuse',
    );

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'antispam__report';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, type', 'required'),
			array('status, type', 'numerical', 'integerOnly'=>true),
			array('user_id, moderator_id', 'length', 'max'=>10),
			array('created, updated, reason', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, user_id, created, updated, status, type, reason, moderator_id', 'safe', 'on'=>'search'),
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
			'moderator' => array(self::BELONGS_TO, 'User', 'moderator_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'user_id' => 'User',
			'created' => 'Created',
			'updated' => 'Updated',
			'status' => 'Status',
			'type' => 'Type',
			'reason' => 'Reason',
			'moderator_id' => 'Moderator',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('user_id',$this->user_id,true);
		$criteria->compare('created',$this->created,true);
		$criteria->compare('updated',$this->updated,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('type',$this->type);
		$criteria->compare('reason',$this->reason,true);
		$criteria->compare('moderator_id',$this->moderator_id,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return AntispamReport the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    public function behaviors()
    {
        return array(
            'CTimestampBehavior' => array(
                'class' => 'zii.behaviors.CTimestampBehavior',
                'createAttribute' => 'created',
                'updateAttribute' => 'updated',
                'setUpdateOnCreate' => true,
            ),
            'withRelated' => array(
                'class' => 'site.common.extensions.wr.WithRelatedBehavior',
            ),
        );
    }

    protected function instantiate($attributes)
    {
        $class = $this->types[$attributes['type']];
        $model=new $class(null);
        return $model;
    }

    public function status($status)
    {
        $this->getDbCriteria()->mergeWith(array(
            'condition' => 'status = :status',
            'params' => array(':status' => $status),
        ));
        return $this;
    }

    public static function getDp()
    {
        return new CActiveDataProvider(self::model()->status(self::STATUS_PENDING), array(
            'criteria' => array(
                'order' => 'id DESC',
            ),
        ));
    }
}
