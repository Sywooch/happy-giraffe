e<?php
/**
 * Created by JetBrains PhpStorm.
 * User: mikita
 * Date: 7/30/13
 * Time: 5:13 PM
 * To change this template use File | Settings | File Templates.
 */

class UserController extends HController
{
    public $layout = 'user_albums';
    public $user;

    protected  function beforeAction($action)
    {
        $this->user = User::model()->findByPk(Yii::app()->request->getParam('user_id'));
        if ($this->user === null)
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');

        return parent::beforeAction($action);
    }

    public function actionIndex($user_id)
    {
        $dataProvider = Album::model()->findByUser($user_id);

        $this->render('index', compact('dataProvider', 'user_id'));
    }

    public function actionView($user_id, $album_id)
    {
        $data = Album::model()->findByPk($album_id);
        if ($data->author_id != $user_id)
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');

        $this->render('_album', array('data' => $data, 'full' => true));
    }
}