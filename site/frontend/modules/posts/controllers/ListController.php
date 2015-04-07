<?php

namespace site\frontend\modules\posts\controllers;

use site\frontend\modules\posts\models\Content;
use site\frontend\modules\rss\components\channels\UserRssChannel;

/**
 * Description of ListController
 *
 * @author Кирилл
 */
class ListController extends \LiteController
{

    public $layout = '//layouts/lite/main';
    public $litePackage = 'posts';
    /**
     * @var null|\CActiveDataProvider
     */
    public $listDataProvider = null;
    public $hideUserAdd = false;
    public $userId;
    protected $_user = null;

    /**
     * @return \site\frontend\components\api\models\User
     * @throws \site\frontend\components\api\ApiException
     */
    public function getUser()
    {
        if (is_null($this->_user)) {
            $this->_user = \site\frontend\components\api\models\User::model()->query('get', array(
                'id' => $this->userId,
                'avatarSize' => \Avatar::SIZE_MEDIUM,
            ));
        }

        return $this->_user;
    }

    public function getListDataProvider($authorId)
    {
        $criteria = Content::model()->byService('oldBlog')->byAuthor($authorId)->orderDesc()->getDbCriteria();
        return new \CActiveDataProvider('\site\frontend\modules\posts\models\Content', array(
            'criteria' => clone $criteria,
            'pagination' => array(
                'pageSize' => 10,
                'pageVar' => 'BlogContent_page',
            )
        ));
    }

    public function actionIndex()
    {
        $userId = \Yii::app()->request->getQuery('user_id');
        $this->rssFeed = new UserRssChannel($userId);
        $this->userId = $userId;
        $this->listDataProvider = $this->getListDataProvider($userId);
        $this->owner = \User::model()->findByPk($userId);
        $this->render('list');
    }

}

?>
