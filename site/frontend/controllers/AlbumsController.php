<?php
class AlbumsController extends HController
{
    public $layout = '//layouts/user';

    public $user;

    protected function beforeAction($action)
    {
        if (!Yii::app()->request->isAjaxRequest) {
            $this->pageTitle = 'Фотоальбомы';
            Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/javascripts/album.js?r=11');
            Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/stylesheets/jquery.jscrollpane.css');
            Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/javascripts/jquery.jscrollpane.min.js');
            Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/javascripts/jquery.mousewheel.js');
        }
        return parent::beforeAction($action);
    }

    public function filters()
    {
        $filters = array(
            'accessControl',
            'ajaxOnly + attachView, editDescription, editPhotoTitle, changeTitle, changePermission,
                removeUploadPhoto, communityContentEdit, communityContentSave, partnerPhoto, recipePhoto, cookDecorationPhoto,
                cookDecorationCategory, commentPhoto, crop, changeAvatar',
        );

        $entity = Yii::app()->request->getQuery('entity');
        if ($entity == 'Contest') {
            $entity_id = Yii::app()->request->getQuery('entity_id');
//            $filters[] = array(
//                'COutputCache + WPhoto',
//                'duration' => 600,
//                'varyByParam' => array('entity', 'entity_id', 'id', 'sort'),
//                'dependency' => new CDbCacheDependency(Yii::app()->db->createCommand()->select(new CDbExpression('MAX(created)'))->from('contest__works')->where("contest_id = $entity_id")->text),
//            );
//            $filters[] = array(
//                'COutputCache + postLoad',
//                'duration' => 600,
//                'varyByParam' => array('entity', 'entity_id', 'photo_id'),
//                'dependency' => new CDbCacheDependency(Yii::app()->db->createCommand()->select(new CDbExpression('MAX(created)'))->from('contest__works')->where("contest_id = $entity_id")->text),
//            );
        }

        return $filters;
    }

    public function accessRules()
    {
        return array(
            array('allow',
                'users' => array('@'),
                'actions' => array('index'),
            ),
            array('deny',
                'users' => array('*'),
                'actions' => array('index'),
            ),
            array('allow',
                'users' => array('*'),
            ),
        );
    }

    public function actionIndex($permission = false, $system = false)
    {
        $user = Yii::app()->user->model;
        $this->user = $user;
        $dataProvider = Album::model()->findByUser(Yii::app()->user->id, $permission, $system);
        $this->render('index', array(
            'dataProvider' => $dataProvider,
            'user' => $user,
            'access' => true,
        ));
    }

    public function actionUser($id)
    {
        $user = User::model()->with('avatar', 'status')->findByPk($id);
        $this->user = $user;
        if (!$user || $user->deleted)
            throw new CHttpException(404, 'Пользователь не найден');
        $scopes = !Yii::app()->user->isGuest && Yii::app()->user->id == $id ? array() : array('noSystem');
        $dataProvider = Album::model()->findByUser($id, false, false, $scopes);

        $this->layout = '//layouts/main';
        $this->render('index', array(
            'dataProvider' => $dataProvider,
            'user' => $user,
            'access' => $id == Yii::app()->user->id
        ));
    }

    public function actionView($id)
    {
        $model = Album::model()->with('author', 'author.avatar', 'author.status')->findByPk($id);

        if (!$model || $model->author->deleted)
            throw new CHttpException(404, 'Альбом не найден');
        $this->user = $model->author;

        $dataProvider = new CActiveDataProvider('AlbumPhoto', array(
            'criteria' => array(
                'condition' => 'removed = 0 and album_id = :album_id',
                'params' => array(':album_id' => $model->id),
            ),
            'pagination' => array(
                'pageSize' => !Yii::app()->user->isGuest && $model->author_id == Yii::app()->user->id ? 1000 : 20
            )
        ));

        $this->layout = '//layouts/main';

        if (Yii::app()->request->isAjaxRequest) {
            $this->render('view', compact('model', 'dataProvider'));
        } else {
            $this->render('view', compact('model', 'dataProvider'));
        }
    }

