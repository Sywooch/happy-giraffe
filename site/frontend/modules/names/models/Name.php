<?php

/**
 * This is the model class for table "name".
 *
 * The followings are the available columns in table 'name':
 * @property string $id
 * @property string $name
 * @property integer $gender
 * @property string $translate
 * @property string $origin
 * @property string $description
 * @property string $name_group_id
 * @property string $options
 * @property string $sweet
 * @property string $middle_names
 * @property integer $likes
 * @property string $saints
 * @property string $slug
 *
 * The followings are the available model relations:
 * @property NameGroup $nameGroup
 * @property NameMiddle[] $nameMiddles
 * @property NameOption[] $nameOptions
 * @property NameSweet[] $nameSweets
 * @property NameFamous[] $nameFamouses
 * @property NameSaintDate[] $nameSaintDates
 * @property NameStats $nameStats
 * @property User[] $users
 */
class Name extends CActiveRecord
{
    const GENDER_MAN = 1;
    const GENDER_WOMAN = 2;

    const SCENARIO_EDIT_NAME = 1;

    /**
     * Returns the static model of the specified AR class.
     * @return Name the static model class
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
        return 'name';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name, gender', 'required'),
            array('gender, likes', 'numerical', 'integerOnly' => true),
            array('name', 'length', 'max' => 30),
            array('translate, options, sweet', 'length', 'max' => 512),
            array('origin, saints', 'length', 'max' => 2048),
            array('name_group_id', 'length', 'max' => 10),
            array('middle_names', 'length', 'max' => 1024),
            array('description', 'safe'),
            array('slug', 'site.frontend.extensions.translit.ETranslitFilter', 'translitAttribute' => 'name', 'on' => self::SCENARIO_EDIT_NAME),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, name, gender, translate, description, saints, origin, name_group_id, options, sweet, middle_names, likes', 'safe', 'on' => 'search'),
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
//            'nameGroup' => array(self::BELONGS_TO, 'NameGroup', 'name_group_id'),
            'nameFamouses' => array(self::HAS_MANY, 'NameFamous', 'name_id'),
            'nameSaintDates' => array(self::HAS_MANY, 'NameSaintDate', 'name_id'),
            'nameStats' => array(self::HAS_MANY, 'NameStats', 'name_id'),
            'users' => array(self::MANY_MANY, 'User', 'name_likes(name_id, user_id)'),
            'nameMiddles' => array(self::HAS_MANY, 'NameMiddle', 'name_id'),
            'nameOptions' => array(self::HAS_MANY, 'NameOption', 'name_id'),
            'nameSweets' => array(self::HAS_MANY, 'NameSweet', 'name_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'name' => 'Имя',
            'gender' => 'Пол',
            'translate' => 'перевод, значение',
            'origin' => 'Происхождение',
            'description'=>'Характеристика',
            'name_group_id' => 'Языковая группа',
            'options' => 'Варианты',
            'sweet' => 'Ласковые обращения',
            'middle_names' => 'Подходящие отчества',
            'likes' => 'Нравится',
            'saints'=>'Христианские святые с этим именем',
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

        $criteria = new CDbCriteria;

        $criteria->order = 'name';
        $criteria->compare('id', $this->id, true);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('gender', $this->gender);
        $criteria->compare('translate', $this->translate, true);
        $criteria->compare('origin', $this->origin, true);
        $criteria->compare('name_group_id', $this->name_group_id, true);
        $criteria->compare('options', $this->options, true);
        $criteria->compare('sweet', $this->sweet, true);
        $criteria->compare('middle_names', $this->middle_names, true);
        $criteria->compare('likes', $this->likes);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function behaviors()
    {
        return array(
            'ManyToManyBehavior'
        );
    }

    public function GetShort($attribute){
        $len = 80;
        if (strlen($this->getAttribute($attribute)) > $len){
            echo substr($this->getAttribute($attribute), 0, $len).'...';
        }else
            echo $this->getAttribute($attribute);
    }

    public function GenderText(){
        if ($this->gender == 1) echo  'мужской';
        if ($this->gender == 2) echo  'женский';
    }

    public function Top10Man()
    {
        return self::findAll(array(
            'condition' => 'gender=' . self::GENDER_MAN,
            'order' => 'likes desc',
            'limit' => 10
        ));
    }

    public function Top10Woman()
    {
        return self::findAll(array(
            'condition' => 'gender=' . self::GENDER_WOMAN,
            'order' => 'likes desc',
            'limit' => 10
        ));
    }

    /**
     * @static
     * @param $month
     * @param $gender
     * @return Array
     */
    public static function GetSaintMonthArray($month, $gender)
    {
        $models = self::GetSaintNames($month, $gender);
        $result = array();

        for ($i = 1; $i < 32; $i++) {
            foreach ($models as $model) {
                foreach ($model->nameSaintDates as $saintDate)
                    if ($saintDate->day == $i) {
                        if (isset($result[$saintDate->day]))
                            $result[$saintDate->day][] = $model;
                        else
                            $result[$saintDate->day] = array($model);
                        break;
                    }
            }
        }

        return $result;
    }

