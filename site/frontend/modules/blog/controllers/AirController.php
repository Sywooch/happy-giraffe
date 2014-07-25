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
        $dp = $this->getDataProvider();

        $onlineUsers = User::model()->findAll(array(
            'condition' => 'avatar_id IS NOT NULL',
            'limit' => 60,
            'order' => 'online DESC, login_date DESC',
        ));

        Yii::app()->clientScript->registerMetaTag('noindex', 'robots');
        $this->pageTitle = 'Прямой эфир';
        $this->render('index', compact('dp', 'onlineUsers'));
    }

    protected function getDataProvider()
    {
        $data1 = CommunityContent::model()->findAll(array(
            'condition' => 't.created > DATE_SUB(NOW(), INTERVAL 48 HOUR)',
            'order' => 't.created DESC',
        ));
        $data2 = CookRecipe::model()->findAll(array(
            'condition' => 't.created > DATE_SUB(NOW(), INTERVAL 48 HOUR)',
            'order' => 't.created DESC',
        ));
        $data = array_merge($data1, $data2);
        usort($data, function($a, $b) {
            if ($a->created == $b->created) {
                return 0;
            }

            return ($a->created > $b->created) ? -1 : 1;
        });

        return new CArrayDataProvider($data);
    }
} 