    public function actionAddPhoto($a = false, $text = false, $u = false)
    {
        if ($a && $a != 'false' && $a != 0) {
            $album = Album::model()->findByPk($a);
            if (!$album)
                throw new CHttpException(404, 'Альбом не найден');
        } else if ($text && $u) {
            if (!$album = Album::model()->findByAttributes(array('author_id' => $u, 'title' => $text))) {
                $album = new Album();
                $album->title = $text;
                $album->author_id = $u;
                $album->save();
            }
            $a = $album->id;
        } else
            $album = false;

        if (isset($_FILES['Filedata'])) {
            $file = CUploadedFile::getInstanceByName('Filedata');
            if (!in_array($file->extensionName, array('jpg', 'jpeg', 'png', 'gif', 'JPG', 'JPEG', 'PNG', 'GIF')))
                Yii::app()->end();
            $model = new AlbumPhoto();

            echo '<div id="serverData">';
            // Загрузка в новый альбом
            if (!$a || $a == 'false') {
                $model->file = $file;
                $model->saveFile(true);
                echo "<script type='text/javascript'>
                document.domain = document.location.host;
                </script>";
                echo '<p id="params">' . $model->templateUrl . '||' . $model->fs_name . '</p>';
                Yii::app()->end();
            }

            $model->album_id = $a;
            $model->author_id = $album->author_id;
            $model->file = $file;
            $model->create();

            echo '<p id="params">' . $model->originalUrl . '||' . $model->fs_name . '||' . $model->id . '</p>';
            echo CHtml::dropDownList('album_id', $album ? $album->id : false, CHtml::listData(Album::model()->findAllByAttributes(array('author_id' => $album->author_id)), 'id', 'title'), array('class' => 'chzn chzn-deselect w-200', 'id' => 'album_select', 'data-placeholder' => 'Выбрать альбом', 'empty' => '', 'onchange' => 'Album.changeAlbum(this);'));
            echo '</div>';
            Yii::app()->end();
        }

        if (Yii::app()->request->isAjaxRequest) {
            Yii::app()->clientScript->scriptMap = array(
                'jquery.js' => false,
                'jquery.min.js' => false,
                'jquery-ui.js' => false,
                'jquery-ui.min.js' => false,
                'jquery.yiilistview.js' => false,
                'jquery.ba-bbq.js' => false,
                'jquery-ui.css' => false,
            );
            $this->renderPartial('add_photo', array(
                'album' => $album
            ), false, true);
        } else {
            $this->render('add_photo', array(
                'album' => $album
            ));
        }
    }

    public function actionPhoto($id)
    {
        $photo = AlbumPhoto::model()->findByPk($id);
        $this->user = $photo->author;

        if (!Yii::app()->request->isAjaxRequest)
            $this->render('photo', compact('photo'));
        else
            $this->renderPartial('photo', compact('photo'));
    }

    public function actionWPhoto()
    {
        Yii::import('site.frontend.modules.cook.models.*');
        Yii::import('site.frontend.modules.contest.models.*');

        $photo = AlbumPhoto::model()->findByPk(Yii::app()->request->getQuery('id'));

        $entity_id = Yii::app()->request->getQuery('entity_id', 'null');
        $model = call_user_func(array(Yii::app()->request->getQuery('entity'), 'model'));
        if ($entity_id != 'null')
            $model = $model->findByPk($entity_id);

        if (!Yii::app()->request->getQuery('go')) {
            $view = ($model instanceof Album && $model->type == Album::TYPE_VALENTINE) ? 'w_photo_share' : 'w_photo';
            $this->renderPartial($view, compact('model', 'photo'));
        } else {
            $this->renderPartial('w_photo_content', compact('model', 'photo'));
        }
    }

    public function actionAttach($entity, $entity_id = null, $mode = 'window', $a = false, $instance = false)
    {
        Yii::app()->clientScript->scriptMap['*.js'] = false;
        Yii::app()->clientScript->scriptMap['*.css'] = false;
        $this->renderPartial('attach_widget', compact('entity', 'entity_id', 'mode', 'a', 'instance'), false, true);
    }

