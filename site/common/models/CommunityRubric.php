<?php

/**
 * This is the model class for table "{{community__rubrics}}".
 *
 * The followings are the available columns in table '{{community__rubrics}}':
 * @property string $id
 * @property string $title
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
				->from('community__contents c')
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
		return 'community__rubrics';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('title', 'required'),
			array('title', 'length', 'max'=>255),
            array('community_id', 'exist', 'attributeName' => 'id', 'className' => 'Community'),
            array('user_id', 'exist', 'attributeName' => 'id', 'className' => 'User'),
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
            'user' => array(self::BELONGS_TO, 'User', 'user_id'),
			'contents' => array(self::HAS_MANY, 'CommunityContent', 'rubric_id'),
            'contentsCount' => array(self::STAT, 'CommunityContent', 'rubric_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'title' => 'Name',
			'community_id' => 'Community',
		);
	}

    public function getUrl()
    {
        return Yii::app()->createUrl('community/list', array(
            'community_id' => $this->community_id,
            'rubric_id' => $this->id,
        ));
    }
}