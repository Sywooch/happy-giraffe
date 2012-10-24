<?php
/**
 * User: alexk984
 * Date: 10.03.12
 *
 */

Yii::import('site.common.models.mongo.*');
Yii::import('site.frontend.extensions.YiiMongoDbSuite.*');
class UsersCommand extends CConsoleCommand
{
    public function actionIndex()
    {
//        $this->setRole($this->virtual_users, 'virtual user');
//        $this->setRole($this->moderators, 'moderator');
    }

    public function setRole($users, $role)
    {
        $list = explode("\n", $users);
        foreach ($list as $userMail) {
            $userMail = trim($userMail);
            $user = User::model()->findByAttributes(array('email' => $userMail));
            //check if user exist
            if ($user !== null) {
                //check if user already has role
                $exist_right = Yii::app()->db->createCommand()
                    ->select('COUNT(*)')
                    ->from('auth__assignments')
                    ->where('userid = :userid AND itemname = "' . $role . '"', array(':userid' => $user->id))
                    ->queryScalar();
                if ($exist_right == 0) {
                    $success = Yii::app()->db->createCommand()
                        ->insert('auth__assignments', array('userid' => $user->id, 'itemname' => $role, 'data' => 'N;'));
                    if (!$success)
                        echo $userMail . " insert error \r\n";
                }
            } else {
                echo $userMail . "\r\n";
            }
        }
    }

    public function actionRemoveUsers()
    {
        Yii::import('site.frontend.modules.cook.models.*');
        Yii::import('site.frontend.modules.services.modules.recipeBook.models.*');
        Yii::import('site.frontend.modules.cook.models.*');

        $criteria = new CDbCriteria;
        $criteria->condition = '`group` = 0 AND last_active < :last_active AND login_date < :last_active
         AND (register_date IS NULL OR register_date < :last_active) AND id < 14000';
        $criteria->params = array(':last_active' => date("Y-m-d H:i:s", strtotime('-2 month')));
        $criteria->limit = 1000;

        $users = User::model()->findAll($criteria);
        $k = 0;
        foreach ($users as $user) {
            if ($user->communityContentsCount == 0 && $user->cookRecipesCount == 0
                && $user->recipeBookRecipesCount == 0 && $user->commentsCount == 0
                && $user->photosCount == 0
            ) {
                Yii::app()->db->createCommand()->delete('users', 'id=' . $user->id);
                $k++;
            }
        }

        echo $k . "\n";


        $criteria = new CDbCriteria;
        $criteria->condition = '`group` = 0 AND last_active IS NULL AND login_date = "0000-00-00 00:00:00" AND id < 14000';
        //$criteria->params = array(':last_active' => date("Y-m-d H:i:s", strtotime('-2 month')));

        $users = User::model()->findAll($criteria);
        $k = 0;
        foreach ($users as $user) {
            if ($user->communityContentsCount == 0 && $user->cookRecipesCount == 0
                && $user->recipeBookRecipesCount == 0 && $user->commentsCount == 0
                && $user->photosCount == 0
            ) {
                Yii::app()->db->createCommand()->delete('users', 'id=' . $user->id);
                $k++;
            }
        }

        echo $k . "\n";
    }

    public function actionFire($user)
    {
        $user = User::model()->findByPk($user);
        UserAttributes::set($user->id, 'fire_time', time());
    }
}
