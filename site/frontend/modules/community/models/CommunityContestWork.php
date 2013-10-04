<?php

/**
 * This is the model class for table "community__contest_works".
 *
 * The followings are the available columns in table 'community__contest_works':
 * @property string $id
 * @property string $contest_id
 * @property string $content_id
 * @property string $rate
 *
 * The followings are the available model relations:
 * @property CommunityContents $content
 * @property CommunityContests $contest
 */
class CommunityContestWork extends HActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'community__contest_works';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('contest_id', 'required'),
			array('contest_id, content_id, rate', 'length', 'max'=>11),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, contest_id, content_id, rate', 'safe', 'on'=>'search'),
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
			'content' => array(self::BELONGS_TO, 'CommunityContent', 'content_id'),
			'contest' => array(self::BELONGS_TO, 'CommunityContest', 'contest_id'),
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
			'content_id' => 'Content',
			'rate' => 'Rate',
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
		$criteria->compare('contest_id',$this->contest_id,true);
		$criteria->compare('content_id',$this->content_id,true);
		$criteria->compare('rate',$this->rate,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return CommunityContestWork the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    public function getUrl()
    {
        return $this->content->getUrl();
    }

    public function getOtherParticipants($limit)
    {
        return CommunityContestWork::model()->findAll(array(
            'limit' => $limit,
            'condition' => 't.id != :currentId',
            'params' => array(':currentId' => $this->id),
            'order' => new CDbExpression('RAND()'),
            'with' => array(
                'content' => array(
                    'with' => 'author',
                ),
            ),
        ));
    }
}
