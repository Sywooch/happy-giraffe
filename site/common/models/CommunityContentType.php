<?php

/**
 * This is the model class for table "{{community_content_type}}".
 *
 * The followings are the available columns in table '{{community_content_type}}':
 * @property string $id
 * @property string $title
 * @property string $slug
 */
class CommunityContentType extends HActiveRecord
{
    const TYPE_POST = 1;
    const TYPE_VIDEO = 2;
    const TYPE_PHOTO = 3;
    const TYPE_MORNING = 4;
    const TYPE_STATUS = 5;

	/**
	 * Returns the static model of the specified AR class.
	 * @return CommunityContentType the static model class
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
		return 'community__content_types';
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
			array('id, title', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array(
			'rubrics' => array(self::HAS_MANY, 'CommunityRubric', 'community_id'),
		);
	}
}