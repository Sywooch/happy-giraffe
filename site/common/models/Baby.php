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
 * @property string $photo
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
            array('name, photo', 'length', 'max'=>255),
            array('notice', 'length', 'max'=>1024),
            array('birthday', 'safe'),
            array('photo', 'unsafe'),
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

    public function behaviors()
    {
        return array(
            'behavior_ufiles' => array(
                'class' => 'site.frontend.extensions.ufile.UFileBehavior',
                'fileAttributes' => array(
                    'photo' => array(
                        'fileName' => 'upload/baby/*/<date>-{id}-<name>.<ext>',
                        'fileItems' => array(
                            'ava' => array(
                                'fileHandler' => array('FileHandler', 'run'),
                                'accurate_resize' => array(
                                    'width' => 76,
                                    'height' => 79,
                                ),
                            ),
                            'mini' => array(
                                'fileHandler' => array('FileHandler', 'run'),
                                'accurate_resize' => array(
                                    'width' => 38,
                                    'height' => 37,
                                ),
                            ),
                            'original' => array(
                                'fileHandler' => array('FileHandler', 'run'),
                            ),
                        )
                    ),
                ),
            ),
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

    public function getAgeString()
    {
        $age = $this->getAge();

        return $age.' '. $this->GetWordForm($age, array('год','года','лет'));
    }

    public function getAgeImageUrl()
    {
        if ($this->birthday === null)
            return '/images/age_02.gif';
        $age = $this->getAge();
        if ($age <= 1)
            return '/images/age_02.gif';
        if ($age <= 3)
            return '/images/age_03.gif';
        if ($age <= 7)
            return '/images/age_04.gif';

        return '/images/age_05.gif';
    }

    public function getGenderString(){
        if ($this->sex = 0)
            return 'Моя дочь';
        return 'Мой сын';
    }

    public function getImageUrl()
    {
        $ava = $this->photo->getUrl('ava');
        if (!empty($ava))
            return $ava;
        else
            return $this->getAgeImageUrl();
    }

    public function getBirthdayDates()
    {
        return null;
    }

    public function GetWordForm($n, $forms)
    {
        if ($n>0)
        {
            $n = abs($n) % 100;
            $n1 = $n % 10;
            if ($n > 10 && $n < 20) return $forms[2];
            if ($n1 > 1 && $n1 < 5) return $forms[1];
            if ($n1 == 1) return $forms[0];
        }
        return $forms[2];
    }
}