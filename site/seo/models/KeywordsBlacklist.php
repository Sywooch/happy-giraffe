<?php

/**
 * This is the model class for table "keywords__blacklist".
 *
 * The followings are the available columns in table 'keywords__blacklist':
 * @property integer $keyword_id
 * @property integer $user_id
 *
 * The followings are the available model relations:
 * @property Keyword $keyword
 * @property User $user
 */
class KeywordsBlacklist extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return KeywordsBlacklist the static model class
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
		return 'keywords__blacklist';
	}

    public function getDbConnection(){
        return Yii::app()->db_seo;
    }

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
			array('keyword_id, user_id', 'required'),
			array('keyword_id, user_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('keyword_id', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array(
			'keyword' => array(self::BELONGS_TO, 'Keyword', 'keyword_id'),
			'user' => array(self::BELONGS_TO, 'Users', 'user_id'),
		);
	}
}