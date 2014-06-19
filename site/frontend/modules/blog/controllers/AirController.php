<?php
/**
 * Created by PhpStorm.
 * User: mikita
 * Date: 16/06/14
 * Time: 12:21
 */

class AirController extends HController
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
            array(
                'deny',
                'users' => array('?'),
            ),
        );
    }

    public function actionIndex()
    {
        $dp = new CActiveDataProvider('CommunityContent', array(
            'criteria' => array(
                'order' => 't.created DESC',
            ),
        ));

        $onlineUsers = User::model()->findAll(array(
            'condition' => 'avatar_id IS NOT NULL',
            'limit' => 60,
            'order' => 'online DESC, login_date DESC',
        ));

        Yii::app()->clientScript->registerMetaTag('noindex', 'robots');
        $this->pageTitle = 'Прямой эфир';
        $this->render('index', compact('dp', 'onlineUsers'));
    }
} 