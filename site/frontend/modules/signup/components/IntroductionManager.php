<?php
/**
 * @author Никита
 * @date 31/03/17
 */

namespace site\frontend\modules\signup\components;


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
        
        return ! \UserAttributes::get(\Yii::app()->user->id, self::ATTRIBUTE_KEY, false);
    }
}