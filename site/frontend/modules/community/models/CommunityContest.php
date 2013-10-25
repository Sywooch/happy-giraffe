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
 * @property string $rubric_id
 * @property integer $status
 *
 * The followings are the available model relations:
 * @property Community $forum
 * @property CommunityContestWork[] $contestWorks
 * @property int $contestWorksCount
 * @property CommunityRubric $rubric
 */
class CommunityContest extends HActiveRecord
{
    const STATUS_ACTIVE = 0;
    const STATUS_FINISHED = 1;

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
			array('description, rules, forum_id, rubric_id', 'required'),
            array('status', 'numerical', 'integerOnly'=>true),
			array('title', 'length', 'max'=>255),
			array('forum_id, rubric_id', 'length', 'max'=>11),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, title, description, rules, forum_id, rubric_id, status', 'safe', 'on'=>'search'),
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
            'rubric' => array(self::BELONGS_TO, 'CommunityRubric', 'rubric_id'),
			'forum' => array(self::BELONGS_TO, 'Community', 'forum_id'),
            'contestWorks' => array(self::HAS_MANY, 'CommunityContestWork', 'contest_id'),
            'contestWorksCount' => array(self::STAT, 'CommunityContestWork', 'contest_id'),
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
            'rubric_id' => 'Rubric',
            'status' => 'Status',
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
        $criteria->compare('rubric_id',$this->rubric_id,true);
        $criteria->compare('status',$this->status);

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

    public function getUrl()
    {
        return Yii::app()->createUrl('/community/contest/index', array('contestId' => $this->id));
    }

    public function getParticipateUrl()
    {
        return Yii::app()->user->isGuest ? '#login' : Yii::app()->createUrl('/blog/default/form', array('type' => 3, 'club_id' => $this->forum->club_id, 'contest_id' => $this->id));
    }

    public function getExternalParticipateUrl()
    {
        return Yii::app()->user->isGuest ? '#login' : Yii::app()->createUrl('/community/contest/index', array('contestId' => $this->id, 'takePart' => 1));
    }

    public function getContestWorks($sort)
    {
        return new CActiveDataProvider('CommunityContestWork', array(
            'criteria' => array(
                'with' => 'content',
                'order' => $sort == ContestController::SORT_CREATED ? 't.id DESC' : 't.rate DESC',
                'condition' => 'contest_id = :contest_id AND content.removed = 0',
                'params' => array(':contest_id' => $this->id),
            ),
        ));
    }

    public function getParticipants($limit, $order)
    {
        return CommunityContestWork::model()->findAll(array(
            'condition' => 'contest_id = :contest_id AND content.removed = 0',
            'params' => array(':contest_id' => $this->id),
            'order' => $order,
            'limit' => $limit,
            'with' => array(
                'content' => array(
                    'with' => 'author',
                ),
            ),
        ));
    }

    public function getLastParticipants($limit)
    {
        return $this->getParticipants($limit, 't.id DESC');
    }

    public function getTopParticipants($limit)
    {
        return $this->getParticipants($limit, 't.rate DESC');
    }

    public function getRandomParticipants($limit)
    {
        return $this->getParticipants($limit, new CDbExpression('RAND()'));
    }

    public function scopes()
    {
        return array(
            'active' => array(
//                'condition' => 'status = :active',
//                'params' => array(':active' => self::STATUS_ACTIVE),
            ),
        );
    }
}
