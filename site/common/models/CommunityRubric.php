<?php

/**
 * This is the model class for table "{{community_rubric}}".
 *
 * The followings are the available columns in table '{{community_rubric}}':
 * @property string $id
 * @property string $name
 * @property string $community_id
 */
class CommunityRubric extends CActiveRecord
{
	private $_typeCounts = null;
	
	public function getCount($type_id = null)
	{
		if ($this->_typeCounts === null)
		{
			$raw = Yii::app()->db->createCommand()
				->select('type_id, count(*)')
				->from('club_community_content c')
				->where('c.rubric_id = :rubric_id', array(':rubric_id' => $this->id))
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
	 * @return CommunityRubric the static model class
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
		return '{{club_community_rubric}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, community_id', 'required'),
			array('name', 'length', 'max'=>255),
			array('community_id', 'length', 'max'=>11),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, community_id', 'safe', 'on'=>'search'),
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
			'community' => array(self::BELONGS_TO, 'Community', 'community_id'),
			'contents' => array(self::HAS_MANY, 'CommunityContent', 'rubric_id'),
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
			'community_id' => 'Community',
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
		$criteria->compare('community_id',$this->community_id,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}