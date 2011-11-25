<?php
/**
 * Represents all data about vaccination
 */
class VaccineData
{
    /**
     * @var VaccineDate[]
     */
    public $vaccineDates = array();
    /**
     * @param int $date timestamp
     */
    public $birthday = null;

    function __construct()
    {
        $vaccineDates = VaccineDate::model()->with(array('vaccine'))->findAll();
        foreach ($vaccineDates as $vaccineDate) {
            $this->vaccineDates [] = $vaccineDate;
            $vaccineDate->Prepare();
        }
        $this->Sort();
    }

    /**
     * Sort result array
     */
    public function Sort()
    {
        usort($this->vaccineDates, array("VaccineDate", "Compare"));
    }

    /**
     * Calculate data for some date
     *
     * @param int $date timestamp
     */
    public function CalculateForDate($date)
    {
        $this->birthday = $date;
        foreach ($this->vaccineDates as $day) {
            $day->CalculateForDate($date);
        }
    }

}