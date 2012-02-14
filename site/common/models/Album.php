<?php

/**
 * This is the model class for table "albums".
 *
 * The followings are the available columns in table 'albums':
 * @property string $id
 * @property integer $title
 * @property integer $description
 * @property string $user_id
 *
 * The followings are the available model relations:
 * @property User $user
 */
class Album extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Album the static model class
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
		return 'albums';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('title, user_id', 'required'),
            array('title', 'length', 'max' => 100),
            array('description', 'length', 'max' => 255),
			array('user_id', 'length', 'max'=>10),
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
            'photos' => array(self::HAS_MANY, 'AlbumPhoto', 'album_id'),
			'user' => array(self::BELONGS_TO, 'User', 'user_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'title' => 'Название',
			'description' => 'Описание',
			'user_id' => 'User',
		);
	}

    public function findByUser($user_id)
    {
        return new CActiveDataProvider($this, array(
            'criteria' => array(
                'condition' => 'user_id = :user_id',
                'params' => array(':user_id' => $user_id)
            ),
        ));
    }
}