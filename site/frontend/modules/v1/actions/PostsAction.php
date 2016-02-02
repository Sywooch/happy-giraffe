<?php

namespace site\frontend\modules\v1\actions;

use site\frontend\modules\posts\models\Content;
use site\frontend\modules\v1\helpers\HtmlParser;
use site\frontend\modules\v1\helpers\ApiLog;
use site\frontend\modules\analytics\models\PageView;
use site\frontend\modules\v1\models\PageViewMemory;

class PostsAction extends RoutedAction implements IPostProcessable, IViewIncrementable
{
    public function run()
    {
        $this->route('getPosts', 'postPost', 'updatePost', 'deletePost');
    }

    public function getPosts()
    {
        $this->controller->get(Content::model(), $this);
    }

    public function viewsIncrement()
    {
        if (\Yii::app()->request->getParam('id', null)) {
            $url = preg_replace("/http:\/\/www.*\.ru/", "", $this->controller->data[0]['url']);

            //ApiLog::i($url);

            $pageViewMemory = PageViewMemory::model()->findByPk(PageViewMemory::getId($this->controller->identity->getId(), $url));

            if ($pageViewMemory) {
                if ($pageViewMemory->isTimeOut()) {
                    $pageViewMemory->refresh();
                    PageView::getModel($url)->incVisits(1);
                    return true;
                }
            } else {
                PageViewMemory::model()->create($this->controller->identity->getId(), $url);
                PageView::getModel($url)->incVisits(1);
                return true;
            }
        }

        return false;
    }

    /**
     * HTML Format, Views Counter Increment
     *
     * @param $data
     */
    public function postProcessing(&$data)
    {
        \Yii::import('ext.SimpleHTMLDOM.SimpleHTMLDOM');

        for ($i = 0; $i < count($data); $i++) {
            $data[$i]['html'] = HtmlParser::handleHtml($data[$i]['html'], $data[$i])->outertext;
            $data[$i]['preview'] = HtmlParser::handleHtml($data[$i]['preview'])->outertext;

            $url = preg_replace("/http:\/\/www.*\.ru/", "", $data[$i]['url']);
            //ApiLog::i($url);
            $pageView = PageView::getModel($url);
            //ApiLog::i(print_r($pageView, true));

            $data[$i]['views'] = $pageView->visits;

            /*if ($pageView) {
                $data[$i]['views'] = $pageView->visits;
            } else {
                $data[$i]['views'] = 0;
            }*/
        }
    }

