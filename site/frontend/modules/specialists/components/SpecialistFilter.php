<?php
/**
 * @author Никита
 * @date 30/08/16
 */

namespace site\frontend\modules\specialists\components;


class SpecialistFilter
{
    public static function denySpecialists()
    {
        if (\Yii::app()->user->checkAccess('specialist') && strpos(\Yii::app()->controller->route, 'specialists') !== 0) {
            \Yii::app()->controller->redirect(['/specialists/pediatrician/default/questions']);
        }
    }
}