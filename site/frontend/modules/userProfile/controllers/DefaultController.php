<?php

namespace site\frontend\modules\userProfile\controllers;
use site\frontend\modules\posts\models\Content;

/**
 * @author Никита
 * @date 25/12/14
 */
class DefaultController extends \LiteController
{

    public $litePackage = 'member';

    public function getListDataProvider($authorId)
    {
        return new \CActiveDataProvider('\site\frontend\modules\posts\models\Content', array(
            'criteria' => Content::model()->byAuthor($authorId)->orderDesc()->getDbCriteria(),
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
        $dp = $this->getListDataProvider($userId);
        if (isset($_GET[$dp->pagination->pageVar])) {
            $this->metaNoindex = true;
        } else {
            \NoindexHelper::setNoIndex($user);
        }
        $this->render('index', array('user' => $user, 'dataProvider' => $dp));
    }

}
