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

    public static function update($userId, $status)
    {
        \UserAttributes::set($userId, self::ATTRIBUTE_KEY, $status);
    }
    
    protected static function needsIntroduction()
    {
        if (\Yii::app()->user->isGuest) {
            return false;
        }
        
        $passed = \UserAttributes::get(\Yii::app()->user->id, self::ATTRIBUTE_KEY, false);
        if (! $passed) {
            $isFilled = self::isFilled(\Yii::app()->user->model);
            if ($isFilled) {
                $passed = true;
                \UserAttributes::set(\Yii::app()->user->id, self::ATTRIBUTE_KEY, $passed);
            }
        }
        return ! $passed;
    }

    protected static function isFilled(\User $user)
    {
        return
            ! empty($user->first_name)
            && in_array($user->gender, [User::GENDER_MALE, User::GENDER_FEMALE])
            && $user->location->country
        ;
    }
}