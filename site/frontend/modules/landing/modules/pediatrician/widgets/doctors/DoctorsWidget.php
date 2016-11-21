<?php

namespace site\frontend\modules\landing\modules\pediatrician\widgets\doctors;

use site\frontend\modules\som\modules\qa\models\QaRating;
use site\frontend\modules\specialists\models\SpecialistProfile;
use site\frontend\modules\specialists\models\SpecialistSpecialization;
use site\frontend\modules\specialists\modules\pediatrician\components\RatingManager;
use site\frontend\modules\users\models\User;

/**
 * @author Никита
 * @date 16/08/16
 */
class DoctorsWidget extends \CWidget
{
    public $nDoctors = 3;

    /** @var RatingManager */
    protected $ratingManager;

    public function init()
    {
        parent::init();

        $this->ratingManager = new RatingManager();
    }

    public function run()
    {
        $users = $this->getDoctors();

        if ($users) {
            $this->render('index', compact('users'));
        }
    }

    /**
     * @return User[]
     */
    protected function getDoctors()
    {
        $rating = $this->ratingManager->getRating($this->nDoctors);

        return array_map(function (QaRating $r) {
            return $r->user;
        }, $rating);

        /*
        // Случайные доктора
        return SpecialistProfile::model()->with('user', 'specializations')->findAll([
            'limit' => $this->nDoctors,
            'order' => 'RAND()',
        ]);
        */
    }

    public function getSpecs(SpecialistProfile $profile)
    {
        return implode(', ', array_map(function (SpecialistSpecialization $specialization) {
            return $specialization->title;
        }, $profile->specializations));
    }
}