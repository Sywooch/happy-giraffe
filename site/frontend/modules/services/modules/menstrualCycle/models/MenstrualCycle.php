<?php

/**
 * This is the model class for table "menstrual_cycle".
 *
 * The followings are the available columns in table 'menstrual_cycle':
 * @property integer $id
 * @property integer $cycle
 * @property integer $menstruation
 * @property integer $safety_sex
 * @property integer $ovulation_probable
 * @property integer $ovulation_most_probable
 * @property integer $ovulation_can
 * @property integer $pms
 */
class MenstrualCycle extends HActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @return MenstrualCycle the static model class
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
        return 'menstrual_cycle__cycles';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('cycle, menstruation, safety_sex, ovulation_probable, ovulation_most_probable, ovulation_can, pms', 'required'),
            array('cycle, menstruation, safety_sex, ovulation_probable, ovulation_most_probable, ovulation_can, pms', 'numerical', 'integerOnly' => true),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, cycle, menstruation, safety_sex, ovulation_probable, ovulation_most_probable, ovulation_can, pms', 'safe', 'on' => 'search'),
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
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'cycle' => 'Cycle',
            'menstruation' => 'Menstruation',
            'safety_sex' => 'Safety Sex',
            'ovulation_probable' => 'Ovulation Probable',
            'ovulation_most_probable' => 'Ovulation Most Probable',
            'ovulation_can' => 'Ovulation Can',
            'pms' => 'Pms',
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

        $criteria->compare('id', $this->id);
        $criteria->compare('cycle', $this->cycle);
        $criteria->compare('menstruation', $this->menstruation);
        $criteria->compare('safety_sex', $this->safety_sex);
        $criteria->compare('ovulation_probable', $this->ovulation_probable);
        $criteria->compare('ovulation_most_probable', $this->ovulation_most_probable);
        $criteria->compare('ovulation_can', $this->ovulation_can);
        $criteria->compare('pms', $this->pms);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Get period brief name on current date
     *
     * @param $last_menstruation_start_date
     * @param $day
     * @param $month
     * @param $year
     * @return string
     */
    public function GetPeriod($last_menstruation_start_date, $day, $month, $year)
    {
        $current_date = strtotime($year . '-' . $month . '-' . $day);
        if ($current_date < $last_menstruation_start_date)
            return '';

        $cycle_day = round(($current_date - $last_menstruation_start_date) / 86400) % $this->cycle + 1;

        if ($cycle_day == 1)
            return 'mens';
        elseif ($cycle_day <= $this->menstruation)
            return 'mens';
        elseif ($cycle_day <= $this->menstruation + $this->safety_sex)
            return 'fsex';
        elseif ($cycle_day <= $this->menstruation + $this->safety_sex + $this->ovulation_probable)
            return 'mbov';
        elseif ($cycle_day <= $this->menstruation + $this->safety_sex + $this->ovulation_probable
            + $this->ovulation_most_probable
        )
            return 'fov';
        elseif ($cycle_day <= $this->menstruation + $this->safety_sex + $this->ovulation_probable
            + $this->ovulation_most_probable + $this->ovulation_can
        )
            return 'mbov';
        elseif ($cycle_day <= $this->menstruation + $this->safety_sex + $this->ovulation_probable
            + $this->ovulation_most_probable + $this->ovulation_can + $this->pms
        )
            return 'pfsex';
        else
            return 'pms';
    }

    /**
     * Get period brief name on current date
     *
     * @param $last_menstruation_start_date
     * @param $day
     * @param $month
     * @param $year
     * @return string
     */
    public function GetBabyGender($last_menstruation_start_date, $day, $month, $year)
    {
        $current_date = strtotime($year . '-' . $month . '-' . $day);
        if ($current_date < $last_menstruation_start_date)
            return '';

        $cycle_day = round(($current_date - $last_menstruation_start_date) / 86400) % $this->cycle + 1;
        $ovulation_day = $this->menstruation + $this->safety_sex + $this->ovulation_probable;

        if ($cycle_day > ($ovulation_day - 6) && $cycle_day < ($ovulation_day - 1))
            return 2;
        elseif ($cycle_day > ($ovulation_day - 2) && $cycle_day <= $ovulation_day)
            return 1;
        elseif ($cycle_day > $ovulation_day && $cycle_day <= ($ovulation_day+2))
            return 3;
        else
            return 0;
    }

    /**
     * Save user cycle
     *
     * @param $date
     * @return mixed
     */
    public function SaveUserCycle($date)
    {
        if (Yii::app()->user->isGuest)
            return;

        $user_id = Yii::app()->user->id;
        $user_cycle = self::GetUserCycle($user_id);

        if ($user_cycle === NULL) {
            Yii::app()->db->createCommand()
                ->insert('menstrual_cycle__user_cycles',
                array(
                    'user_id' => $user_id,
                    'date' => date("Y-m-d", $date),
                    'cycle' => $this->cycle,
                    'menstruation' => $this->menstruation,
                ));
        }
        elseif ($user_cycle['cycle'] != $this->cycle || $user_cycle['date'] != date("Y-m-d", $date) || $user_cycle['menstruation'] != $this->menstruation)
        {
            Yii::app()->db->createCommand()
                ->update('menstrual_cycle__user_cycles',
                array(
                    'date' => date("Y-m-d", $date),
                    'cycle' => $this->cycle,
                    'menstruation' => $this->menstruation
                ),
                'user_id = :user_id',
                array(
                    ':user_id' => $user_id,
                ));
        }
    }

    /**
     * Get saved user cycle data
     *
     * @static
     * @param $user_id
     * @return array|null
     */
    public static function GetUserCycle($user_id)
    {
        $user_cycle = Yii::app()->db->createCommand()
            ->select('*')
            ->from('menstrual_cycle__user_cycles')
            ->where('user_id = :user_id', array(':user_id' => $user_id))
            ->queryRow();

        return ($user_cycle === FALSE) ? null : $user_cycle;
    }
}