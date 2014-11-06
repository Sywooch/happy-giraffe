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
    protected $_leftPost = null;
    protected $_rightPost = null;

    public function actionView($content_id)
    {
        $this->post = Content::model()->byEntity('CommunityContent', $content_id)->find();
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

    public function actionSinglePhoto($user_id, $content_id, $photo_id)
    {
        $oldPhoto = \AlbumPhoto::model()->with('newPhoto')->findByPk($photo_id);
        if ($oldPhoto === null || $oldPhoto->newPhoto === null) {
            throw new \CHttpException(404);
        }

        $post = \CommunityContent::model()->with('author')->findByPk($content_id);
        if ($post === null || $post->author_id != $user_id) {
            throw new \CHttpException(404);
        }


        $this->breadcrumbs = array(
            $this->widget('Avatar', array('user' => $post->author, 'size' => \Avatar::SIZE_MICRO, 'tag' => 'span'), true) => array(),
            'Блог' => array('/posts/list/index', 'user_id' => $user_id),
            $post->title => $post->getUrl(),
        );

        $collection = $post->getPhotoCollection();
        \site\frontend\modules\photo\components\SinglePhotoRenderer::render($collection, $oldPhoto->newPhoto);
    }
}

?>
