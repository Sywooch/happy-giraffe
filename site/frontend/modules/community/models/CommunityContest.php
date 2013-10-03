<?php

/**
 * This is the model class for table "community__contests".
 *
 * The followings are the available columns in table 'community__contests':
 * @property string $id
 * @property string $title
 * @property string $description
 * @property string $rules
 * @property string $forum_id
 *
 * The followings are the available model relations:
 * @property CommunityContestWorks[] $communityContestWorks
 * @property CommunityForum $forum
 */
class CommunityContest extends HActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'community__contests';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('description, rules, forum_id', 'required'),
			array('title', 'length', 'max'=>255),
			array('forum_id', 'length', 'max'=>11),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, title, description, rules, forum_id', 'safe', 'on'=>'search'),
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
			'communityContestWorks' => array(self::HAS_MANY, 'CommunityContestWorks', 'contest_id'),
			'forum' => array(self::BELONGS_TO, 'Community', 'forum_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'title' => 'Title',
			'description' => 'Description',
			'rules' => 'Rules',
			'forum_id' => 'Forum',
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
		$criteria->compare('title',$this->title,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('rules',$this->rules,true);
		$criteria->compare('forum_id',$this->forum_id,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return CommunityContest the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    public function getParticipateUrl()
    {
        return Yii::app()->createUrl('/blog/default/form', array('type' => 3, 'club_id' => $this->forum->club_id, 'contest_id' => $this->id));
    }

    public function getContestWorks()
    {
        return new CActiveDataProvider('CommunityContestWork', array(
            'criteria' => array(
                'with' => 'content',
                'condition' => 'contest_id = :contest_id',
                'params' => array(':contest_id' => $this->id),
            ),
        ));
    }
}
