<?php

class UserController extends Controller
{
    public $layout = '//layouts/user';
    public $user;
    public $rubric_id;
    public $content_type_slug;

    public function actionProfile($user_id)
    {
        $this->layout = '//layouts/main';
        Yii::import('application.widgets.user.*');
        Yii::import('application.modules.Interests.models.*');
        Yii::import('application.modules.geo.models.*');

        $user = User::model()->with(array(
            'status',
            'purpose',
        ))->findByPk($user_id);
        if ($user === null)
            throw new CHttpException(404, 'Пользователь не найден');
        if (! $user->calculateAccess('profile_access', Yii::app()->user->id))
            throw new CHttpException(403, 'Вы не можете просматривать страницу этого пользователя');

        $this->render('profile', array(
            'user' => $user,
        ));
    }

    public function actionBlog($user_id, $rubric_id = null)
    {
        $this->layout = '//layouts/user_blog';
        $this->user = User::model()->with('blog_rubrics')->findByPk($user_id);
        if ($this->user === null)
            throw CHttpException(404, 'Клуб не найден');
        $this->rubric_id = $rubric_id;

        $contents = CommunityContent::model()->getBlogContents($user_id, $rubric_id);
        $this->render('blog', array(
            'contents' => $contents,
        ));
    }

    public function getUrl($overwrite = array(), $route = 'user/blog')
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

    /*
     * @todo убрать $model->refresh()
     */
    public function actionCreateRelated($relation)
    {
        if (Yii::app()->request->isAjaxRequest) {
            $entity = 'User' . ucfirst($relation);
            $model = new $entity;
            $model->user_id = Yii::app()->user->id;
            $model->text = Yii::app()->request->getPost('text');
            if ($model->save()) {
                $model->refresh();
                $response = array(
                    'status' => true,
                    'html' => $this->renderPartial('application.widgets.user.views._' . $relation, array(
                        $relation => $model,
                        'canUpdate' => true,
                    ), true),
                );
            } else {
                $response = array(
                    'status' => false,
                );
            }
            echo CJSON::encode($response);
        }
    }

    public function actionUpdateMood()
    {
        if (Yii::app()->request->isAjaxRequest) {
            $user = Yii::app()->user->model;
            $user->mood_id = Yii::app()->request->getPost('mood_id');
            if ($user->save(true, array('mood_id'))) {
                echo $this->renderPartial('application.widgets.user.views._mood', array(
                    'mood' => $user->mood,
                    'canUpdate' => true,
                ));
            }
            else {
                print_r($user->errors);
            }
        }
    }
}
