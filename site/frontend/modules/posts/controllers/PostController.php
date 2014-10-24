<?php

namespace site\frontend\modules\posts\controllers;

use site\frontend\modules\posts\models\Content;

/**
 * Description of PostController
 *
 * @author Кирилл
 * @property \site\frontend\modules\posts\models\Content $post Открытый пост
 */
class PostController extends \LiteController
{

    public $litePackage = 'posts';
    public $layout = '/layouts/newBlogPost';
    public $post = null;
    protected $_user = null;

    public function actionView($content_id)
    {
        $this->post = Content::model()->byEntity('CommunityContent', $content_id)->find();
        /** @todo Проверять правильность урла тут */
        /* if (!$this->post || $this->post->url !== \Yii::app()->request->hostinfo . \Yii::app()->request->requestUri)
          throw new \CHttpException(404); */
        $this->render('view');
    }

    public function getUser()
    {
        if (is_null($this->_user))
        {
            $this->_user = \site\frontend\components\api\models\User::model()->findByPk($this->post->authorId);
        }

        return $this->_user;
    }

}

?>
