<?php
/**
 * Author: choo
 * Date: 26.03.2012
 */
class BlogController extends Controller
{
    public $user;

    public function actionAdd($content_type_slug = 'post')
    {
        $content_type = CommunityContentType::model()->findByAttributes(array('slug' => $content_type_slug));
        $model = new CommunityContent;
        $model->type_id = $content_type->id;
        $slave_model_name = 'Community' . ucfirst($content_type->slug);
        $slave_model = new $slave_model_name;
        $rubrics = Yii::app()->user->model->blog_rubrics;
        $this->render('form', array(
            'model' => $model,
            'slave_model' => $slave_model,
            'rubrics' => $rubrics,
            'content_type_slug' => $content_type_slug,
        ));
    }

    public function actionList($user_id, $rubric_id = null)
    {
        $this->user = User::model()->findByPk($user_id);
        if ($this->user === null)
            throw new CHttpException(404, 'Пользователь не найден');

        $this->layout = '//layouts/user_blog';
        $this->render('list', array(

        ));
    }

    public function actionView()
    {
        $this->layout = '//layouts/user_blog';
        $this->render('view', array(

        ));
    }
}
