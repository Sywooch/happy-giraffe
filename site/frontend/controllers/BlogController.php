<?php
/**
 * Author: choo
 * Date: 26.03.2012
 */
class BlogController extends Controller
{
    public $user;
    public $rubric_id;

    public function getUrl($overwrite = array(), $route = 'blog/list')
    {
        return array_filter(CMap::mergeArray(
            array($route),
            array(
                'user_id' => $this->user->id,
                'rubric_id' => $this->rubric_id,
            ),
            $overwrite
        ));
    }

    public function actionAdd($content_type_slug = 'post')
    {
        $content_type = CommunityContentType::model()->findByAttributes(array('slug' => $content_type_slug));
        $model = new BlogContent;
        $model->author_id = Yii::app()->user->id;
        $model->type_id = $content_type->id;
        $slave_model_name = 'Community' . ucfirst($content_type->slug);
        $slave_model = new $slave_model_name;
        $rubrics = Yii::app()->user->model->blog_rubrics;

        if (isset($_POST['BlogContent'], $_POST[$slave_model_name]))
        {
            $model->attributes = $_POST['BlogContent'];
            $slave_model->attributes = $_POST[$slave_model_name];

            if (empty($_POST['BlogContent']['rubric_id'])) {
                $rubric = CommunityRubric::model()->findByAttributes(array(
                    'name' => $_POST['rubricName'],
                ));

                if ($rubric === null)  {
                    $rubric = new CommunityRubric;
                    $rubric->name = $_POST['rubricName'];
                    $rubric->user_id = Yii::app()->user->id;
                    $rubric->save();
                }
                $model->rubric_id = $rubric->id;
            }

            $valid = $model->validate();
            $valid = $slave_model->validate() && $valid;

            if ($valid)
            {
                $model->save(false);
                $slave_model->content_id = $model->id;
                $slave_model->save(false);
                $this->redirect(array('/blog/view', 'content_id' => $model->id));
            }
        }

        $this->render('form', array(
            'model' => $model,
            'slave_model' => $slave_model,
            'rubrics' => $rubrics,
            'content_type_slug' => $content_type->slug,
        ));
    }

    public function actionEdit($content_id)
    {
        $model = BlogContent::model()->full()->findByPk($content_id);
        if ($model === null)
            throw CHttpException(404, 'Запись не найдена');

        $content_type = $model->type;
        $slave_model = $model->content;
        $slave_model_name = get_class($slave_model);
        $rubrics = Yii::app()->user->model->blog_rubrics;

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
                $this->redirect(array('/blog/view', 'content_id' => $model->id));
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
        $this->layout = '//layouts/user_blog';

        $this->user = User::model()->findByPk($user_id);
        if ($this->user === null)
            throw new CHttpException(404, 'Пользователь не найден');

        $contents = BlogContent::model()->getBlogContents($user_id, $rubric_id);

        $this->rubric_id = $rubric_id;

        $this->render('list', array(
            'contents' => $contents,
        ));
    }

    public function actionView($content_id)
    {
        $this->layout = '//layouts/user_blog';

        $content = BlogContent::model()->active()->full()->findByPk($content_id);
        if ($content === null)
            throw new CHttpException(404, 'Такой записи не существует');

        $this->user = $content->author;
        $this->rubric_id = $content->rubric->id;

        if ($content->author_id == Yii::app()->user->id) {
            UserNotification::model()->deleteByEntity(UserNotification::NEW_COMMENT, $content);
            UserNotification::model()->deleteByEntity(UserNotification::NEW_REPLY, $content);
        }

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
}
