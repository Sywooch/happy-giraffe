<?php
/**
 * Author: choo
 * Date: 26.03.2012
 */
class BlogController extends HController
{
    /**
     * @var User
     */
    public $user;
    public $rubric_id;

    public function filters()
    {
        return array(
            'accessControl',
            array(
                'CHttpCacheFilter + view',
                'lastModified' => $this->lastModified(),
            ),
//            array(
//                'COutputCache + view',
//                'duration' => 300,
//                'varyByParam' => array('content_id', 'Comment_page'),
//                'varyByExpression' => Yii::app()->user->id . $this->lastModified(),
//            ),
        );
    }

    public function accessRules()
    {
        return array(
            array('allow',
                'actions'=>array('list', 'view'),
                'users' => array('*'),
            ),
            array('allow',
                'users' => array('@'),
            ),
            array('deny',
                'users' => array('*'),
            ),
        );
    }

    public function getUrl($overwrite = array(), $route = 'blog/list')
    {
        $params = array_filter(CMap::mergeArray(
            array(
                'user_id' => $this->user->id,
                'rubric_id' => isset($this->actionParams['rubric_id']) ? $this->actionParams['rubric_id'] : null,
                'content_type_slug' => isset($this->actionParams['content_type_slug']) ? $this->actionParams['content_type_slug'] : null,
            ),
            $overwrite
        ));

        return $this->createUrl($route, $params);
    }

    public function actionAdd($user_id = null, $content_type_slug = 'post', $rubric_id = null)
    {
        $content_type = CommunityContentType::model()->findByAttributes(array('slug' => $content_type_slug));
        $model = new BlogContent('default');
        $model->author_id = Yii::app()->user->id;
        $model->type_id = $content_type->id;
        $model->rubric_id = $rubric_id;
        $slave_model_name = 'Community' . ucfirst($content_type->slug);
        $slave_model = new $slave_model_name;
        $rubric_model = new CommunityRubric;

        $rubrics = Yii::app()->user->model->blog_rubrics;

        if (isset($_POST['BlogContent'], $_POST[$slave_model_name]))
        {
            $model->attributes = $_POST['BlogContent'];
            $slave_model->attributes = $_POST[$slave_model_name];

            if ($_POST['CommunityRubric']['title'] != '') {
                $existingRubric = CommunityRubric::model()->findByAttributes(array('user_id' => Yii::app()->user->id, 'title' => $_POST['CommunityRubric']['title']));
                if ($existingRubric === null) {
                    $rubric_model->user_id = Yii::app()->user->id;
                    $rubric_model->title = $_POST['CommunityRubric']['title'];
                    $rubric_model->save();
                } else {
                    $rubric_model = $existingRubric;
                }
                $model->rubric_id = $rubric_model->id;
            }

            $valid = $model->validate();
            $valid = $slave_model->validate() && $valid;

            if ($valid)
            {
                $transaction = Yii::app()->db->beginTransaction();
                try {
                    $success = $model->save(false);
                    if ($success){
                        $slave_model->content_id = $model->id;
                        $success = $slave_model->save(false);
                        if (!$success)
                            $transaction->rollback();
                        else{
                            $transaction->commit();

                            $model->sendEvent();
                            $this->redirect($model->url);
                        }
                    }
                    else
                        $transaction->rollback();
                } catch (Exception $e) {
                    $transaction->rollback();
                }
            }
        }

        if (isset($_POST['redirectUrl']))
            $redirectUrl = $_POST['redirectUrl'];
        else
            $redirectUrl =Yii::app()->request->urlReferrer;

        $this->render('form', array(
            'model' => $model,
            'slave_model' => $slave_model,
            'rubric_model' => $rubric_model,
            'rubrics' => $rubrics,
            'content_type_slug' => $content_type->slug,
            'redirectUrl'=>$redirectUrl
        ));
    }

    public function actionEdit($content_id)
    {
        $this->meta_title = 'Редактирование записи';
        $model = BlogContent::model()->findByPk($content_id);
        $model->scenario = 'default';
        if ($model === null)
            throw new CHttpException(404, 'Запись не найдена');

        //если не имеет прав на редактирование
        if ($model->author_id != Yii::app()->user->id && ! Yii::app()->authManager->checkAccess('editBlogContent', Yii::app()->user->id))
            throw new CHttpException(404, 'Запись не найдена.');

        //уволенный сотрудник
        if (UserAttributes::isFiredWorker(Yii::app()->user->id, $model->created))
            throw new CHttpException(404, 'Запись не найдена.');

        $content_type = $model->type;
        $slave_model = $model->content;
        $slave_model_name = get_class($slave_model);
        $rubrics = $model->author->blog_rubrics;

        if (isset($_POST['BlogContent'], $_POST[$slave_model_name]))
        {
            $model->attributes = $_POST['BlogContent'];
            $slave_model->attributes = $_POST[$slave_model_name];

            $valid = $model->validate();
            $valid = $slave_model->validate() && $valid;

            if ($valid)
            {
                $model->save(false);
                $slave_model->content_id = $model->id;
                $slave_model->save(false);
                $this->redirect($model->url);
            }
        }

        $this->render('form', array(
            'model' => $model,
            'slave_model' => $slave_model,
            'rubrics' => $rubrics,
            'content_type_slug' => $content_type->slug,
        ));
    }

    public function actionList($user_id, $rubric_id = null)
    {
        //Visit::processVisit();
        $this->layout = '//layouts/user_blog';

        $this->user = User::model()->findByPk($user_id);
        if ($this->user === null)// || $this->user->deleted)
            throw new CHttpException(404, 'Пользователь не найден');
        $this->pageTitle = 'Блог';

        $contents = BlogContent::model()->getBlogContents($user_id, $rubric_id);

        $this->rubric_id = $rubric_id;

        if ($this->user->hasRssContent())
            $this->rssFeed = $this->createUrl('rss/user', array('user_id' => $user_id));
        $this->render('list', array(
            'contents' => $contents,
        ));
    }

