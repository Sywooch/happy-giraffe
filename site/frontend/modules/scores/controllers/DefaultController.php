<?php

class DefaultController extends Controller
{
    public $user;
    public $layout = '//layouts/main';

    public function accessRules()
    {
        return array(
            array('allow',
                'users' => array('@'),
            ),
            array('allow',
                'users' => array('*'),
            ),
        );
    }

	public function actionIndex($user_id = null)
	{
        if ($user_id === null)
            $user_id = Yii::app()->user->id;
        $this->user = User::getUserById($user_id);

        Yii::import('site.frontend.modules.scores.models.*');
        $userScores = UserScores::getModel($user_id);
        $dataProvider = $userScores->getUserHistory();

        $this->render('index', array(
            'userScores' => $userScores,
            'dataProvider' => $dataProvider
        ));
	}

    public function actionRemoveAll()
    {
        if (Yii::app()->user->checkAccess('administrator')){
            ScoreInput::model()->deleteAll();
            ScoreOutput::model()->deleteAll();
            ScoreVisits::model()->deleteAll();
            Yii::app()->db->createCommand()
                ->update('user_scores', array('full'=>0));
        }
    }
}