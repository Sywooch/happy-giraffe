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

    public $layout = 'newBlogPost';
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
        $criteria = Content::model()->byLabels(array('Блог'))->byAuthor($authorId)->orderDesc()->getDbCriteria();
        return new \CActiveDataProvider('\site\frontend\modules\posts\models\Content', array(
            'criteria' => clone $criteria,
            'pagination' => array(
                'pageSize' => 10,
                'pageVar' => 'BlogContent_page',
            )
        ));
    }

    public function actionIndex($user_id)
    {
        $this->rssFeed = new UserRssChannel($user_id);
        $this->userId = $user_id;
        $this->listDataProvider = $this->getListDataProvider($user_id);
        $this->owner = \User::model()->findByPk($user_id);
        $this->render('list');
    }

}

?>
