<?php
/**
 * @author Никита
 * @date 24/08/16
 */

namespace site\frontend\modules\specialists\components;


use site\frontend\components\AuthManager;
use site\frontend\modules\specialists\models\SpecialistProfile;
use site\frontend\modules\specialists\models\SpecialistSpecialization;
use site\frontend\modules\users\models\User;
use site\frontend\modules\specialists\models\SpecialistsProfileAuthorizationTasks;
use site\frontend\modules\specialists\models\SpecialistGroupTaskRelation;
use site\frontend\modules\specialists\models\specialistsProfileAuthorizationTasks\ProfileTasksStatusEnum;

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

            (new SpecialistsManager())->addProfileTasks($profile);

            $transaction->commit();
            return true;
        } catch (\Exception $e) {
            $transaction->rollback();
            return false;
        }
    }

    public static function getSpecializations($groupId)
    {
        return SpecialistSpecialization::model()->sorted()->findAll('groupId = :groupId', [':groupId' => $groupId]);
    }

    public static function assignSpecializations($specializations, $userId, $deleteOld = false)
    {
        $transaction = \Yii::app()->db->beginTransaction();
        try {
            if ($deleteOld) {
                \Yii::app()->db->createCommand()->delete('specialists__profiles_specializations', 'profileId = :userId', [':userId' => $userId]);
            }
            if (count($specializations) > 0) {
                $rows = array_map(function ($specId) use ($userId) {
                    return [
                        'profileId' => $userId,
                        'specializationId' => $specId];
                }, $specializations);
                $success = \Yii::app()->db->getCommandBuilder()->createMultipleInsertCommand('specialists__profiles_specializations', $rows)->execute() > 0;
                if ($success) {
                    $user = User::model()->findByPk($userId);
                    $profile = SpecialistProfile::model()->findByPk($userId);
                    $user->specialistInfoObject->title = $profile->getSpecsString();
                    $user->save();
                }
            }
            $transaction->commit();
            return true;
        } catch (\Exception $e) {
            $transaction->rollback();
            return false;
        }
    }

    public static function updateProfileAuthorizationStatus($userId)
    {
        $profileTasks = SpecialistsProfileAuthorizationTasks::model()->findAll('user_id=' . $userId);
        $specialistProfile = SpecialistProfile::model()->findByPk($userId);

        if (empty($profileTasks))
        {
            return;
        }

        foreach ($profileTasks as $row)
        {
            if ($row->status != ProfileTasksStatusEnum::DONE)
            {
                return $specialistProfile->setAuthorizationStatusNotActive();
            }
        }

        return $specialistProfile->setAuthorizationStatusActive();
    }

    /**
     * @param SpecialistProfile $profileModel
     */
    public function addProfileTasks(SpecialistProfile $profileModel)
    {
        /* @var $specializations SpecialistSpecialization */
        $specializations = $profileModel->specializations;

        $taskRelations = [];

        foreach ($specializations as $specialization)
        {
            $group = $specialization->group;

            $groupRelations = $group->authorization_tasks_relations;

            foreach ($groupRelations as $relation)
            {
                $taskRelations[$relation->id] = $relation;
            }

        }

        $this->_createProfileTask($taskRelations, $profileModel->id);

        return true;
    }

    /**
     * @param array $taskRelations SpecialistGroupTaskRelation[]
     * @param integer $userId
     */
    private function _createProfileTask($taskRelations, $userId)
    {
        foreach ($taskRelations as /*@var $relation SpecialistGroupTaskRelation */ $relation)
        {
            $profileTask = new SpecialistsProfileAuthorizationTasks();

            $profileTask->user_id = $userId;
            $profileTask->group_relation_id = $relation->id;

            $profileTask->save();
        }
    }
}