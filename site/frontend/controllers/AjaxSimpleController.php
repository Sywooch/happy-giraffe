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
    public function filters()
    {
        return array(
            'ajaxOnly',
            'accessControl',
        );
    }

    public function accessRules()
    {
        return array(
            array('deny',
                'actions' => array('*'),
                'users' => array('?'),
            ),
        );
    }

    public function actionView()
    {
        //PostRating::reCalcFromViews($model);
    }

    public function actionLike()
    {
        if (Yii::app()->user->isGuest)
            Yii::app()->end();
        $entity_id = Yii::app()->request->getPost('entity_id');
        $entity = Yii::app()->request->getPost('entity');

        $model = $entity::model()->findByPk($entity_id);
        if ($model->author_id != Yii::app()->user->id) {
            HGLike::model()->saveByEntity($model);
            echo CJSON::encode(array('status' => true));
        } else
            echo CJSON::encode(array('status' => false));

        PostRating::reCalc($model);
    }

    /**
     * Репост записи
     */
    public function actionRepostCreate()
    {
        $data = Yii::app()->request->getPost('Repost');
        $source = CommunityContent::model()->resetScope()->findByPk($data['model_id']);
        $model = new CommunityContent();
        $model->source_id = $source->id;
        $model->type_id = CommunityContent::TYPE_REPOST;
        $model->author_id = Yii::app()->user->id;
        if (!empty($data['rubric_id']))
            $model->rubric_id = $data['rubric_id'];
        $model->title = $source->title;
        $model->preview = trim(strip_tags($data['note']));
        if ($model->save()){
            $response = array('success' => true);
            PostRating::reCalc($source);
        }
        else
            $response = array('success' => false, 'errors'=>$model->getErrorsText());
        echo CJSON::encode($response);
    }

    /**
     * Удалить репост
     */
    public function actionRepostDelete()
    {
        $source = CommunityContent::model()->findByPk(Yii::app()->request->getPost('modelId'));
        $model = CommunityContent::model()->find('source_id=:source_id AND author_id=:author_id', array(
            'source_id' => $source->id,
            'author_id' => Yii::app()->user->id,
        ));
        if ($model)
            Yii::app()->db->createCommand()->delete('community__contents', 'id=' . $model->id);

        echo CJSON::encode(array('success' => true));
        PostRating::reCalc($source);
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
                'data' => Comment::getOneCommentViewData($comment, false)
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
                'editHtml' => $comment->forEdit->text,
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
        if (!Yii::app()->user->isGuest) {
            $comment_id = Yii::app()->request->getPost('id');
            $comment = $this->loadComment($comment_id);
            if ($comment->author_id != Yii::app()->user->id)
                HGLike::model()->saveByEntity($comment);

            echo CJSON::encode(array('status' => true));
        }
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

    public function actionUploadPhoto()
    {
        foreach ($_FILES as $file)
            $model = AlbumPhoto::model()->createUserTempPhoto($file);

        echo CJSON::encode(array(
            'status' => 200,
            'id' => $model->id,
            'html' => $model->getWidget(true),
            'url' => $model->getPreviewUrl(480, 250, Image::WIDTH),
        ));
    }

    public function actionUploadAvatar()
    {
        foreach ($_FILES as $file)
            $model = AlbumPhoto::model()->createUserTempPhoto($file);

        list($width, $height) = getimagesize($model->getOriginalPath());
        $model->getPreviewUrl(200, 200, false, true);
        echo CJSON::encode(array(
            'status' => 200,
            'id' => $model->id,
            'image_url' => $model->getOriginalUrl(),
            'width' => $width,
            'height' => $height,
        ));
    }

    public function actionAddPhoto()
    {
        $photos = AlbumPhoto::model()->findAllByPk(Yii::app()->request->getPost('photo_ids'));
        $album = Album::model()->findByPk(Yii::app()->request->getPost('album_id'));
        if (empty($album))
            $album = Album::getAlbumByType(Yii::app()->user->id, Album::TYPE_PRIVATE);

        if ($album->author_id == Yii::app()->user->id)
            foreach ($photos as $photo) {
                if ($photo->author_id == Yii::app()->user->id) {
                    $photo->album_id = $album->id;
                    $photo->hidden = 0;
                    $photo->save();
                }
            }

        echo CJSON::encode(array('status' => true, 'redirectUrl' => $this->createUrl('/gallery/user/view', array('user_id' => Yii::app()->user->id, 'album_id' => $album->id))));
    }

    public function actionClubToggle()
    {
        $club_id = Yii::app()->request->getPost('club_id');
        UserClubSubscription::toggle($club_id);
        echo CJSON::encode(array('status' => true));
    }

    public function actionAlbumValidate()
    {
        $errors = array();
        if (isset($_POST['AlbumPhoto']['id']) && empty($_POST['AlbumPhoto']['id']))
            $errors ['AlbumPhoto_id'] = array('Добавьте хотя бы одну фотографию');

        echo CJSON::encode($errors);
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