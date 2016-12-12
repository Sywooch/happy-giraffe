<?php

/**
 * This is the model class for table "antispam__report_abuse_data".
 *
 * The followings are the available columns in table 'antispam__report_abuse_data':
 * @property string $id
 * @property string $report_id
 * @property string $entity
 * @property string $entity_id
 *
 * The followings are the available model relations:
 * @property AntispamReport $report
 */
class AntispamReportAbuseData extends HActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'antispam__report_abuse_data';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('entity_id', 'required'),
			array('report_id, entity_id', 'length', 'max'=>11),
			array('entity', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, report_id, entity, entity_id', 'safe', 'on'=>'search'),
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
            'report' => array(self::BELONGS_TO, 'AntispamReport', 'report_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'report_id' => 'Report',
			'entity' => 'Entity',
			'entity_id' => 'Entity',
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
		$criteria->compare('report_id',$this->report_id,true);
		$criteria->compare('entity',$this->entity,true);
		$criteria->compare('entity_id',$this->entity_id,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return AntispamReportAbuseData the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    public function getIconClass()
    {
        switch ($this->entity) {
            case 'BlogContent':
            case 'CommunityContent':
                return 'blog';
            case 'AlbumPhoto':
                return 'photo';
            case 'Comment':
                return 'new';
            case 'MessagingMessage':
                return 'msg';
        }
    }

    public function getAnalysisUrl()
    {
        return Yii::app()->createUrl('/antispam/default/analysis', array('userId' => $this->report->user_id, 'entity' => AntispamCheck::getSpamEntity($this->entity)));
    }
}
