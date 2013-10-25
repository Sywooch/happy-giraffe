<?php

/**
 * This is the model class for table "vaccine_date".
 *
 * The followings are the available columns in table 'vaccine_date':
 * @property integer $id
 * @property integer $vaccine_id
 * @property string $time_from
 * @property string $time_to
 * @property integer $adult
 * @property integer $interval
 * @property integer $every_period
 * @property string $age_text
 * @property integer $vaccination_type
 * @property integer $vote_decline
 * @property integer $vote_agree
 * @property integer $vote_did
 * @property string $comment
 *
 * The followings are the available model relations:
 * @property VaccineDisease[] $diseases
 * @property Vaccine $vaccine
 */
class VaccineDate extends HActiveRecord
{
    const INTERVAL_HOUR = 1;
    const INTERVAL_DAY = 2;
    const INTERVAL_MONTH = 3;
    const INTERVAL_YEAR = 4;

    const VOTE_EMPTY = 0;
    const VOTE_DECLINE = 0;
    const VOTE_AGREE = 1;
    const VOTE_DID = 2;

    /**
     * @var int
     */
    public $time_in_hours_from;
    /**
     * @var int
     */
    public $time_in_hours_to;
    /**
     * @var string
     */
    public $age;
    /**
     * @var string
     */
    public $recommendDate;

    public $vaccine_type_names = array(
        '0' => '',
        '1' => 'вакцинация',
        '2' => 'ревакцинация',
        '3' => 'первая вакцинация',
        '4' => 'вторая вакцинация',
        '5' => 'третья вакцинация',
        '6' => 'четвертая вакцинация',
        '7' => 'пятая вакцинация',
        '8' => 'первая ревакцинация',
        '9' => 'вторая ревакцинация',
        '10' => 'третья ревакцинация',
    );

    /**
     * Returns the static model of the specified AR class.
     * @return VaccineDate the static model class
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
        return 'vaccine__dates';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('vaccine_id, time_from, interval, vaccination_type, vote_decline, vote_agree, vote_did', 'required'),
            array('vaccine_id, adult, interval, every_period, vaccination_type, vote_decline, vote_agree, vote_did', 'numerical', 'integerOnly' => true),
            array('time_from, time_to', 'length', 'max' => 4),
            array('age_text, comment', 'length', 'max' => 256),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, vaccine_id, time_from, time_to, adult, interval, every_period, age_text, vaccination_type, vote_decline, vote_agree, vote_did, comment', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        return array(
            'vaccine' => array(self::BELONGS_TO, 'Vaccine', 'vaccine_id'),
            'diseases' => array(self::MANY_MANY, 'VaccineDisease', 'vaccine__dates_diseases(vaccine_date_id, vaccine_disease_id)'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'vaccine_id' => 'Вакцина',
            'time_from' => 'Начало',
            'time_to' => 'Конец(если есть)',
            'adult' => 'Взрослым',
            'interval' => 'Интервал времени',
            'every_period' => 'Каждые n периодов',
            'age_text' => 'Возраст - свободный текст',
            'vaccination_type' => 'Тип вакцинации',
            'vote_decline' => 'Голосов против',
            'vote_agree' => 'Голосов за',
            'vote_did' => 'Уже сделали',
            'comment' => 'Примечание'
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
        $criteria->compare('vaccine_id', $this->vaccine_id);
        $criteria->compare('time_from', $this->time_from, true);
        $criteria->compare('time_to', $this->time_to, true);
        $criteria->compare('adult', $this->adult);
        $criteria->compare('interval', $this->interval);
        $criteria->compare('every_period', $this->every_period);
        $criteria->compare('age_text', $this->age_text, true);
        $criteria->compare('vaccination_type', $this->vaccination_type);
        $criteria->compare('vote_decline', $this->vote_decline);
        $criteria->compare('vote_agree', $this->vote_agree);
        $criteria->compare('vote_did', $this->vote_did);
        $criteria->compare('comment', $this->comment);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function behaviors()
    {
        return array(
            'ManyToManyBehavior',
            'VoteBehavior' => array(
                'class' => 'VoteBehavior',
                'vote_attributes' => array(
                    '0' => 'vote_decline',
                    '1' => 'vote_agree',
                    '2' => 'vote_did',
                )),
        );
    }

    //****************************************************************************************************/
    /************************************** Form data to show user ***************************************/
    /*****************************************************************************************************/

