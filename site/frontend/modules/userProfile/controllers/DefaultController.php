<?php

namespace site\frontend\modules\userProfile\controllers;

/**
 * @author Никита
 * @date 25/12/14
 */
class DefaultController extends \LiteController
{

    public $litePackage = 'member';

    public function getListDataProvider($authorId)
    {
        return new \CActiveDataProvider(\site\frontend\modules\posts\models\Content::model()->byService('oldBlog')->byAuthor($authorId)->orderDesc(), array(
            'pagination' => array(
                'pageSize' => 10,
                'pageVar' => 'page',
            )
        ));
    }

    public function actionIndex($userId)
    {
        $user = \User::model()->active()->findByPk($userId);
        if ($user === null) {
            throw new \CHttpException(404);
        }
        \NoindexHelper::setNoIndex($user);
        $this->render('index', array('user' => $user, 'dataProvider' => $this->getListDataProvider($userId)));
    }

}
