<?php
/**
 * Created by PhpStorm.
 * User: mikita
 * Date: 16/06/14
 * Time: 12:21
 */

class AirController extends HController
{
    public function actionIndex()
    {
        Yii::app()->clientScript->registerMetaTag('noindex', 'robots');
        $dp = new CActiveDataProvider('CommunityContent', array(
            'criteria' => array(
                'order' => 't.created DESC',
            ),
        ));
        $onlineUsers = User::model()->findAll('online = 1 AND avatar_id IS NOT NULL');
        $this->pageTitle = 'Прямой эфир';
        $this->render('index', compact('dp', 'onlineUsers'));
    }
} 