    /**
     * @return int FROM TIME in hours (need for sorting)
     */
    public function GetFirstTimeSpanInHours()
    {
        if ($this->adult == '1')
            return 18 * 365 * 24;
        return $this->GetTimeSpanInHours($this->time_from);
    }

    /**
     * @return int TO TIME in hours (need for sorting)
     */
    public function GetLastTimeSpanInHours()
    {
        return $this->GetTimeSpanInHours($this->time_to);
    }

    /**
     * @param $timeSpan
     * @return int
     */
    public function GetTimeSpanInHours($timeSpan)
    {
        if ($this->interval == self::INTERVAL_HOUR)
            return $timeSpan;
        if ($this->interval == self::INTERVAL_DAY)
            return $timeSpan * 24;
        if ($this->interval == self::INTERVAL_MONTH)
            return $timeSpan * 24 * 31;
        if ($this->interval == self::INTERVAL_YEAR)
            return $timeSpan * 24 * 365;

        return 0;
    }

    /**
     * Get date as string when vaccine recommended period start for user interface
     *
     * @param int $date timestamp
     * @return string
     */
    public function GetFromDate($date)
    {
        return $this->GetDate($this->time_from, $date);
    }

    /**
     * Get date as string when vaccine recommended period ends for user interface
     *
     * @param int $date timestamp
     * @return string
     */
    public function GetToDate($date)
    {
        return $this->GetDate($this->time_to, $date);
    }

    /**
     * Get date as string when vaccine recommended period ends or start for user interface
     *
     * @param int $time
     * @param int $date timestamp
     * @return string
     */
    public function GetDate($time, $date)
    {
        //if for adults
        if ($this->adult == '1')
            return HDate::russian_date(strtotime('+ 18 years', $date));
        if ($time == '0') {
            return HDate::russian_date($date);
        }

        //if number is not integer
        if (strpos($time, ',') !== false)
            $time = str_replace(',', '.', $time);
        if (strpos($time, '.') !== false) {
            if ($this->interval == self::INTERVAL_HOUR)
                return HDate::russian_date(strtotime('+ ' . round($time * 60) . ' minutes', $date));
            if ($this->interval == self::INTERVAL_DAY)
                return HDate::russian_date(strtotime('+ ' . round($time * 24) . ' hours', $date));
            if ($this->interval == self::INTERVAL_MONTH)
                return HDate::russian_date(strtotime('+ ' . round($time * 30, 4) . ' days', $date));
            if ($this->interval == self::INTERVAL_YEAR)
                return HDate::russian_date(strtotime('+ ' . round($time * 365) . ' days', $date));
        }

        if ($this->interval == self::INTERVAL_HOUR)
            return HDate::russian_date(strtotime('+ ' . $time . ' hours', $date));
        if ($this->interval == self::INTERVAL_DAY)
            return HDate::russian_date(strtotime('+ ' . $time . ' days', $date));
        if ($this->interval == self::INTERVAL_MONTH)
            return HDate::russian_date(strtotime('+ ' . $time . ' months', $date));
        if ($this->interval == self::INTERVAL_YEAR)
            return HDate::russian_date(strtotime('+ ' . $time . ' years', $date));
    }

    /**
     * Get baby age as string for user interface
     *
     * @return string
     */
    public function GetAge()
    {
        if (!empty($this->age_text))
            return $this->age_text;

        //if for adults
        if ($this->adult == '1')
            return 'ревакцинация каждые <b>' . $this->every_period . '</b> лет от момента последней ревакцинации';

        if (empty($this->time_to)) {
            $age = '<b>' . $this->time_from . '</b>';
            if ($this->interval == self::INTERVAL_HOUR)
                return $age . ' ' . Str::GenerateNoun(array('час', 'часа', 'часов'), $this->time_from);
            if ($this->interval == self::INTERVAL_DAY)
                return $age . ' ' . Str::GenerateNoun(array('день', 'дня', 'дней'), $this->time_from);
            if ($this->interval == self::INTERVAL_MONTH)
                return $age . ' ' . Str::GenerateNoun(array('месяц', 'месяца', 'месяцев'), $this->time_from);
            if ($this->interval == self::INTERVAL_YEAR)
                return $age . ' ' . Str::GenerateNoun(array('год', 'года', 'лет'), $this->time_from);
        } else {
            $age = '<b>' . $this->time_from . ' - ' . $this->time_to . '</b>';
            if ($this->interval == self::INTERVAL_HOUR)
                return $age . ' часов';
            if ($this->interval == self::INTERVAL_DAY)
                return $age . ' дней';
            if ($this->interval == self::INTERVAL_MONTH)
                return $age . ' месяцев';
            if ($this->interval == self::INTERVAL_YEAR)
                return $age . ' лет';
        }

    }