    public function actionAttachView($id)
    {
        $model = Album::model()->findByPk($id);
        if (!$model)
            throw new CHttpException(404, 'Альбом не найден');
        $this->renderPartial('attach_view', array(
            'model' => $model,
        ));
    }

    /* TODO не уверен, что где-то используется. Проверить. */
    public function actionSaveAttach()
    {
        $model = new AttachPhoto;
        $model->attributes = $_POST;
        $model->save();
        if (Yii::app()->request->getPost('return_html')) {
            $this->renderPartial('site.frontend.widgets.fileAttach.views._list', array(
                'attaches' => AttachPhoto::model()->findByEntity($_POST['entity'], $_POST['entity_id']),
            ));
        }
    }

    public function actionEditDescription($id)
    {
        $model = Album::model()->findByPk($id);
        if (Yii::app()->user->id != $model->author_id || ($text = Yii::app()->request->getPost('text')) === false)
            Yii::app()->end();
        $model->description = $text;
        $model->save();
    }

    public function actionEditPhotoTitle()
    {
        $id = Yii::app()->request->getPost('id');
        $model = AlbumPhoto::model()->findByPk($id);
        if (Yii::app()->user->id != $model->author_id || ($title = Yii::app()->request->getPost('title')) === false)
            Yii::app()->end();
        $model->title = $title;
        $model->save();
        var_dump($model->errors);
    }

    private function saveImage($val)
    {
        if (is_numeric($val)) {
            $model = AlbumPhoto::model()->findByPk($val);
            if (!$model)
                Yii::app()->end();
            $src = $model->getPreviewUrl(300, 185, Image::WIDTH);
        } else {
            $model = new AlbumPhoto;
            $model->fs_name = $val;
            $src = $model->templateUrl;
        }
        return array(
            'src' => $src,
            'id' => $model->primaryKey,
        );
    }

    public function actionProductPhoto()
    {
        if (!$val = Yii::app()->request->getPost('val'))
            Yii::app()->end();

        if (is_numeric($val)) {
            $model = AlbumPhoto::model()->findByPk($val);
            if (!$model)
                Yii::app()->end();
        } else {
            $model = new AlbumPhoto;
            $model->file_name = $val;
            $model->author_id = Yii::app()->user->id;
            if ($title = Yii::app()->request->getPost('title'))
                $model->title = CHtml::encode($title);
            $model->create(true);
        }
        $attach = new AttachPhoto;
        $attach->entity = 'Product';
        $attach->entity_id = Yii::app()->request->getPost('entity_id');
        $attach->photo_id = $model->id;
        if ($attach->save()) {
            $image = new ProductImage;
            $image->product_id = $attach->entity_id;
            $image->type = 0;
            $image->photo_id = $model->id;
            $image->save();
            echo CJSON::encode(array('status' => true));
        } else
            echo CJSON::encode(array('status' => false));
    }

    public function actionRecipePhoto()
    {
        $val = Yii::app()->request->getPost('val');
        if (is_numeric($val)) {
            AlbumPhoto::model()->findByPk($val);
        } else {
            $model = new AlbumPhoto;
            $model->file_name = $val;
            $model->author_id = Yii::app()->user->id;
            $model->create(true);
        }


        if ($model === null) {
            $response = array(
                'status' => false,
            );
        } else {
            if (Yii::app()->request->getPost('many') == 'true') {
                $attach = new AttachPhoto;
                $attach->entity = Yii::app()->request->getPost('entity');
                $attach->entity_id = Yii::app()->request->getPost('entity_id');
                $attach->photo_id = $model->primaryKey;
                $attach->save();
            }
            $response = array(
                'status' => true,
                'src' => $model->getPreviewUrl(325, 252),
                'id' => $model->primaryKey,
                'title' => $model->title,
            );
        }
        echo CJSON::encode($response);
        Yii::app()->end();
    }

