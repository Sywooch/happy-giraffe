<?php

namespace site\frontend\modules\landing\modules\pediatrician\widgets\doctors;
use site\frontend\modules\specialists\models\SpecialistProfile;
use site\frontend\modules\specialists\models\SpecialistSpecialization;

/**
 * @author Никита
 * @date 16/08/16
 */
class DoctorsWidget extends \CWidget
{
    public $nDoctors = 3;
    
    public function run()
    {
        $profiles = $this->getDoctors();
        if ($profiles) {
            $this->render('index', compact('profiles'));
        }
    }
    
    protected function getDoctors()
    {
        return SpecialistProfile::model()->with('user', 'specializations')->findAll([
            'limit' => $this->nDoctors,
            'order' => 'RAND()',
        ]);
    }
    
    public function getSpecs(SpecialistProfile $profile)
    {
        return implode(', ', array_map(function(SpecialistSpecialization $specialization) {
            return $specialization->title;
        }, $profile->specializations));
    }
}