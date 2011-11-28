<?php

/**
 * This is the model class for table "bag_offer".
 *
 * The followings are the available columns in table 'bag_offer':
 * @property string $id
 * @property string $votes_pro
 * @property string $votes_con
 * @property string $item_id
 * @property string $user_id
 */
class BagOffer extends CActiveRecord
{
	public $vote;

	/**
	 * Returns the static model of the specified AR class.
	 * @return BagOffer the static model class
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
		return 'bag_offer';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('item_id, user_id', 'required'),
			array('item_id, user_id', 'numerical', 'integerOnly' => true),
			array('item_id, user_id', 'length', 'max' => 11),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, votes_pro, votes_con, item_id, user_id', 'safe', 'on'=>'search'),
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
			'item' => array(self::BELONGS_TO, 'BagItem', 'item_id'),
			'author' => array(self::BELONGS_TO, 'User', 'user_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'votes_pro' => 'Votes Pro',
			'votes_con' => 'Votes Con',
			'item_id' => 'Item',
			'user_id' => 'User',
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
		$criteria->compare('votes_pro',$this->votes_pro,true);
		$criteria->compare('votes_con',$this->votes_con,true);
		$criteria->compare('item_id',$this->item_id,true);
		$criteria->compare('user_id',$this->user_id,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function getOffers($user_id)
	{
		$criteria = new CDbCriteria(array(
			'select' => 't.*, bag_user_vote.vote as vote',
			'join' => 'LEFT JOIN bag_user_vote ON t.id = bag_user_vote.offer_id AND bag_user_vote.user_id = :user_id',
			'params' => array(':user_id' => $user_id),
			'with' => array('item', 'author'),
		));
		
		return new CActiveDataProvider(__CLASS__, array(
			'criteria' => $criteria,
		));
	}
	
	public function getProPercent()
	{
		return $this->totalVotes == 0 ? 0 : round(($this->votes_pro / $this->totalVotes) * 100, 2);
	}
	
	public function getConPercent()
	{
		return $this->totalVotes == 0 ? 0 : round(($this->votes_con / $this->totalVotes) * 100, 2);
	}
	
	public function getTotalVotes()
	{
		return $this->votes_pro + $this->votes_con;
	}
	
	public function vote($user_id, $vote)
	{
		$current_vote = $this->getCurrentVote($user_id);
		
		if ($current_vote === NULL)
		{
			//die('1');
			Yii::app()->db->createCommand()
				->insert('bag_user_vote', array(
					'offer_id' => $this->id,
					'user_id' => $user_id,
					'vote' => $vote,
				));
				
			Yii::app()->db->createCommand()
				->update($this->tableName(), array($this->columnByVote($vote) => new CDbExpression($this->columnByVote($vote) . ' + 1')), 'id = :offer_id', array(':offer_id' => $this->id));
		}
		elseif ($current_vote != $vote)
		{
			//die('2');
			Yii::app()->db->createCommand()
				->update('bag_user_vote', array('vote' => $vote), 'user_id = :user_id AND offer_id = :offer_id', array(
					':user_id' => $user_id,
					':offer_id' => $this->id,
				));

			Yii::app()->db->createCommand()
				->update($this->tableName(), array($this->columnByVote($vote) => new CDbExpression($this->columnByVote($vote) . ' + 1')), 'id = :offer_id', array(':offer_id' => $this->id));
		
			Yii::app()->db->createCommand()
				->update($this->tableName(), array($this->columnByVote($current_vote) => new CDbExpression($this->columnByVote($vote) . ' - 1')), 'id = :offer_id', array(':offer_id' => $this->id));
		}
		//die('3');
	}
	
	protected function columnByVote($vote)
	{
		$array = array(
			'0' => 'votes_con',
			'1' => 'votes_pro',
		);
		
		return $array[$vote];
	}
	
	public function getCurrentVote($user_id)
	{
		return Yii::app()->db->createCommand()
		    ->select('vote')
		    ->from($this->tableName())
		    ->leftJoin('bag_user_vote', 'bag_user_vote.user_id = :user_id', array(':offer_id' => $this->id, ':user_id' => $user_id))
		    ->where('offer_id = :offer_id', array(':offer_id' => $this->id))
		    ->queryScalar();
	}
}