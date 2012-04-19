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
    public $user_votes = array();

    function __construct()
    {
        $vaccineDates = VaccineDate::model()->with(array('vaccine', 'diseases'))->findAll();
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

    public function LoadVotes(){
        $vaccineDates = VaccineDate::model()->findAll(
            array('select'=>array('id','vote_decline', 'vote_agree', 'vote_did')));
        foreach ($vaccineDates as $vaccineDate) {
            foreach ($this->vaccineDates as $vaccineDateCached) {
                if ($vaccineDate->id == $vaccineDateCached->id){
                    $vaccineDateCached->vote_agree = $vaccineDate->vote_agree;
                    $vaccineDateCached->vote_decline = $vaccineDate->vote_decline;
                    $vaccineDateCached->vote_did = $vaccineDate->vote_did;
                    break;
                }
            }
        }
    }

    /**
     * Load all user marks
     * @param $baby_id
     */
    public function LoadUserVotes($baby_id){
        $votes = $this->GetUserVotes(Yii::app()->user->id, $baby_id);
        foreach($votes as $row){
            $this->user_votes[$row['entity_id']] = $row['vote'];
        }
    }

    /**
     * Get user mark for current voteDate
     *
     * @param $day_id
     * @return int
     */
    public function GetUserVote($day_id){
        if (isset($this->user_votes[$day_id]))
            return $this->user_votes[$day_id];
        else
            return null;
    }

    /**
     * Get user mark from DB
     *
     * @param $user_id
     * @param $baby_id
     * @return array
     */
    private function GetUserVotes($user_id, $baby_id){
        $connection=Yii::app()->db;
        $command=$connection->createCommand("SELECT entity_id, vote FROM vaccine__dates_votes
            WHERE user_id = :user_id AND baby_id=".$baby_id);
        $command->bindParam(":user_id",$user_id);
        return $command->queryAll();
    }
}