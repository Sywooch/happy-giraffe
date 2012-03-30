<?php
/**
 * Author: alexk984
 * Date: 30.03.12
 */
class FamilyController  extends Controller
{
    public $user;

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

    public function actionIndex(){

    }
}
