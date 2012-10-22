<?php
/**
 * Author: alexk984
 * Date: 13.03.12
 */
class UserScoresCommand extends CConsoleCommand
{

    public function beforeAction()
    {
        Yii::import('site.frontend.extensions.YiiMongoDbSuite.*');
        Yii::import('site.frontend.modules.scores.models.*');
        Yii::import('site.common.models.mongo.*');
        Yii::import('site.frontend.extensions.*');
        Yii::import('site.frontend.components.*');

        return true;
    }

    /**
     * Нужно для объдинения в группы оповещений о набранных баллах. Просматриваем все открытые записи о начислении
     * баллов и если время закрывать, то закрываем. После закрытия оно отобразиться в статистике
     *
     * Раз в 5 минут
     */
    public function actionIndex()
    {
        ScoreInput::CheckOnClose();
    }

    public function actionCheck()
    {
        Yii::import('site.frontend.modules.geo.models.*');
        Yii::import('site.common.models.interest.*');
        Yii::app()->db->createCommand('update score__user_scores set level_id = NULL, full = 0')->execute();

        $criteria = new CDbCriteria;
        $criteria->limit = 100;
        $i = 0;
        $users = array(1);

        while (!empty($users)) {
            $criteria->offset = 100 * $i;
            $users = User::model()->with('userAddress', 'interests')->findAll($criteria);

            foreach ($users as $user) {
                if (empty($user->interests)) {
                    $e_criteria = new EMongoCriteria;
                    $e_criteria->addCond('user_id', '==', (int)$user->id);
                    $e_criteria->addCond('action_id', '==', (int)ScoreAction::ACTION_PROFILE_INTERESTS);
                    ScoreInput::model()->deleteAll($e_criteria);
                }

                if (!empty($user->getUserAddress()->country_id))
                    UserScores::checkProfileScores($user->id, ScoreAction::ACTION_PROFILE_LOCATION);

                if ($user->email_confirmed == 1)
                    UserScores::checkProfileScores($user->id, ScoreAction::ACTION_PROFILE_EMAIL);

                if (!empty($user->avatar_id))
                    UserScores::checkProfileScores($user->id, ScoreAction::ACTION_PROFILE_PHOTO);
            }

            $i++;
            echo ($i * 100) . "\n";
        }
    }

    /*public function actionCheckInterests()
    {
        Yii::import('site.frontend.modules.geo.models.*');
        Yii::import('site.common.models.interest.*');

        $criteria = new CDbCriteria;
        $criteria->limit = 100;
        $i = 0;
        $users = array(1);

        while (!empty($users)) {
            $criteria->offset = 100 * $i;
            $users = User::model()->with('interests')->findAll($criteria);

            foreach($users as $user){
                if (!empty($user->interests))
                    UserScores::checkProfileScores($user->id, ScoreAction::ACTION_PROFILE_INTERESTS);
            }

            $i++;
            echo ($i*100)."\n";
        }
    }

    public function actionCheckFull()
    {
        Yii::import('site.frontend.modules.geo.models.*');
        Yii::import('site.common.models.interest.*');

        $criteria = new CDbCriteria;
        $criteria->limit = 100;
        $i = 0;
        $users = array(1);

        while (!empty($users)) {
            $criteria->offset = 100 * $i;
            $users = User::model()->with()->findAll($criteria);

            foreach($users as $user){
                $user->getScores()->checkFull();
            }

            $i++;
            echo ($i*100)."\n";
        }
    }*/

    public function actionCheckLikes()
    {
        $ids = Yii::app()->db->createCommand()
            ->select('id')
            ->from('contest__works')
            ->where('contest_id = 2')
            ->queryColumn();

        foreach ($ids as $id) {
            $models = RatingYohoho::model()->findAllByAttributes(array(
                'entity_name' => 'ContestWork',
                'entity_id' => (int)$id
            ));

            echo $id . ' - ' . count($models) . ' - likes count' . "\n";

            $exec = false;
            foreach ($models as $model) {
                $user = User::getUserById($model->user_id);
                if ($user === null || $user->getScores()->full == 0) {
                    $model->delete();
                    $exec = true;
                }
            }

            if ($exec) {
                $count = RatingYohoho::model()->countByAttributes(array(
                    'entity_name' => 'ContestWork',
                    'entity_id' => (int)$id
                ));
                echo $id . " hacked\n";
                echo $count . " - now likes count \n";

                $criteria = new EMongoCriteria;
                $criteria->entity_id('==', (int)$id);
                $criteria->entity_name('==', 'ContestWork');
                $model = Rating::model()->find($criteria);
                if ($model !== null) {
                    $model->ratings['yh'] = $count*2;
                    $model->save();
                }
            }
        }
    }
}

