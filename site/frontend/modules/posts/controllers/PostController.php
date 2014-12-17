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
    public $hideUserAdd = true;
    protected $_user = null;
    protected $_leftPost = null;
    protected $_rightPost = null;

    /**
     * @sitemap dataSource=sitemapView
     */
    public function actionView($content_id)
    {
        /** @todo добавить условие byService для полноценного использования индекса */
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

    public function sitemapView($param)
    {
        $criteria = new \CDbCriteria(array(
            'condition' => 'isNoindex = 0',
            'limit' => 50000,
            'offset' => ($param['page'] - 1) * 50000,
            'order' => 'id ASC',
        ));
        Content::model()->byService($param['service'])->applyScopes($criteria);
        $command = \Yii::app()->db->getCommandBuilder()->createFindCommand(Content::model()->tableName(), $criteria);
        $models = $command->queryAll();
        return array_map(function($model) {
            return array(
                'loc' => $model['url'],
                'lastmod' => date(DATE_W3C, $model['dtimeUpdate']),
            );
        }, $models);
    }
}

?>
