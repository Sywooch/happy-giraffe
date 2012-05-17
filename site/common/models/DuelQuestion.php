<?php

/**
 * This is the model class for table "duel__question".
 *
 * The followings are the available columns in table 'duel__question':
 * @property string $id
 * @property string $text
 *
 * The followings are the available model relations:
 * @property DuelAnswer[] $duelAnswers
 */
class DuelQuestion extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return DuelQuestion the static model class
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
		return 'duel__question';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('text', 'required'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, text', 'safe', 'on'=>'search'),
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
			'answers' => array(self::HAS_MANY, 'DuelAnswer', 'question_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'text' => 'Text',
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
		$criteria->compare('text',$this->text,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    public static function getAvailable($user_id)
    {
        $criteria = new CDbCriteria(array(
            'select' => 't.*, count(answers.id) AS answersCount',
            'group' => 't.id',
            'having' => 'answersCount < 2',
            'with' => array(
                'answers' => array(
                    'with' => 'user',
                    'together' => true,
                ),
            ),
            'condition' => 'NOT EXISTS (SELECT * FROM duel__answer WHERE user_id = :user_id AND question_id = t.id)',
            'limit' => 3,
            'params' => array(
                ':user_id' => $user_id,
            ),
        ));

        return self::model()->findAll($criteria);
    }

    public static function getAnswered()
    {
        $criteria = new CDbCriteria(array(
            'select' => 't.*, count(' . DuelAnswer::model()->tableName() . '.id) AS answersCount',
            'group' => 't.id',
            'having' => 'answersCount = 2',
            'join' => 'LEFT JOIN duel__answer ON ' . self::model()->getTableAlias() . '.id = ' . DuelAnswer::model()->tableName() . '.question_id',
            'with' => array(
                'answers' => array(
                    'with' => 'user',
                    'together' => false,
                ),
            ),
            'order' => 'RAND()',
        ));

        return self::model()->find($criteria);
    }
}