    public function actionCookDecorationPhoto()
    {
        $title = trim(Yii::app()->request->getPost('title'));
        if (!$title) {
            echo CJSON::encode(array(
                'status' => false,
                'message' => 'Введите название блюда или оформления'
            ));
            Yii::app()->end();
        }

        $val = Yii::app()->request->getPost('id');
        if (is_numeric($val)) {
            $model = AlbumPhoto::model()->findByPk($val);
            $model->title = $title;
            $model->save();
        } else {
            $model = new AlbumPhoto;
            $model->file_name = $val;
            $model->author_id = Yii::app()->user->id;
            if ($title = Yii::app()->request->getPost('title'))
                $model->title = $title;
            $model->create(true);
        }

        Yii::import('application.modules.cook.models.CookDecoration');

        if (CookDecoration::model()->exists('photo_id = :photo_id', array(':photo_id' => $model->id))) {
            echo CJSON::encode(array(
                'status' => false,
                'message' => 'Вы уже добавили эту фотографию, выберите другую'
            ));
            Yii::app()->end();
        }

        $decoration = new CookDecoration();
        $decoration->photo_id = $model->id;
        $decoration->category_id = Yii::app()->request->getPost('category');
        $decoration->title = $model->title;
        $decoration->description = Yii::app()->request->getPost('description');

        if ($decoration->save()) {
            $attach = new AttachPhoto;
            $attach->entity = 'CookDecoration';
            $attach->entity_id = $decoration->id;
            $attach->photo_id = $model->id;
            if ($attach->save())
                echo CJSON::encode(array(
                    'status' => true,
                    'id'=>$model->id
                ));

        } else
            echo CJSON::encode(array('status' => false));
    }

    public function actionCommunityContentEdit()
    {
        $val = Yii::app()->request->getPost('val');
        if (is_numeric($val)) {
            $p = AlbumPhoto::model()->findByPk($val);
            $photo = $p->getPreviewUrl(177, 177, Image::NONE);
            $title = $p->title;
        } else {
            $photo = Yii::app()->params['photos_url'] . '/temp/' . $val;
            $title = '';
        }

        $this->renderPartial('site.frontend.widgets.fileAttach.views._community_content', array(
            'title' => $title,
            'widget_id' => Yii::app()->request->getPost('widget_id'),
            'photo' => $photo,
            'val' => $val
        ));
    }

    public function actionCommunityContentSave()
    {
        header('Content-type: application/json');
        $title = trim(Yii::app()->request->getPost('title'));
        $description = trim(Yii::app()->request->getPost('description'));

        $val = Yii::app()->request->getPost('val');
        if (!is_numeric($val)) {
            $model = new AlbumPhoto;
            $model->title = $title;
            $model->file_name = $val;
            $model->author_id = Yii::app()->user->id;
            $model->create(true);
        }
        $photo = $model->getPreviewUrl(177, 177, Image::NONE);
        $id = $model->id;
        echo CJSON::encode(compact('photo', 'id', 'description'));
    }

    public function actionCookDecorationCategory()
    {
        $val = Yii::app()->request->getPost('val');
        $data = array();
        $data['tab'] = Yii::app()->request->getPost('widget_id') . ".CookDecorationEdit('" . $val . "')";

        if (is_numeric($val)) {
            $p = AlbumPhoto::model()->findByPk($val);
            $photo = $p->getPreviewUrl(100, 100, Image::NONE);

            $image = new Image($p->getOriginalPath());
            if ($image->width < 400 || $image->height < 400) {
                echo CJSON::encode(array(
                    'status' => false,
                    'error' => 'Слишком маленькое изображение, минимум 400x400 пикселей',
                ));
                Yii::app()->end();
            }

            $title = $p->title;
            $data['title'] = mb_substr($p->title, 0, 20);
        } else {
            $photo = Yii::app()->params['photos_url'] . '/temp/' . $val;
            $photo_path = Yii::getPathOfAlias('site.common.uploads.photos') . '/temp/' . $val;
            $image = new Image($photo_path);
            if ($image->width < 400 || $image->height < 400) {
                echo CJSON::encode(array(
                    'status' => false,
                    'html' => $this->renderPartial('site.frontend.widgets.fileAttach.views._upload_error', array(
                        'error' => 'Слишком маленькое изображение, минимум 400x400 пикселей',
                    ), true)
                ));
                Yii::app()->end();
            }
            $title = '';
        }

        $data['html'] = $this->renderPartial('site.frontend.widgets.fileAttach.views._cook_decoration', array(
            'title' => $title,
            'widget_id' => Yii::app()->request->getPost('widget_id'),
            'photo' => $photo,
            'val' => $val
        ), true);
        $data['success'] = true;

        echo CJSON::encode($data);
    }

