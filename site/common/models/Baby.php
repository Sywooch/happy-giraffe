<?php

/**
 * This is the model class for table "user__users_babies".
 *
 * The followings are the available columns in table 'user__users_babies':
 * @property integer $id
 * @property integer $parent_id
 * @property integer $age_group
 * @property string $name
 * @property string $birthday
 * @property integer $sex
 * @property string $notice
 * @property string $type
 *
 * The followings are the available model relations:
 * @property VaccineDateVote[] $vaccineDateVotes
 * @property AttachPhoto $photos
 * @property int $photosCount
 */
class Baby extends HActiveRecord
{
    const TYPE_WAIT = 1;
    const TYPE_PLANNING = 2;

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function tableName()
    {
        return 'user__users_babies';
    }

    public function relations()
    {
        return array(
            'parent' => array(self::BELONGS_TO, 'User', 'id'),
            'photos' => array(self::HAS_MANY, 'AttachPhoto', 'entity_id', 'with' => 'photo', 'on' => '`photo`.`removed` = 0 AND entity = :modelName', 'params' => array(':modelName' => get_class($this))),
            'photosCount' => array(self::STAT, 'AttachPhoto', 'entity_id', 'condition' => 'entity =: modelName', 'params' => array(':modelName' => get_class($this))),
            'photo' => array(self::HAS_ONE, 'AttachPhoto', 'entity_id', 'with' => 'photo', 'on' => '`photo`.`removed` = 0 AND entity = :modelName', 'params' => array(':modelName' => get_class($this)), 'order' => CDbExpression('RAND()')),
        );
    }

    public function rules()
    {
        return array(
            array('parent_id', 'required'),
            array('name', 'required', 'on'=>'realBaby'),
            array('birthday', 'type', 'type' => 'date', 'message' => '{attribute}: is not a date!', 'dateFormat' => 'yyyy-MM-dd'),
            array('parent_id, age_group', 'numerical', 'integerOnly'=>true),
            array('sex', 'numerical', 'integerOnly' => true, 'min' => 0, 'max' => 2),
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

    /*public function getAge()
    {
        if ($this->birthday === null) return null;

        $date1 = new DateTime($this->birthday);
        $date2 = new DateTime(date('Y-m-d'));
        $interval = $date1->diff($date2);
        return $interval->y;
    }*/

    public function getTextAge($bold = true)
    {
        if ($this->birthday === null) return null;

        $date1 = new DateTime($this->birthday);
        $date2 = new DateTime(date('Y-m-d'));
        $interval = $date1->diff($date2);

        $years_text = ($bold?$interval->y.' ':$interval->y.' ').HDate::GenerateNoun(array('год', 'года', 'лет'), $interval->y);
        $month_text = ($bold?$interval->m.' ':$interval->m.' ').HDate::GenerateNoun(array('месяц', 'месяца', 'месяцев'), $interval->m);
        if ($interval->y == 0)
            return $month_text;
        if ($interval->y <= 3)
            return $years_text.' '.$month_text;
        return $years_text;
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

    public function getAge()
    {
        /*if ($this->birthday === null) return '';

        $date1 = new DateTime($this->birthday);
        $date2 = new DateTime(date('Y-m-d'));
        $interval = $date1->diff($date2);
        return $interval->y.' '.HDate::GenerateNoun(array('год', 'года', 'лет'), $interval->y);*/
        return $this->getTextAge();
    }

    public function getBDatePart($part)
    {
        if (empty($this->birthday))
            return '';
        return date($part, strtotime($this->birthday));
    }

    public function getRandomPhotoUrl()
    {
        if (count($this->photos) == 0)
            return '';

        $i = rand(0, count($this->photos)-1);
        return $this->photos[$i]->photo->getPreviewUrl(180, 180);
    }

    protected function afterSave()
    {
        parent::afterSave();

        if ($this->isNewRecord) {
            UserAction::model()->add($this->parent_id, UserAction::USER_ACTION_FAMILY_UPDATED, array('model' => $this));
            FriendEventManager::add(FriendEvent::TYPE_FAMILY_ADDED, array(
                'entity' => __CLASS__,
                'entity_id' => $this->id,
                'user_id' => $this->parent_id,
            ));
        }

        User::model()->UpdateUser($this->parent_id);
    }

    public function pregnancyPeriod()
    {
        if ($this->type != self::TYPE_WAIT)
            return false;

        $now = new DateTime();
        $conception = new DateTime($this->birthday);
        $conception->modify('-9 month');
        $interval = $now->diff($conception);
        return ceil($interval->days / 7);
    }
}