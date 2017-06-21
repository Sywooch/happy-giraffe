<?php

namespace site\frontend\modules\iframe\widgets\landingSlider;
use site\frontend\modules\iframe\models\Pediatrician;
use site\frontend\modules\specialists\models\SpecialistProfile;

/**
 * @author Никита
 * @date 20/06/17
 */
class LandingSlider extends \CWidget
{
    const DOCTORS_COUNT = 3;
    
    public function run()
    {
        $pediators = $this->getDoctors();
        $this->render('view', compact('pediators'));
    }

    public function getInfoString($userId)
    {
        $profile = SpecialistProfile::model()->findByPk($userId);
        $expCat = [];
        if ($profile->experience) {
            $expCat[] = 'Стаж: ' . \site\frontend\modules\specialists\models\SpecialistProfile::getExperienceList()[$profile->experience];
        }
        if ($profile->category && \site\frontend\modules\specialists\models\SpecialistProfile::getCategoriesList()[$profile->category]) {
            $expCat[] = \site\frontend\modules\specialists\models\SpecialistProfile::getCategoriesList()[$profile->category];
        }
        
        return count($expCat) > 0 ? implode(' / ', $expCat) : '';
    }

    protected function getDoctors()
    {
        $data = Pediatrician::model()->getData();
        return array_slice($data['rows'], 0, self::DOCTORS_COUNT);
    }
}