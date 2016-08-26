<?php
/**
 * @author Никита
 * @date 24/08/16
 */

namespace site\frontend\modules\specialists\components;


use Aws\CloudFront\Exception\Exception;
use site\frontend\components\AuthManager;
use site\frontend\modules\specialists\models\SpecialistProfile;
use site\frontend\modules\specialists\models\SpecialistSpecialization;

class SpecialistsManager
{
    public static function makeSpecialist($userId, $specializations = [])
    {
        $transaction = \Yii::app()->db->beginTransaction();
        try {
            $profile = new SpecialistProfile();
            $profile->id = $userId;
            $profile->save();

            /** @var AuthManager $authManager */
            $authManager = \Yii::app()->authManager;
            $authManager->assign('specialist', $userId);
            
            if (count($specializations) > 0) {
                self::assignSpecializations($specializations, $userId);
            }
            $transaction->commit();
            return true;
        } catch (Exception $e) {
            $transaction->rollback();
            return false;
        }
    }

    public static function getSpecializations($groupId)
    {
        return SpecialistSpecialization::model()->findAll('groupId = :groupId', [':groupId' => $groupId]);
    }

    public static function assignSpecializations($specializations, $userId, $deleteOld = false)
    {
        if ($deleteOld) {
            \Yii::app()->db->createCommand()->delete('specialists__profiles_specializations', 'profileId = :userId', [':userId' => $userId]);
        }
        $rows = array_map(function($specId) use ($userId) {
            return [
                'profileId' => $userId,
                'specializationId' => $specId];
        }, $specializations);
        \Yii::app()->db->getCommandBuilder()->createMultipleInsertCommand('specialists__profiles_specializations', $rows)->execute();
    }
}