    /**
     * @static
     * @param $month
     * @param $gender
     * @return Name[]
     */
    public static function GetSaintNames($month, $gender)
    {
        if ($gender != 1 && $gender != 2)
            $models = Name::model()->with(array(
                'nameSaintDates' => array('order' => 'day, name')
            ))->findAll('nameSaintDates.month=' . $month);
        else
            $models = Name::model()->with(array(
                'nameSaintDates' => array('order' => 'day, name')
            ))->findAll('nameSaintDates.month=' . $month . ' AND gender=' . $gender);

        return $models;
    }

    public function GetLikes($user_id)
    {
        $data = Yii::app()->db->createCommand()
            ->select(array('id', 'name', 'gender', 'translate', 'slug'))
            ->from('name')
            ->join('name_likes', 'name.id = name_likes.name_id AND name_likes.user_id = ' . $user_id)
            ->order('name')
            ->queryAll();

        return $data;
    }

    public static function GetLikeIds()
    {
        if (Yii::app()->user->isGuest)
            return array();
        $user_id = Yii::app()->user->id;
        $data = Yii::app()->db->createCommand()
            ->select('name_id')
            ->from('name_likes')
            ->where('user_id = ' . $user_id)
            ->queryColumn();

        return $data;
    }

    public static function GetLikesCount($user_id)
    {
        $data = Yii::app()->db->createCommand()
            ->select('count(name_id)')
            ->from('name_likes')
            ->where('user_id = ' . $user_id)
            ->queryScalar();

        return $data;
    }

    public function GetFirstLetter(){
        return substr($this->name, 0, 2);
    }

    public function like($user_id)
    {
        $current_vote = $this->isUserLike($user_id);

        if ($current_vote === FALSE) {
            Yii::app()->db->createCommand()
                ->insert('name_likes', array(
                'name_id' => $this->id,
                'user_id' => $user_id,
            ));

            $this->likes++;
//            Yii::app()->db->createCommand()
//                ->update($this->tableName(), array('likes' => new CDbExpression('likes + 1')), 'id = :name_id', array(':name_id' => $this->id));
        }
        else
        {
            Yii::app()->db->createCommand()
                ->delete('name_likes', 'user_id = :user_id AND name_id = :name_id', array(
                ':user_id' => $user_id,
                ':name_id' => $this->id,
            ));

//            Yii::app()->db->createCommand()
//                ->update($this->tableName(), array('likes' => new CDbExpression('likes - 1')), 'id = :name_id', array(':name_id' => $this->id));
            $this->likes--;
        }

        return $this->update(array('likes'));
    }

    public function isUserLike($user_id)
    {
        $vote = Yii::app()->db->createCommand()
            ->select('name_id')
            ->from('name_likes')
            ->where('name_id = :name_id AND user_id = :user_id', array(':name_id' => $this->id, ':user_id' => $user_id))
            ->queryScalar();

        return ($vote === FALSE) ? false : true;
    }

    public function initOptionsSweetMiddles()
    {
        $this->sweet = '';
        foreach ($this->nameSweets as $name) {
            $this->sweet.=$name->value.', ';
        }
        $this->sweet = rtrim($this->sweet, ', ');

        $this->options = '';
        foreach ($this->nameOptions as $name) {
            $this->options.=$name->value.', ';
        }
        $this->options = rtrim($this->options, ', ');

        $this->middle_names = '';
        foreach ($this->nameMiddles as $name) {
            $this->middle_names.=$name->value.', ';
        }
        $this->middle_names = rtrim($this->middle_names, ', ');

        return parent::afterFind();
    }
}