<?php

class VaccineWidget extends CWidget
{
    /**
     * baby birth date
     * @var int
     */
    public $date = null;
    /**
     * @var Baby
     */
    public $baby = null;
    public $baby_id = null;
    public $enable_cache = true;

    public function init()
    {

    }

    public function run()
    {
        if (!empty($this->baby_id))
            $this->baby = Baby::model()->findByPk($this->baby_id);

        $this->render('VaccineWidget', array(
            'data' => $this->GetVaccineData(),
            'date'=>$this->date,
            'baby'=>$this->baby
        ));
    }

    public function GetVaccineData()
    {
        if ($this->enable_cache) {
            $data = Yii::app()->cache->get('vaccine_calendar');
            if ($data === false) {
                $data = new VaccineData();
                Yii::app()->cache->set('vaccine_calendar', $data, 60);
            }else
                $data->LoadVotes();
        } else
            $data = new VaccineData();
        if (!empty($this->baby)){
            $data->CalculateForDate(strtotime($this->baby->birthday));
            $data->LoadUserVotes($this->baby_id);
        }
        else
            $data->CalculateForDate($this->date);

        return $data;
    }
}