    public function actionCommentPhoto()
    {
        if (!$val = Yii::app()->request->getPost('val'))
            Yii::app()->end();

        if (is_numeric($val)) {
            $model = AlbumPhoto::model()->findByPk($val);
            if (!$model)
                Yii::app()->end();
        } else {
            $model = new AlbumPhoto;
            $model->file_name = $val;
            $model->author_id = Yii::app()->user->id;
            if ($title = Yii::app()->request->getPost('title'))
                $model->title = CHtml::encode($title);
            $model->create(true);
        }

        if ($entity_id = Yii::app()->request->getPost('entity_id')) {
            $comment = new Comment;
            $comment->entity = Yii::app()->request->getPost('entity');
            $comment->entity_id = $entity_id;
            $comment->author_id = Yii::app()->user->id;

            if ($comment->save()) {
                $attach = new AttachPhoto;
                $attach->entity = 'Comment';
                $attach->entity_id = $comment->id;
                $attach->photo_id = $model->id;
                if ($attach->save())
                    echo CJSON::encode(array('status' => true));
            }
        } else {
            $attach = new AttachPhoto;
            $attach->entity = 'Comment';
            $attach->entity_id = 0;
            $attach->photo_id = $model->id;
            $attach->save();

            echo CJSON::encode(array(
                'src' => $model->getPreviewUrl(700, 700, Image::WIDTH),
                'id' => $model->primaryKey,
                'title' => $model->title,
            ));
            Yii::app()->end();
        }
    }

    public function actionCrop()
    {
        if (!$val = Yii::app()->request->getPost('val'))
            Yii::app()->end();

        $params = $this->saveImage($val);

        $this->renderPartial('site.frontend.widgets.fileAttach.views._crop', array(
            'src' => $params['src'],
            'val' => $val,
            'widget_id' => Yii::app()->request->getPost('widget_id')
        ));
        Yii::app()->end();
    }

    public function actionChangeAvatar()
    {
        if (!isset($_POST['val']))
            Yii::app()->end();
        $val = $_POST['val'];

        if (is_numeric($val)) {
            $photo = AlbumPhoto::model()->findByPk($val);
        } else {
            $photo = new AlbumPhoto;
            $photo->file_name = $val;
            $photo->author_id = Yii::app()->user->id;
            if (!$photo->create(true))
                Yii::app()->end();
        }
        $src = $photo->originalPath;

        $params = CJSON::decode($_POST['coords']);

        Yii::import('site.frontend.extensions.EPhpThumb.*');
        $image = new EPhpThumb();
        $image->init(); //this is needed
        $image = $image->create($src)
            ->resize($_POST['width'], $_POST['height'])
            ->crop($params['x'], $params['y'], $params['w'], $params['h']);

        $thumb = clone $image;
        $thumb->adaptiveResize(72,72)->save($photo->getAvatarPath('ava'));

        $thumb = clone $image;
        $thumb->adaptiveResize(24, 24)->save($photo->getAvatarPath('small'));

        $attach = new AttachPhoto;
        $attach->entity = 'User';
        $attach->entity_id = Yii::app()->user->id;
        $attach->photo_id = $photo->id;
        $attach->save();

        User::model()->updateByPk(Yii::app()->user->id, array('avatar_id' => $photo->id));
        UserScores::checkProfileScores(Yii::app()->user->id, ScoreAction::ACTION_PROFILE_PHOTO);

        echo $photo->getPreviewUrl(241, 225, Image::WIDTH);
    }

