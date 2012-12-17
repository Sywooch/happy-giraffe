<?php

class DefaultController extends HController
{
    public $user;
    public $layout = '//layouts/main';

    public function filters()
    {
        return array(
            'accessControl',
            'Remove + ajaxOnly'
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
        Yii::import('site.frontend.modules.cook.models.*');
        Yii::import('site.frontend.modules.services.modules.recipeBook.models.*');

        if ($user_id === null)
            $user_id = Yii::app()->user->id;
        $this->user = User::getUserById($user_id);

        $userScores = UserScores::model()->findByPk($user_id);
        $dataProvider = $userScores->getUserHistory();

        $this->render('index', array(
            'userScores' => $userScores,
            'dataProvider' => $dataProvider
        ));
    }

    public function actionRemove($id)
    {
        if (Yii::app()->user->checkAccess('administrator') && is_numeric($id)) {
            $criteria = new EMongoCriteria();
            $criteria->addCond('user_id', '==', (int)$id);
            ScoreInput::model()->deleteAll($criteria);
            ScoreOutput::model()->deleteAll($criteria);
            ScoreVisits::model()->deleteAll($criteria);
        }
    }
}