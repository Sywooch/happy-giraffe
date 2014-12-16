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
    public $hideUserAdd = false;
    protected $_user = null;
    protected $_leftPost = null;
    protected $_rightPost = null;

    public function actionView($content_id)
    {
        // Отработка сигналов
        \site\frontend\modules\notifications\behaviors\ContentBehavior::$active = true;
        /** @todo добавить условие byService для полноценного использования индекса */
        $this->post = Content::model()->byEntity('CommunityContent', $content_id)->find();
        // Отключим обработку сигналов, что бы на следующий и предыдущий пост сигналы оставались непрочитанными
        \site\frontend\modules\notifications\behaviors\ContentBehavior::$active = true;
        if (!$this->post || $this->post->parsedUrl !== \Yii::app()->request->requestUri)
            throw new \CHttpException(404);
        $this->render('view');
    }

    public function getUser()
    {
        if (is_null($this->_user))
        {
            $this->_user = \site\frontend\components\api\models\User::model()->query('get', array(
                'id' => $this->post->authorId,
                'avatarSize' => \Avatar::SIZE_MEDIUM,
            ));
        }

        return $this->_user;
    }

    public function getLeftPost()
    {
        if (is_null($this->_leftPost))
        {
            $this->_leftPost = Content::model()->cache(3600)->byService('oldBlog')->leftFor($this->post)->find();
        }

        return $this->_leftPost;
    }

    public function getRightPost()
    {
        if (is_null($this->_rightPost))
        {
            $this->_rightPost = Content::model()->cache(3600)->byService('oldBlog')->rightFor($this->post)->find();
        }

        return $this->_rightPost;
    }
}

?>
