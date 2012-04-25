<?php

class DefaultController extends HController
{
    public $user;
    public $layout = '//layouts/main';

    public function filters()
    {
        return array(
            'accessControl',
        );
    }

    public function accessRules()
    {
        return array(
            array('allow',
                'users' => array('@'),
            ),
            array('deny',
                'users' => array('*'),
            ),
        );
    }

    public function actionIndex($user_id = null)
    {
        $this->pageTitle = 'Мои баллы';

        if ($user_id === null)
            $user_id = Yii::app()->user->id;
        $this->user = User::getUserById($user_id);

        $userScores = UserScores::getModel($user_id);
        $dataProvider = $userScores->getUserHistory();

        $this->render('index', array(
            'userScores' => $userScores,
            'dataProvider' => $dataProvider
        ));
    }

    public function actionRemoveAll()
    {
        if (Yii::app()->user->checkAccess('administrator')) {
            ScoreInput::model()->deleteAll();
            ScoreOutput::model()->deleteAll();
            ScoreVisits::model()->deleteAll();
            Yii::app()->db->createCommand()
                ->update('score__user_scores', array('full' => 0));
        }
    }

    public function actionRemove($id)
    {
        if (Yii::app()->user->checkAccess('administrator') && is_numeric($id)) {
            $criteria = new EMongoCriteria();
            $criteria->addCond('user_id', '==', (int)$id);
            ScoreInput::model()->deleteAll($criteria);
            ScoreOutput::model()->deleteAll($criteria);
            ScoreVisits::model()->deleteAll($criteria);
            UserScores::model()->updateByPk($id, array(
                'scores'=>0,
                'full'=>0,
                'level_id'=>null,
            ));
        }
    }
}