<?php

/**
 * This is the model class for table "score__awards".
 *
 * The followings are the available columns in table 'score__awards':
 * @property string $id
 * @property string $title
 * @property string $description
 * @property integer $scores
 *
 * The followings are the available model relations:
 * @property User[] $users
 */
class ScoreAward extends HActiveRecord
{
    const TYPE_BLOGGER_WEEK = 1;
    const TYPE_BLOGGER_MONTH = 2;
    const TYPE_COMMENTATOR_WEEK = 3;
    const TYPE_COMMENTATOR_MONTH = 4;
    const TYPE_PHOTO = 5;
    const TYPE_TRAVEL = 6;
    const TYPE_FASHION = 7;
    const TYPE_MISTRESS = 8;
    const TYPE_WEDDING = 9;
    const TYPE_MASTER = 10;
    const TYPE_HOMEOWNER = 11;
    const TYPE_BEAUTY = 12;
    const TYPE_COOK = 13;
    const TYPE_JOKER = 14;
    const TYPE_DOCTOR = 15;
    const TYPE_HOUSEWIFE = 16;
    const TYPE_PSYCHO = 17;
    const TYPE_MOTHER = 18;
    const TYPE_AUTO = 19;
    const TYPE_PREGNANCY = 20;
    const TYPE_FLOWERS = 21;
    const TYPE_FRIEND = 22;
    const TYPE_DUEL = 23;
    const TYPE_SMILE = 24;


    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return ScoreAward the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'score__awards';
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
            array('scores', 'numerical', 'integerOnly' => true),
            array('title', 'length', 'max' => 255),
            array('description', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, title, description, scores', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        return array(
            'users' => array(self::MANY_MANY, 'User', 'score__users_awards(award_id, user_id)'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'title' => 'title',
            'description' => 'Description',
            'scores' => 'Scores',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search()
    {
        $criteria = new CDbCriteria;
        $criteria->compare('id', $this->id, true);
        $criteria->compare('title', $this->title, true);
        $criteria->compare('description', $this->description, true);
        $criteria->compare('scores', $this->scores);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Возвращает кол-во трофеев пользователя
     *
     * @param $user_id int id пользователя
     * @return int
     */
    public static function getAwardsCount($user_id)
    {
        return Yii::app()->db->createCommand()
            ->select('count(award_id)')
            ->from('score__users_awards')
            ->where('user_id = :user_id')
            ->queryScalar(array(':user_id' => $user_id));
    }
}
