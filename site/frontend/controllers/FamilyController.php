<?php
/**
 * Author: alexk984
 * Date: 30.03.12
 */
class FamilyController extends Controller
{
    public $user;
    public $layout = 'user';

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

    public function beforeAction($action)
    {
        Yii::app()->clientScript->registerScriptFile('/javascripts/family.js');

        return parent::beforeAction($action);
    }

    public function actionIndex()
    {
        $this->user = User::model()->with(array(
            'babies', 'partner'
        ))->findByPk(Yii::app()->user->id);

        Yii::import('application.widgets.user.UserCoreWidget');
        $this->render('index', array('user' => $this->user));
    }
}
