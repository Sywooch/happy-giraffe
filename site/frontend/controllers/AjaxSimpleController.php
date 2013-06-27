<?php
/**
 * Class AjaxSimpleController
 *
 * Собраны различные действия, которые должны быстро отрабатывать через ajax
 *
 * @author Alex Kireev <alexk984@gmail.com>
 */
class AjaxSimpleController extends CController
{
    /**
     * Счетчик посещений из ПС. Нужен для модуля комментаторов
     * @throws CHttpException
     */
    public function actionCounter()
    {
        if (!Yii::app()->request->isAjaxRequest)
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');

        Yii::import('site.seo.models.*');

        $referrer = Yii::app()->request->getPost('referrer');
        $page_url = Yii::app()->request->urlReferrer;
        if (empty($referrer) || empty($page_url) || strpos('http://www.happy-giraffe.ru/', $referrer) === 0)
            Yii::app()->end();

        if (strpos($referrer, 'http://') === 0)
            $referrer = str_replace('http://', '', $referrer);
        if (strpos($referrer, 'https://') === 0)
            $referrer = str_replace('https://', '', $referrer);
        if (strpos($referrer, 'www.') === 0)
            $referrer = str_replace('www.', '', $referrer);

        $se_list = SearchEngine::model()->cache(3600)->findAll();

        foreach ($se_list as $se)
            if (strpos($referrer, $se->url) === 0)
                PageSearchView::model()->inc($page_url);
    }

    public function actionLike()
    {
        $entity_id = Yii::app()->request->getPost('entity_id');
        $entity = Yii::app()->request->getPost('entity');

        $model = $entity::model()->findByPk($entity_id);
        if ($model->author_id != Yii::app()->user->id) {
            HGLike::model()->saveByEntity($model);
            echo CJSON::encode(array('status' => true));
        } else
            echo CJSON::encode(array('status' => false));
    }

    public function actionRepost()
    {

    }

    /**
     * Учет кликов комментаторов по кнопкам лайков Facebook и Vk
     * @throws CHttpException
     */
    public function actionCommentatorLike()
    {
        if (!Yii::app()->request->isAjaxRequest
            || Yii::app()->user->isGuest
            || Yii::app()->user->model->group == UserGroup::USER
            || !Yii::app()->user->checkAccess('commentator_panel')
        )
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');

        $entity = Yii::app()->request->getPost('entity');
        $entity_id = Yii::app()->request->getPost('entity_id');
        $social_id = Yii::app()->request->getPost('social_id');

        Yii::import('site.frontend.modules.signal.models.*');
        Yii::import('site.seo.modules.commentators.models.*');
        Yii::import('site.seo.models.*');
        CommentatorLike::addCurrentUserLike($entity, $entity_id, $social_id);
    }

    /**
     * Добавление нового комментария
     */
    public function actionAddComment()
    {
        Yii::import('site.frontend.modules.services.modules.recipeBook.models.*');
        Yii::import('site.frontend.modules.route.models.*');

        $comment = new Comment;
        $comment->attributes = $_POST;
        $comment->author_id = Yii::app()->user->id;
        $comment->scenario = 'default';

        if ($comment->save()) {
            $comment->refresh();
            $response = array(
                'status' => true,
                'data' => Comment::getOneCommentViewData($comment)
            );
        } else {
            $response = array(
                'status' => false,
                'message' => $comment->getErrorsText()
            );
        }
        echo CJSON::encode($response);
    }

    /**
     * Редактирование комментария
     */
    public function actionEditComment()
    {
        Yii::import('site.frontend.modules.services.modules.recipeBook.models.*');
        Yii::import('site.frontend.modules.route.models.*');

        $comment = $this->loadComment(Yii::app()->request->getPost('id'));
        $comment->text = Yii::app()->request->getPost('text');

        if ($comment->save()) {
            $comment->refresh();
            $response = array(
                'status' => true,
                'text' => $comment->text,
            );
        } else {
            $response = array(
                'status' => false,
                'message' => $comment->getErrorsText()
            );
        }
        echo CJSON::encode($response);
    }

    /**
     * Лайк комментария
     */
    public function actionCommentLike()
    {
        $comment_id = Yii::app()->request->getPost('id');
        $comment = $this->loadComment($comment_id);
        if ($comment->author_id != Yii::app()->user->id)
            HGLike::model()->saveByEntity($comment);

        echo CJSON::encode(array('status' => true));
    }

    /**
     * Удаление комментария
     */
    public function actionDeleteComment()
    {
        $comment_id = Yii::app()->request->getPost('id');
        $comment = $this->loadComment($comment_id);
        if (Yii::app()->user->model->checkAuthItem('removeComment') || Yii::app()->user->id == $comment->author_id || $comment->isEntityAuthor(Yii::app()->user->id))
            $comment->delete();

        echo CJSON::encode(array('status' => true));
    }

    /**
     * Восстановление удаленного комментария
     */
    public function actionRestoreComment()
    {
        $comment_id = Yii::app()->request->getPost('id');
        $comment = $this->loadComment($comment_id);
        if (Yii::app()->user->model->checkAuthItem('removeComment') || Yii::app()->user->id == $comment->author_id || $comment->isEntityAuthor(Yii::app()->user->id))
            $comment->restore();

        echo CJSON::encode(array('status' => true));
    }

    /**
     * Загрузка нового комментария
     *
     * @param int $id model id
     * @return Comment
     * @throws CHttpException
     */
    public function loadComment($id)
    {
        $model = Comment::model()->resetScope()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');
        return $model;
    }
}