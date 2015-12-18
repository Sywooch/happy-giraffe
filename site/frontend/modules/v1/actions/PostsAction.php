<?php

namespace site\frontend\modules\v1\actions;

use site\frontend\modules\posts\models\Content;

class PostsAction extends RoutedAction implements IPostProcessable
{
    public function run()
    {
        $this->route('getPosts', 'postPost', 'updatePost', 'deletePost');
    }

    public function getPosts()
    {
        $this->controller->get(Content::model(), $this);
    }

    /**
     * HTML Format
     *
     * @param $data
     */
    public function postProcessing(&$data)
    {
        \Yii::import('ext.SimpleHTMLDOM.SimpleHTMLDOM');

        //\Yii::log(print_r($data, true), 'info', 'api');

        /**@todo: clear*/
        for ($i = 0; $i < count($data); $i++) {
            $data[$i]['html'] = $this->handleHtml($data[$i]['html'], $data[$i])->outertext;
            $data[$i]['preview'] = $this->handleHtml($data[$i]['preview'])->outertext;
        }
    }

    private function handleHtml($html, &$data = null) {
        $simpleDom = new \SimpleHTMLDOM();
        $html = $simpleDom->str_get_html($html);

        foreach ($html->find('img') as $smile) {
            $smile->outertext = '<smile>' . $smile->src . '</smile>';
        }
        $html->load($html->save());

        foreach ($html->find('iframe') as $video) {
            $video->outertext = '<video>' . $video->src . '</video>';
        }
        $html->load($html->save());

        foreach ($html->find('picture') as $picture) {
            $picture->outertext = '<image>' . $picture->first_child()->srcset . '</image>';
        }
        $html->load($html->save());

        /*foreach ($html->find('a') as $link) {
            $link->outertext = '<link><src>' . $link->href . '</src><title>' . $link->innertext . '</title></link>';
        }
        $html->load($html->save());*/

        foreach ($html->find('comment') as $comment) {
            $comment->outertext = '';
        }
        $html->load($html->save());

        if ($data != null) {
            foreach ($html->find('photo-collection') as $collection) {
                $data['photo-collection'] = "{" . $collection->params . "}";
                $collection->outertext = '';
            }
            $html->load($html->save());
        }

        $this->clearTags($html, 'div[class=b-article_in-img]');

        /*$tags = array('div', 'strong', 'del', 'em', 'b', 'u', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6',);

        foreach ($tags as $key => $tag) {
            $this->clearTags($html, $tag);
            //\Yii::log((string)$html, 'info', 'api');
        }*/

        //\Yii::log(print_r($html->nodes, true), 'info', 'api');

        $html->load($html->save());

        return $html;
    }

    /**
     * Delete all tag from html without deleting inner text.
     *
     * @param $html
     * @param $tag
     */
    private function clearTags(&$html, $tag)
    {
        $tags = $html->find($tag);

        if ($tags == null) {
            //\Yii::log($tag . ' is null', 'info', 'api');
            return;
        }

        for ($i = count($tags) - 1; $i >= 0; $i--) {
            //\Yii::log($tag . ' outer text ' . $tags[$i]->outertext, 'info', 'api');
            //\Yii::log($tag . ' inner text ' . $tags[$i]->innertext, 'info', 'api');
            $tags[$i]->outertext = $tags[$i]->innertext;
            //\Yii::log($tag . ' outer text after changes ' . $tags[$i]->outertext, 'info', 'api');
        }

        $html->load($html->save());

        return $html;
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
                    'rubric_id' => true,
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
                    'rubric_id' => true,
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
                        'rubric_id' => $params['rubric_id'],
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
                        'rubric_id' => $params['rubric_id']
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