    /**
     * Generates text for user interface
     * @return string
     */
    public function GetText()
    {
        $str = $this->GetVaccinationTypeString() . ' против ' . $this->GetDiseasesLinks();
        if (!empty($this->comment))
            $str .= ' (' . $this->comment . ')';
        return $str;
    }

    public function GetVaccinationTypeString()
    {
        return $this->vaccine_type_names[$this->vaccination_type];
    }

    public function GetDiseasesLinks()
    {
        $result = '';
        foreach ($this->diseases as $disease){
            if (isset($disease->disease_id))
                $result .= CHtml::link($disease->title_genitive,
                    Yii::app()->createUrl('/childrenDiseases/default/view', array('url'=>$disease->disease->slug))) . ', ';
            else
                $result .= $disease->title_genitive . ', ';
        }
        return trim($result, ', ');
    }

    /**
     * Form some static data
     */
    public function Prepare()
    {
        $this->time_in_hours_from = $this->GetFirstTimeSpanInHours();
        $this->time_in_hours_to = $this->GetLastTimeSpanInHours();
        $this->age = $this->GetAge();
    }

    /**
     * Calculate data for some date
     *
     * @param int $date timestamp
     */
    public function CalculateForDate($date)
    {
        $this->GetRecommendDate($date);
    }

    /**
     * Form array with 1 or to periods, each from also arrays (year, month, day)
     * Examples array(1=>array('year'=>2010,'month'=>'янв','day'=>11))
     *          array(1=>array('year'=>2010,'month'=>'янв','day'=>'11-14'))
     *
     * @param int $date timestamp
     */
    protected function GetRecommendDate($date)
    {
        if ($this->interval == VaccineDate::INTERVAL_HOUR) {
            $this->recommendDate = array(HDate::russian_date($date));
        }
        elseif (empty($this->time_to))
            $this->recommendDate = array($this->GetFromDate($date));
        else
            $this->recommendDate = array($this->GetFromDate($date), $this->GetToDate($date));
    }

    /**
     * Compare objects
     * @static
     * @param $a VaccineDateData
     * @param $b VaccineDateData
     * @return int
     */
    static function Compare($a, $b)
    {
        $al = $a->time_in_hours_from;
        $bl = $b->time_in_hours_from;
        if ($al == $bl)
            return 0;

        return ($al > $bl) ? +1 : -1;
    }


    //****************************************************************************************************/
    /************************************************ VOTING *********************************************/
    /*****************************************************************************************************/


    /**
     * Get user vote for current vaccine in current period
     *
     * @param $baby Baby
     * @return int user choice
     */
    public function GetUserVote($baby)
    {
        if (Yii::app()->user->isGuest || $baby === null)
            return self::VOTE_EMPTY;
        $user_vote = $this->GetUserVoteFromDb(Yii::app()->user->id, $baby->id);
        if (empty($user_vote))
            return self::VOTE_EMPTY;
        return $user_vote;
    }

    private function GetUserVoteFromDb($user_id, $baby_id)
    {
        $connection = Yii::app()->db;
        $command = $connection->createCommand("SELECT vote FROM vaccine__dates_votes
            WHERE user_id = :user_id AND object_id=" . $this->id . " AND baby_id=" . $baby_id);
        $command->bindParam(":user_id", $user_id);
        return $command->queryScalar();
    }

    /****************************************************************************************************/
    /**********************************************    Admin Panel   ************************************/
    /****************************************************************************************************/

    public function GetTimeInterval()
    {
        if ($this->interval == self::INTERVAL_HOUR)
            return 'часов';
        if ($this->interval == self::INTERVAL_DAY)
            return 'дней';
        if ($this->interval == self::INTERVAL_MONTH)
            return 'месяцев';
        if ($this->interval == self::INTERVAL_YEAR)
            return 'лет';
    }
}