    /**
     * Create or update post.
     *
     * @param int $id -> (default null) updated post id
     */
    public function handlePost($id = null)
    {
        $contest_id = \Yii::app()->request->getPost('contest_id');

        //\Yii::app()->cache->flush();

        if (\Yii::app()->request->getPost('type', null) != null) {
            $type = \Yii::app()->request->getPost('type');
        } else if (\Yii::app()->request->getPut('type', null) != null) {
            $type = \Yii::app()->request->getPut('type');
        } else {
            $this->controller->setError("typeMissing", 400);
            return;
        }

        if ($type == "forum") {
            $model = $id == null ? new \CommunityContent() : \CommunityContent::model()->findByPk($id);
            $model->scenario = 'default_club';
        } else {
            $model = $id == null ? new \BlogContent() : \BlogContent::model()->findByPk($id);
            $model->scenario = 'default';
            //ApiLog::i(get_class($model));
        }

        //$this->detach('Rabbit', $model);
        \Yii::app()->params['is_api_request'] = true;

        $new = $model->isNewRecord;

        if ($model == null) {
            $this->controller->setError('PostNotFound', 404);
        } else {
            if ($model->type_id == \CommunityContent::TYPE_STATUS) {
                $model->scenario = 'status';
            }

            if ($id == null) {
                $required = array(
                    'type_id' => true,
                    'title' => true,
                    'rubric_id' => $model instanceof \BlogContent ? false : true,
                    'text' => true,
                    'type' => true,
                    'photos' => false,
                    'link' => false
                );
            } else {
                if (!$this->checkAccess($model->author_id, $this->controller->identity->getId())) {
                    $this->controller->setError("NotAllowed", 403);
                    return;
                }

                $required = array(
                    'title' => true,
                    'text' => true,
                    'rubric_id' => $model instanceof \BlogContent ? false : true,
                    'photos' => false,
                    'link' => false
                );
            }

            if ($this->controller->checkParams($required)) {
                $params = $this->controller->getParams($required);
                if ($id == null) {
                    $model->attributes = array(
                        'type_id' => $params['type_id'],
                        'title' => $params['title'],
                        'rubric_id' => $model instanceof \BlogContent ? null : $params['rubric_id'],
                        'author_id' => $this->controller->identity->getId(),
                    );

                    /*if (!$this->checkAccess($params['author_id'], $this->controller->identity->getId())) {
                        $this->controller->setError("NotAllowed", 403);
                        return;
                    }*/
                } else {
                    $model->attributes = array(
                        'title' => $params['title'],
                        'text' => $params['text'],
                        'rubric_id' => $model instanceof \BlogContent ? null : $params['rubric_id'],
                    );
                }

                $names = array(
                    1 => array(
                        'name' => 'CommunityPost',
                        'filter' => array('text' => 'text')
                    ),
                    2 => array(
                        'name' => 'CommunityVideo',
                        'filter' => array('text' => 'text', 'link' => 'link'),
                    ),
                    3 => array(
                        'name' => 'CommunityPhotoPost',
                        'filter' => array('text' => 'text', 'photos' => 'photos'),
                    ),
                );

                $slaveModelName = $names[$model->type_id]['name'];
                $slaveParams = $this->controller->getFilteredParams($params, $names[$model->type_id]['filter'], false);

                $slaveModel = $id == null ? new $slaveModelName() : $model->content;
                if ($contest_id !== null) {
                    $slaveModel->isContestWork = true;
                }
                $slaveModel->attributes = $slaveParams;

                $slug = $model->type->slug;

                $model->$slug = $slaveModel;

                try {
                    if ($contest_id !== null) {
                        $contestWork = new \CommunityContestWork();
                        $contestWork->contest_id = $contest_id;
                        $model->contestWork = $contestWork;
                        $success = $model->withRelated->save(true, array(
                            $slug,
                            'contestWork',
                        ));
                    } else {
                        $success = $model->withRelated->save(true, array($slug));
                    }

                    if ($success) {
                        $this->controller->data = $model;
                        //ApiLog::i(get_class($model));
                    } else {
                        $this->controller->setError('SavingFailed', 500);
                    }
                } catch (Exception $e) {
                    $this->controller->setError($e->getMessage(), 500);
                }
            } else {
                $this->controller->setError('ParamsMissing', 400);
            }
        }
    }

    public function postPost()
    {
        $this->handlePost();
    }

    public function updatePost()
    {
        $required = array(
            'id' => true
        );

        if ($this->controller->checkParams($required)) {
            $id = $this->controller->getParams($required)['id'];

            $this->handlePost($id);
        } else {
            $this->controller->setError("ParamsMissing", 400);
            return;
        }
    }

    /*public function actionRemove()
    {
        $id = Yii::app()->request->getPost('id');
        $post = BlogContent::model()->findByPk($id);
        if (! $post->canEdit())
            throw new CHttpException(403);

        $post->delete();
        $success = true;
        $response = compact('success');
        echo CJSON::encode($response);
    }

    public function actionRestore()
    {
        $id = Yii::app()->request->getPost('id');
        $success = BlogContent::model()->resetScope()->findByPk($id)->restore();
        $response = compact('success');
        echo CJSON::encode($response);
    }*/

    public function deletePost()
    {
        $required = array(
            'id' => true,
            'type' => true
        );

        if ($this->controller->checkParams($required)) {
            $params = $this->controller->getParams($required);

            switch ($params['type']) {
                case "blog":
                    $post = \BlogContent::model()->findByPk($params['id']);
                    break;
                case "forum":default:
                    $post = \CommunityContent::model()->findByPk($params['id']);
            }

            if (!$this->checkAccess($post->author_id, $this->controller->identity->getId())) {
                $this->controller->setError("NotAllowed", 403);
                return;
            }

            try {
                if ($post->removed == 0) {
                    $post->delete();
                } else {
                    $post->restore();
                }
                $this->controller->data = $post;
            } catch (Eception $ex) {
                $this->controller->setError("DeleteFailed", 500);
            }
        } else {
            $this->controller->setError("ParamsMissing", 400);
        }
    }

    public function checkAccess($author_id, $user_id)
    {
        return $author_id == $user_id;
    }
}