    public function actionChangeTitle()
    {
        if (($id = Yii::app()->request->getPost('id')) === false || ($title = Yii::app()->request->getPost('title')) === false)
            Yii::app()->end();
        $model = Album::model()->findByPk($id);
        if (!$model || $model->author_id != Yii::app()->user->id)
            Yii::app()->end();
        $model->title = $title;
        if ($model->save())
            echo CJSON::encode(array('result' => true));
        else
            echo CJSON::encode(array('result' => false));
    }

    public function actionChangePermission()
    {
        $id = Yii::app()->request->getPost('id');
        $num = Yii::app()->request->getPost('num');
        $model = Album::model()->findByPk($id);
        if (!$model || $model->author_id != Yii::app()->user->id)
            Yii::app()->end();
        $model->updateByPk($id, array('permission' => $num));
    }

    public function actionRemoveUploadPhoto()
    {
        $model = AlbumPhoto::model()->findByPk(Yii::app()->request->getPost('id'));
        if ($model->author_id != Yii::app()->user->id)
            Yii::app()->end();
        $model->delete();
    }

    public static function loadUploadScritps()
    {
        $flashUrl = Yii::app()->baseUrl . '/javascripts/flash_upload/';
        $jUrl = Yii::app()->baseUrl . '/javascripts/j_upload/';
        Yii::app()->clientScript->registerCoreScript('jquery')
            ->registerScriptFile(Yii::app()->baseUrl . '/javascripts/flash_detect_min.js')
            ->registerScriptFile(Yii::app()->baseUrl . '/javascripts/album.js?r=11')
            ->registerScriptFile($flashUrl . '/' . 'swfupload.js')
            ->registerScriptFile($flashUrl . '/' . 'jquery.swfupload.js')
            ->registerScriptFile(Yii::app()->baseUrl . '/javascripts/scrollbarpaper.js')

            ->registerScriptFile($jUrl . '/jquery.ui.widget.js')
            ->registerScriptFile($jUrl . '/jquery.iframe-transport.js')
            ->registerScriptFile($jUrl . '/jquery.fileupload.js');
    }

    public function actionRedirect($id)
    {
        $album = Album::model()->findByPk($id);
        $this->redirect($album->url);
    }

    public function actionUpdatePhoto($id)
    {
        $photo = AlbumPhoto::model()->findByPk($id);
        $this->renderPartial('updatePhoto', compact('photo'), false, true);
    }

    public function actionUpdateAlbum($id)
    {
        $album = Album::model()->findByPk($id);
        $this->renderPartial('updateAlbum', compact('album'), false, true);
    }

