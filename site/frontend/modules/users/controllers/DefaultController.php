<?php
/**
 * @author Никита
 * @date 13/01/15
 */

namespace site\frontend\modules\users\controllers;


class DefaultController extends \LiteController
{
    public function filters()
    {
        return array(
            'accessControl',
        );
    }

    public function accessRules()
    {
        return array(
            array('deny',
                'users' => array('?'),
            ),
        );
    }

    public function actions()
    {
        return array(
            'social' => array(
                'class' => 'SocialAction',
                'successCallback' => function($eauth) {
                    $model = new \UserSocialService();
                    $model->user_id = \Yii::app()->user->id;
                    $model->service_id = $eauth->getAttribute('uid');
                    $model->service = $eauth->getServiceName();
                    $model->name = $eauth->getAttribute('first_name') . ' ' . $eauth->getAttribute('last_name');
                    $model->save();

                    $eauth->redirect(\Yii::app()->controller->createUrl('settings'));
                },
            ),
        );
    }

    public $litePackage = 'member';

    public function actionSettings()
    {
        $this->render('settings');
    }
} 