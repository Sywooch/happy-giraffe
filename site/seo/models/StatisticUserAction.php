<?php

/**
 * This is the model class for table "statistic__user_actions".
 *
 * The followings are the available columns in table 'statistic__user_actions':
 * @property string $id
 * @property string $user_id
 * @property integer $keyword_id
 * @property integer $action_id
 * @property string $created
 *
 * The followings are the available model relations:
 * @property SeoUser $user
 * @property Keyword $keyword
 */
class StatisticUserAction extends HActiveRecord
{
    const ACTION_ADD_TO_FOLDER = 1;
    const ACTION_ADD_TO_FAVOURITES = 2;
    const ACTION_REMOVE = 3;
    const ACTION_STRIKE_OUT = 4;

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return StatisticUserAction the static model class
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
		return 'statistic__user_actions';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, keyword_id, action_id', 'required'),
			array('keyword_id, action_id', 'numerical', 'integerOnly'=>true),
			array('user_id', 'length', 'max'=>11),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, user_id, keyword_id, action_id, created', 'safe', 'on'=>'search'),
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

    public static function add($keyword_id, $action_id){
        $model = new StatisticUserAction;
        $model->user_id = Yii::app()->user->id;
        $model->keyword_id = $keyword_id;
        $model->action_id = $action_id;
        $model->save();
    }
}