<?php

/**
 * This is the model class for table "seo__task".
 *
 * The followings are the available columns in table 'seo__task':
 * @property string $id
 * @property string $keyword_group_id
 * @property string $user_id
 * @property integer $type
 * @property integer $status
 * @property string $created
 *
 * The followings are the available model relations:
 * @property KeywordGroup $keywordGroup
 */
class SeoTask extends CActiveRecord
{
    const STATUS_NEW = 0;
    const STATUS_READY = 1;
    const STATUS_TAKEN = 2;
    const STATUS_EXECUTED = 3;
    const STATUS_CLOSED = 4;

    const TYPE_MODER = 1;
    const TYPE_EDITOR = 2;

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return SeoTask the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    public function getDbConnection(){
        return Yii::app()->db_seo;
    }

    public function tableName(){
        return 'happy_giraffe_seo.task';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('keyword_group_id', 'required'),
			array('type, status', 'numerical', 'integerOnly'=>true),
			array('keyword_group_id, user_id', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, keyword_group_id, user_id, type, status, created', 'safe', 'on'=>'search'),
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
			'keywordGroup' => array(self::BELONGS_TO, 'KeywordGroup', 'keyword_group_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'keyword_group_id' => 'Keyword Group',
			'user_id' => 'User',
			'type' => 'Type',
			'status' => 'Status',
			'created' => 'Created',
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
		$criteria->compare('keyword_group_id',$this->keyword_group_id,true);
		$criteria->compare('user_id',$this->user_id,true);
		$criteria->compare('type',$this->type);
		$criteria->compare('status',$this->status);
		$criteria->compare('created',$this->created,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    public function beforeSave()
    {
        if ($this->isNewRecord)
            $this->created = date("Y-m-d");

        return parent::beforeSave();
    }

    public function getText()
    {
        $res = '';
        foreach($this->keywordGroup->keywords as $key)
            $res .= $key->name.', ';

        return trim($res, ', ');
    }
}