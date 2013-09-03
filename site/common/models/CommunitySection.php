<?php

/**
 * This is the model class for table "community__sections".
 *
 * The followings are the available columns in table 'community__sections':
 * @property string $id
 * @property string $title
 *
 * The followings are the available model relations:
 * @property CommunityClub[] $clubs
 */
class CommunitySection extends HActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return CommunitySection the static model class
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
		return 'community__sections';
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
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, title', 'safe', 'on'=>'search'),
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
			'clubs' => array(self::HAS_MANY, 'CommunityClub', 'section_id'),
		);
	}

    public function getUrl()
    {
        return Yii::app()->createUrl('community/default/section', array(
            'section_id' => $this->id,
        ));
    }
}