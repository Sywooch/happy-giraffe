<?php
/**
 * Created by JetBrains PhpStorm.
 * User: mikita
 * Date: 7/30/13
 * Time: 5:13 PM
 * To change this template use File | Settings | File Templates.
 */

class UserController extends HController
{
    public $layout = '//layouts/common_new';

    public function actionIndex($userId = 12936)
    {
        $scopes = !Yii::app()->user->isGuest && Yii::app()->user->id == $userId ? array() : array('noSystem');
        $dataProvider = Album::model()->findByUser($userId, false, false, $scopes);

        $this->render('index', compact('dataProvider', 'userId'));
    }

    public function actionView($userId, $albumId)
    {
        $data = Album::model()->findByPk($albumId);
        $this->render('view', compact('data'));
    }
}