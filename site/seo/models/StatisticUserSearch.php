<?php

/**
 * This is the model class for table "statistic__user_search".
 *
 * The followings are the available columns in table 'statistic__user_search':
 * @property string $id
 * @property string $user_id
 * @property integer $keyword_id
 * @property string $created
 *
 * The followings are the available model relations:
 * @property SeoUser $user
 * @property Keyword $keyword
 */
class StatisticUserSearch extends HActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return StatisticUserSearch the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return CDbConnection database connection
	 */
	public function getDbConnection()
	{
		return Yii::app()->db_seo;
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'statistic__user_search';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, keyword_id', 'required'),
			array('keyword_id', 'numerical', 'integerOnly'=>true),
			array('user_id', 'length', 'max'=>11),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, user_id, keyword_id, created', 'safe', 'on'=>'search'),
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
			'user' => array(self::BELONGS_TO, 'SeoUser', 'user_id'),
			'keyword' => array(self::BELONGS_TO, 'Keyword', 'keyword_id'),
		);
	}

    public function behaviors()
    {
        return array(
            'CTimestampBehavior' => array(
                'class' => 'zii.behaviors.CTimestampBehavior',
                'createAttribute' => 'created',
                'updateAttribute' => null,
            ),
        );
    }

    public static function addKeyword($keyword_id)
    {
        $model = new StatisticUserSearch;
        $model->keyword_id = $keyword_id;
        $model->user_id = Yii::app()->user->id;
        $model->save();
    }
}