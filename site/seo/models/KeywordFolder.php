<?php

/**
 * This is the model class for table "keywords__folders".
 *
 * The followings are the available columns in table 'keywords__folders':
 * @property string $id
 * @property string $user_id
 * @property string $name
 * @property integer $color
 * @property integer $type
 *
 * The followings are the available model relations:
 * @property SeoUser $user
 * @property Keyword[] $keywords
 */
class KeywordFolder extends HActiveRecord
{
    const TYPE_REGULAR = 0;
    const TYPE_FAVOURITES = 1;

    const COLOR_RED = 1;
    const COLOR_BLUE = 2;

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return KeywordFolder the static model class
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
		return 'keywords__folders';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, name', 'required'),
			array('color, type', 'numerical', 'integerOnly'=>true),
			array('user_id', 'length', 'max'=>11),
			array('name', 'length', 'max'=>100),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, user_id, name, color', 'safe', 'on'=>'search'),
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
			'keywords' => array(self::MANY_MANY, 'Keyword', 'keywords__folders_keywords(folder_id, keyword_id)'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'user_id' => 'User',
			'name' => 'Name',
			'color' => 'Color',
		);
	}

    public static function getFavourites()
    {
        $model = self::model()->findByAttributes(array(
            'user_id'=>Yii::app()->user->id,
            'type'=>self::TYPE_FAVOURITES
        ));

        if ($model !== null)
            return $model;
        $model = new self;
        $model->type = self::TYPE_FAVOURITES;
        $model->user_id = Yii::app()->user->id;
        $model->save();

        return $model;
    }
}