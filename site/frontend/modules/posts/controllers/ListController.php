<?php

namespace site\frontend\modules\posts\controllers;

use site\frontend\modules\posts\models\Content;

/**
 * Description of ListController
 *
 * @author Кирилл
 */
class ListController extends \LiteController
{

    public $layout = 'newBlogPost';
    public $litePackage = 'posts';
    public $listDataProvider = null;
    public $hideUserAdd = true;
    public $userId;
    protected $_user = null;

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
        return new \CActiveDataProvider(Content::model()->byService('oldBlog')->byAuthor($authorId)->orderDesc(), array(
            'pagination' => array(
                'pageSize' => 10,
                'pageVar' => 'BlogContent_page',
            )
        ));
    }

    public function actionIndex($user_id)
    {
        $this->userId = $user_id;
        $this->listDataProvider = $this->getListDataProvider($user_id);
        $this->render('list');
    }

}

?>