    /**
     * @sitemap dataSource=sitemapView
     */
    public function actionView($content_id, $user_id, $lastPage = null, $ajax = null)
    {
        $this->layout = '//layouts/user_blog';
        $content = BlogContent::model()->active()->with(array('rubric', 'type', 'gallery'))->findByPk($content_id);

        if ($content === null || $content->author_id !== $user_id)// || $content->author->deleted)
            throw new CHttpException(404, 'Такой записи не существует');

        if (! preg_match('#^\/user\/(\d+)\/blog\/post(\d+)\/#', Yii::app()->request->requestUri)) {
            header("HTTP/1.1 301 Moved Permanently");
            header("Location: " . $content->url);
            Yii::app()->end();
        }

        if ($content->type_id == CommunityContentType::TYPE_STATUS)
            $this->pageTitle = strip_tags($content->status->text);
        else
            $this->pageTitle = $content->title;
        $this->registerCounter();

        $this->user = User::model()->with(array('blog_rubrics', 'blog_rubrics.contentsCount'))->findByPk($content->author_id);
        $this->rubric_id = ($content->type_id == 5) ? null : $content->rubric->id;

        if (!empty($content->uniqueness) && $content->uniqueness < 50)
            Yii::app()->clientScript->registerMetaTag('noindex', 'robots');

        //сохраняем просматриваемую модель
        NotificationRead::getInstance()->setContentModel($content);

        //проверяем переход с других сайтов по ссылкам комментаторов
        Yii::import('site.frontend.modules.signal.models.CommentatorLink');
        CommentatorLink::checkPageVisit('BlogContent', $content_id);

        $this->render('view', array(
            'data' => $content,
        ));
    }

    public function actionEmpty()
    {
        $this->layout = '//layouts/user';

        $this->user = Yii::app()->user->model;
        $this->render('empty');
    }

    public function actionDeleteBlogRubric()
    {
        $id = Yii::app()->request->getPost('id');

        $success = CommunityRubric::model()->deleteByPk($id);

        echo CJavaScript::encode($success);
    }

    public function actionAddRubric()
    {
        $title = Yii::app()->request->getPost('title');

        $model = new CommunityRubric();
        $model->title = $title;
        $model->user_id = Yii::app()->user->id;
        if ($model->save()) {
            $response = array(
                'success' => true,
                'model' => $model,
            );
        } else {
            $response = array(
                'success' => false,
                'erros' => $model->errors,
            );
        }

        echo CJSON::encode($response);
    }

    public function actionEditRubric()
    {
        $id = Yii::app()->request->getPost('id');
        $title = Yii::app()->request->getPost('title');

        $model = CommunityRubric::model()->findByPk($id);

        $model->title = $title;
        if ($model->save()) {
            $response = array(
                'success' => true,
                'model' => $model,
            );
        } else {
            $response = array(
                'success' => false,
                'erros' => $model->errors,
            );
        }

        echo CJSON::encode($response);
    }

    public function actionUpdateSort()
    {
        foreach ($_POST['rubric'] as $sort => $id)
            CommunityRubric::model()->updateByPk($id, array('sort' => $sort));
    }

    public function sitemapView()
    {
        $models = Yii::app()->db->createCommand()
            ->select('c.id, c.created, c.updated, c.author_id')
            ->from('community__contents c')
            ->join('community__rubrics r', 'c.rubric_id = r.id')
            ->join('community__content_types ct', 'c.type_id = ct.id')
            ->where('r.user_id IS NOT NULL AND c.removed = 0 AND (c.uniqueness >= 50 OR c.uniqueness IS NULL)')
            ->queryAll();

        $data = array();
        foreach ($models as $model)
        {
            $data[] = array(
                'params' => array(
                    'content_id' => $model['id'],
                    'user_id' => $model['author_id'],
                ),
                'changefreq' => 'daily',
                'lastmod' => ($model['updated'] === null) ? $model['created'] : $model['updated'],
            );
        }

        return $data;
    }

    protected function lastModified()
    {
        if (! Yii::app()->user->isGuest)
            return null;

        $content_id = Yii::app()->request->getQuery('content_id');
        $community_id = Yii::app()->request->getQuery('community_id');

        $sql = "SELECT
                    GREATEST(
                        COALESCE(MAX(c.created), '0000-00-00 00:00:00'),
                        COALESCE(MAX(c.updated), '0000-00-00 00:00:00'),
                        COALESCE(MAX(cm.created), '0000-00-00 00:00:00'),
                        COALESCE(MAX(cm.updated), '0000-00-00 00:00:00')
                    )
                FROM community__contents c
                JOIN community__rubrics r
                ON c.rubric_id = r.id
                LEFT OUTER JOIN comments cm
                ON cm.entity = 'CommunityContent' AND cm.entity_id = :content_id
                WHERE r.community_id = :community_id";

        $command = Yii::app()->db->createCommand($sql);
        $command->bindValue(':content_id', $content_id, PDO::PARAM_INT);
        $command->bindValue(':community_id', $community_id, PDO::PARAM_INT);
        $t1 = strtotime($command->queryScalar());

        //проверяем блок внутренней перелинковки
        $url = 'http://www.happy-giraffe.ru' . Yii::app()->request->getRequestUri();
        $t2 = InnerLinksBlock::model()->getUpTime($url);

        if (empty($t2))
            return $t1;

        return date("Y-m-d H:i:s", max($t1, $t2));
    }
}
