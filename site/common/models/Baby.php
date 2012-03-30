<?php

/**
 * This is the model class for table "user_baby".
 *
 * The followings are the available columns in table 'user_baby':
 * @property integer $id
 * @property integer $parent_id
 * @property integer $age_group
 * @property string $name
 * @property string $birthday
 * @property integer $sex
 * @property string $notice
 *
 * The followings are the available model relations:
 * @property VaccineDateVote[] $vaccineDateVotes
 */
class Baby extends CActiveRecord
{
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function tableName()
    {
        return '{{user_baby}}';
    }

    public function relations()
    {
        return array(
            'parent' => array(self::BELONGS_TO, 'User', 'id'),
        );
    }

    public function rules()
    {
        return array(
            array('name, sex, birthday, parent_id', 'required'),
            array('birthday', 'type', 'type' => 'date', 'message' => '{attribute}: is not a date!', 'dateFormat' => 'yyyy-MM-dd'),
            array('parent_id, age_group', 'numerical', 'integerOnly'=>true),
            array('sex', 'numerical', 'integerOnly' => true, 'min' => 0, 'max' => 1),
            array('name', 'length', 'max'=>255),
            array('notice', 'length', 'max'=>1024),
            array('birthday', 'safe'),
        );
    }

    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'parent_id' => 'Родитель',
            'age_group' => 'Возрастная группа',
            'name' => 'Имя',
            'birthday' => 'День рождения',
            'sex' => 'Пол',
        );
    }

    public function getAge()
    {
        if ($this->birthday === null) return null;

        $date1 = new DateTime($this->birthday);
        $date2 = new DateTime(date('Y-m-d'));
        $interval = $date1->diff($date2);
        return $interval->y;
    }

    public function getTextAge($bold = true)
    {
        if ($this->birthday === null) return null;

        $date1 = new DateTime($this->birthday);
        $date2 = new DateTime(date('Y-m-d'));
        $interval = $date1->diff($date2);
        if ($interval->y == 0)
            return ($bold?'<b>'.$interval->m.'</b> ':$interval->m.' ').HDate::GenerateNoun(array('месяц', 'месяца', 'месяцев'), $interval->m);
        return ($bold?'<b>'.$interval->y.'</b> ':$interval->y.' ').HDate::GenerateNoun(array('год', 'года', 'лет'), $interval->y);
    }

    public function getAgeImageUrl()
    {
        /*if ($this->birthday === null)
            return '/images/age_02.gif';
        $age = $this->getAge();
        if ($age <= 1)
            return '/images/age_02.gif';
        if ($age <= 3)
            return '/images/age_03.gif';
        if ($age <= 7)
            return '/images/age_04.gif';

        return '/images/age_05.gif';*/
        return '';
    }

    public function getGenderString(){
        if ($this->sex == 1)
            return 'Мой сын';
        return 'Моя дочь';
    }

    public function getBirthdayDates()
    {
        return null;
    }
}