    public function actionSinglePhoto($entity, $photo_id)
    {
        $photo = AlbumPhoto::model()->findByPk($photo_id);
        if ($photo === null)
            throw new CHttpException(404, 'Фото не найдено');

        switch ($entity) {
            case 'valentinePost':
                $criteria = new CDbCriteria;
                $criteria->compare('rubric.community_id', Community::COMMUNITY_VALENTINE);
                $model = CommunityContent::model()->full()->find($criteria);

                $content_id = $model->id;
                $model = CActiveRecord::model('CommunityContentGallery')->findByAttributes(array('content_id' => $content_id));
                break;

            case 'CommunityContentGallery':
                //Yii::app()->user->setState('ban_register_window', 1);
                $content_id = Yii::app()->request->getQuery('content_id');
                $model = CActiveRecord::model($entity)->findByAttributes(array('content_id' => $content_id));
                break;

            case 'Album':
                $album_id = (Yii::app()->request->getQuery('valentines') == 1) ? Album::getAlbumByType(User::HAPPY_GIRAFFE, Album::TYPE_VALENTINE)->id : Yii::app()->request->getQuery('album_id');
                $model = CActiveRecord::model($entity)->findByPk($album_id);
                break;
            case 'CookRecipe':
            case 'SimpleRecipe':
            case 'MultivarkaRecipe':
                Yii::import('application.modules.cook.models.*');
                $recipe_id = Yii::app()->request->getQuery('recipe_id');
                $model = CActiveRecord::model($entity)->findByPk($recipe_id);
                break;
            case 'CookDecorationCategory':
                $category_id = Yii::app()->request->getQuery('category_id');
                Yii::import('application.modules.cook.models.*');
                $model = CActiveRecord::model($entity);
                if ($category_id !== null)
                    $model = $model->findByPk($category_id);
                $decor = CookDecoration::model()->findByAttributes(array('photo_id' => $photo_id));
                if ($decor === null)
                    throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');

                $photo->w_title = $decor->title;
                $photo->w_description = $decor->description;
                $collection = array();
                $collection['title'] = 'Фотоальбом к сервису ' . CHtml::link('Офомление блюд', array('cook/decor/index'));
                break;
            case 'Contest':
                Yii::import('application.modules.contest.models.*');
                $contest_id = Yii::app()->request->getQuery('contest_id');
                $model = CActiveRecord::model($entity)->findByPk($contest_id);
                $attach = $photo->getAttachByEntity('ContestWork', $photo_id);
                if (!isset($attach->model))
                    throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');

                $work = $attach->model;
                if ($work === null)
                    throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');
                $photo->w_title = $work->title;
                $currentIndex = null;
                $collection = array();
                $collection['title'] = 'Фотоконкурс ' . CHtml::link($work->contest->title, $work->contest->url);
                //$this->pageTitle = $work->title . ' - ' . $model->title;
                break;
        }

        if ($entity != 'Contest' && $entity != 'CookDecorationCategory') {
            $collection = $model->photoCollection;
            foreach ($collection['photos'] as $i => $p) {
                if ($photo->id == $p->id) {
                    $currentIndex = $i + 1;
                    $photo = $p;
                    break;
                }
            }
            if (!isset($currentIndex))
                throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');

            //$this->pageTitle = $photo->w_title;
        }

        $this->pageTitle = $photo->w_title . ' - ' . strip_tags($collection['title']);
        $this->layout = '//layouts/main';

        if (! Yii::app()->user->isGuest)
            UserNotification::model()->deleteByEntity($photo, Yii::app()->user->id);

        $this->render('singlePhoto', compact('model', 'collection', 'photo', 'currentIndex'));
    }

    public function actionPostLoad($entity, $photo_id)
    {
        Yii::import('site.frontend.modules.cook.models.*');
        Yii::import('site.frontend.modules.contest.models.*');
        Yii::import('zii.behaviors.*');
        $model = CActiveRecord::model($entity);
        $entity_id = Yii::app()->request->getQuery('entity_id', 'null');
        if ($entity_id != 'null')
            $model = $model->findByPk($entity_id);
        $this->renderPartial('postLoad', compact('model', 'photo_id'));
    }

    public function actionPartnerPhoto()
    {
        $val = Yii::app()->request->getPost('val');
        if (is_numeric($val)) {
            AlbumPhoto::model()->findByPk($val);
        } else {
            $model = new AlbumPhoto;
            $model->file_name = $val;
            $model->author_id = Yii::app()->user->id;
            $model->create(true);
        }


        if ($model === null) {
            $response = array(
                'status' => false,
            );
        } else {
            $attach = new AttachPhoto;
            $attach->entity = Yii::app()->request->getPost('entity');
            $attach->entity_id = Yii::app()->request->getPost('entity_id');
            $attach->photo_id = $model->primaryKey;
            $attach->save();

            $response = array(
                'status' => true,
                'src' => $model->getPreviewUrl(325, 252),
                'id' => $model->primaryKey,
                'title' => $model->title,
            );
        }
        echo CJSON::encode($response);
        Yii::app()->end();
    }

    public function actionShare($id)
    {
        $photo = AlbumPhoto::model()->findByPk($id);

        $this->renderPartial('share', compact('photo'));
    }

    public function actionDownload($id)
    {
        $photo = AlbumPhoto::model()->findByPk($id);
        $file = $photo->getOriginalPath();
        header('Content-Description: File Transfer');
        header('Content-type: application/octet-stream');
        header ('Content-Disposition: attachment; filename=' . $photo->fs_name);
        readfile($file);
    }
}
