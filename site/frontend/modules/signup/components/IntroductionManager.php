<?php
/**
 * @author Никита
 * @date 31/03/17
 */

namespace site\frontend\modules\signup\components;


use site\frontend\modules\users\models\User;

class IntroductionManager
{
    const ATTRIBUTE_KEY = 'introductionPassed';
    
    public static function check()
    {
        if (self::needsIntroduction()) {
            \Yii::app()->clientScript->registerAMD('introductionForm', [
                'IntroductionForm' => 'signup/introduction-form',
            ], 'IntroductionForm.viewModel.prototype.open();');
        }
    }
    
    public static function finish(\User $user)
    {
        $user->registration_finished = 1;
        $user->update(['registration_finished']);
        self::setStatus($user->id, true);
    }
    
    protected static function getStatus($userId)
    {
        return \UserAttributes::get($userId, self::ATTRIBUTE_KEY, false);
    }
    
    protected static function setStatus($userId, $status)
    {
        \UserAttributes::set($userId, self::ATTRIBUTE_KEY, $status);
    }
    
    protected static function needsIntroduction()
    {
        if (\Yii::app()->user->isGuest) {
            return false;
        }
        
        $passed = self::getStatus(\Yii::app()->user->id);
        if (! $passed) {
            $isFilled = self::isFilled(\Yii::app()->user->model);
            if ($isFilled) {
                $passed = true;
                self::setStatus(\Yii::app()->user->id, $passed);
            }
        }
        return ! $passed;
    }

    protected static function isFilled(\User $user)
    {
        return
            ! empty($user->first_name)
            && in_array($user->gender, [User::GENDER_MALE, User::GENDER_FEMALE])
            && $user->location->countryId
        ;
    }
}