<?php

/**
 * This is the model class for table "{{community}}".
 *
 * The followings are the available columns in table '{{community}}':
 * @property string $id
 * @property string $name
 * @property string $pic
 * @property string $position
 */
class Community extends CActiveRecord
{
    const USERS_COMMUNITY = 999999;
	private $_typeCounts = null;

	public function getCount($type_id = null)
	{
		if ($this->_typeCounts === null)
		{
			$raw = Yii::app()->db->createCommand()
				->select('type_id, count(*)')
				->from('club_community_content c')
				->join('club_community_rubric r', 'r.id=c.rubric_id')
				->where('r.community_id = :community_id AND c.removed = 0', array(':community_id' => $this->id))
				->group('c.type_id')
				->queryAll();
				
			$this->_typeCounts['total'] = 0;
			foreach ($raw as $r)
			{
				$this->_typeCounts[$r['type_id']] = $r['count(*)'];
				$this->_typeCounts['total'] += $r['count(*)'];
			}
		}

        if ($type_id == null)
        {
            return $this->_typeCounts['total'];
        }
        elseif (isset($this->_typeCounts[$type_id]))
        {
            return $this->_typeCounts[$type_id];
        }
        else
        {
            return 0;
        }
	}

	/**
	 * Returns the static model of the specified AR class.
	 * @return Community the static model class
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
		return '{{club_community}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, pic', 'required'),
			array('name, pic', 'length', 'max'=>255),
            array('position', 'numerical'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, pic', 'safe', 'on'=>'search'),
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
			'rubrics' => array(self::HAS_MANY, 'CommunityRubric', 'community_id'),
			'users' => array(self::MANY_MANY, 'User', 'user_via_community(user_id, community_id)'),
		);
	}

    public function defaultScope()
    {
        return array(
            'order' => 'position asc',
        );
    }

    public function scopes()
    {
        return array(
            'public' => array(
                'condition' => 'id != 999999',
            ),
        );
    }

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Name',
			'pic' => 'Pic',
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
		$criteria->compare('name',$this->name,true);
		$criteria->compare('pic',$this->pic,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function behaviors(){
		return array('ESaveRelatedBehavior' => array(
			'class' => 'ESaveRelatedBehavior')
		);
	}

    public function getUrl()
    {
        return Yii::app()->createUrl('community/list', array(
            'community_id' => $this->id,
        ));
    }

    public function getLast()
    {
        return CommunityContent::model()->full()->findAll(array(
            'limit' => 10,
            'order' => 'created DESC',
            'condition' => 'community.id = :community_id',
            'params' => array(':community_id' => $this->id),
        ));
    }
}