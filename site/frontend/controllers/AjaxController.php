<?php

class AjaxController extends HController
{
    public function actionSetValue()
    {
        $modelName = Yii::app()->request->getPost('entity');
        $modelPk = Yii::app()->request->getPost('entity_id');
        $attribute = Yii::app()->request->getPost('attribute');
        $value = Yii::app()->request->getPost('value');

        $model = $modelName::model()->findByPk($modelPk);
        $model->setAttribute($attribute, $value);
        if ($model->update($attribute))
            echo '1';
    }

    public function actionSetDate()
    {
        $modelName = Yii::app()->request->getPost('entity');
        $modelPk = Yii::app()->request->getPost('entity_id');
        $attribute = Yii::app()->request->getPost('attribute');
        $d = Yii::app()->request->getPost('d');
        $m = Yii::app()->request->getPost('m');
        $y = Yii::app()->request->getPost('y');

        $model = $modelName::model()->findByPk($modelPk);
        $model->setAttribute($attribute, HDate::getStringDate($d, $m, $y));
        if ($model->update($attribute)) {
            $response = array(
                'status' => true,
                'age' => $model->getAge()
            );
        } else {
            $response = array(
                'status' => false,
            );
        }
        echo CJSON::encode($response);
    }

    public function actionRate()
    {
        if (Yii::app()->user->isGuest)
            Yii::app()->end();
        Yii::import('contest.models.*');
        Yii::import('services.modules.recipeBook.models.*');

        $modelName = $_POST['modelName'];
        $objectId = $_POST['objectId'];
        $social_key = $_POST['key'];
        $value = $_POST['r'];

        $model = $modelName::model()->findByPk($objectId);
        if (!$model)
            Yii::app()->end();

        if ($url = Yii::app()->request->getPost('url')) {
            Rating::model()->updateByApi($model, $social_key, $url);
        }
        else {
            Rating::model()->saveByEntity($model, $social_key, $value, true);
        }

        echo CJSON::encode(array(
            'entity' => $social_key == 'yh' ? Rating::model()->countByEntity($model, $social_key) / 2 : Rating::model()->countByEntity($model, $social_key),
            'count' => Rating::model()->countByEntity($model),
        ));
        Yii::app()->end();
    }

    public function actionGetRate()
    {
        Yii::import('contest.models.*');
        $modelName = $_POST['modelName'];
        $objectId = $_POST['objectId'];
        $social_key = $_POST['key'];
        $model = $modelName::model()->findByPk($objectId);
        echo CJSON::encode(array(
            'entity' => Rating::model()->countByEntity($model, $social_key),
            'count' => Rating::model()->countByEntity($model),
        ));
        Yii::app()->end();
    }

    public function actionSocialApi()
    {
        Yii::import('contest.models.*');
        if (!isset($_GET['key']) && isset(Yii::app()->session['google']))
            $params = Yii::app()->session['google'];
        else
            $params = $_GET;
        if (isset($params['key'])) {
            $key = $params['key'];
            switch ($key) {
                case 'vk' :
                    $service = 'vkontakte';
                    break;
                case 'fb' :
                    $service = 'facebook';
                    break;
                case 'tw' :
                    $service = 'twitter';
                    break;
                case 'mr' :
                    $service = 'mailru';
                    break;
                case 'gp' :
                    $service = 'google';
                    break;
            }
            $authIdentity = Yii::app()->eauth->getIdentity($service);
            $authIdentity->redirectUrl = $this->createAbsoluteUrl('/ajax/socialApi');
            if ($service == 'google') {
                Yii::app()->session[$service] = $_GET;
                $authIdentity->redirectUri = $this->createAbsoluteUrl('/ajax/socialApi');
            }
            if ($authIdentity->authenticate()) {
                $name = $authIdentity->getServiceName();
                $id = $authIdentity->getAttribute('id');
                $url = $params['surl'];
                if (!isset($url))
                    echo '<script type="text/javascript">window.close();</script>';
                else {
                    $entity_name = $params['entity'];
                    $entity_id = $params['entity_id'];
                    $entity = call_user_func(array($entity_name, 'model'))->findByPk($entity_id);
                    // Если пользователя нет в списке голосовавших - увеличиваем рейтинг
                    if (RatingUsers::model()->saveByUser($id, $name, $entity_name, $entity_id))
                        Rating::model()->saveByEntity($entity, $key, 1, true);
                    $this->redirect($url);
                }
            }
        }
    }

    public function actionSavePhoto()
    {
        if (!isset($_FILES))
            Yii::app()->end();
        $model = new AlbumPhoto();
    }

    public function actionImageUpload()
    {
        $dir = Yii::getPathOfAlias('webroot') . '/upload/images/';

        $_FILES['file']['type'] = strtolower($_FILES['file']['type']);

        if ($_FILES['file']['type'] == 'image/png'
            || $_FILES['file']['type'] == 'image/jpg'
            || $_FILES['file']['type'] == 'image/gif'
            || $_FILES['file']['type'] == 'image/jpeg'
            || $_FILES['file']['type'] == 'image/pjpeg'
        ) {
            copy($_FILES['file']['tmp_name'], $dir . time() . $_FILES['file']['name']);

            echo Yii::app()->baseUrl . '/upload/images/' . time() . $_FILES['file']['name'];
        }
    }

    public function actionPageView()
    {
        if (!Yii::app()->request->isAjaxRequest || false === ($path = Yii::app()->request->getPost('path')))
            Yii::app()->end();
        $count = 1;
        if ($model = PageView::model()->updateByPath($path))
            $count = $model->views;
        echo CJSON::encode(array(
            'count' => (int)$count,
        ));
    }

    public function actionSendComment()
    {
        Yii::import('site.frontend.modules.services.modules.recipeBook.models.*');
        if(isset($_POST['CommentProduct']))
            $model = 'CommentProduct';
        elseif(isset($_POST['Comment']))
            $model = 'Comment';
        else
            Yii::app()->end();
        if (!isset($_POST[$model]['text']))
            Yii::app()->end();

        if (empty($_POST['edit-id'])) {
            $comment = new $model('default');
            $comment->attributes = $_POST[$model];
            $comment->author_id = Yii::app()->user->id;
        } else {
            $comment = call_user_func(array($model, 'model'))->findByPk($_POST['edit-id']);
            $comment->scenario = 'default';
            if ($comment === null)
                throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');
            //check access
            if ($comment->author_id != Yii::app()->user->id &&
                !Yii::app()->authManager->checkAccess('editComment', Yii::app()->user->id)
            )
                throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');
            $comment->attributes = $_POST[$model];
        }
        if ($comment->save()) {
            $response = array(
                'status' => 'ok',
            );
        }
        else {
            $response = array(
                'status' => 'error',
            );
        }
        echo CJSON::encode($response);
    }

    public function actionUserViaCommunity()
    {
        $user = User::model()->with('communities')->findByPk(Yii::app()->user->id);
        $communities = $user->communities;
        $_communities = array();
        foreach ($communities as $c) {
            if ($c->id != 2) $_communities[] = $c->id;
        }
        $user->communities = $_communities;
        $user->saveRelated('communities');
    }

    public function actionRemoveEntity()
    {
        Yii::import('application.modules.contest.models.*');
        if (!Yii::app()->request->isAjaxRequest || !isset($_POST['Removed']))
            Yii::app()->end();
        $model = call_user_func(array($_POST['Removed']['entity'], 'model'));
        $model = $model->findByPk($_POST['Removed']['entity_id']);
        if (!$model)
            Yii::app()->end();

        $is_entity_author = false;
        if (method_exists($model, 'isEntityAuthor') && $model->isEntityAuthor(Yii::app()->user->id))
            $is_entity_author = true;

        if (!Yii::app()->user->checkAccess('remove' . get_class($model), array('user_id' => $model->author_id)) && !$is_entity_author)
            Yii::app()->end();

        $removed = new Removed;
        $removed->user_id = Yii::app()->user->id;
        $removed->attributes = $_POST['Removed'];
        if ($model->author_id == Yii::app()->user->id)
            $removed->type = 0;
        elseif ($is_entity_author)
            $removed->type = 5;
        $removed->save();
    }

    public function actionAcceptReport()
    {
        if ($_POST['Report']) {
            $path = parse_url($_SERVER['HTTP_REFERER']);
            $report = new Report;
            $report->setAttributes($_POST['Report'], FALSE);
            $report->author_id = Yii::app()->user->id;
            $report->path = $path['path'];
            $report->save();
        }
    }

    public function actionShowReport()
    {
        if (!Yii::app()->request->isAjaxRequest)
            Yii::app()->end();
        $accepted_models = array(
            'Comment',
            'CommunityContent',
            'RecipeBookRecipe',
            'Dialog',
            'Message'
        );
        $source_data = $_POST['source_data'];
        if (in_array($source_data['model'], $accepted_models)) {
            $report = $this->beginWidget('site.frontend.widgets.reportWidget.ReportWidget', array(
                'entity' => $source_data['model'],
                'entity_id' => $source_data['object_id'],
            ));
            $report->form();
            $this->endWidget();
        }
    }

    public function actionView($path)
    {
        $this->renderPartial($path);
    }

    public function actionVideo()
    {
        $link = $_POST['url'];

        $video = new Video($link);

        $host = parse_url($link, PHP_URL_HOST);
        $favicon_url = 'http://www.google.com/s2/favicons?domain=' . $host;
        $favicon = strtr($host, array('.' => '_')) . '.png';
        $favicon_path = Yii::getPathOfAlias('webroot') . '/upload/favicons/' . $favicon;
        file_put_contents($favicon_path, file_get_contents($favicon_url));

        $this->renderPartial('video_preview', array(
            'video' => $video,
            'favicon' => $favicon,
        ));
    }

    public function actionSource()
    {
        switch ($_POST['source_type']) {
            case 'book':
                $this->renderPartial('source_type/preview/book', array(
                    'author' => $_POST['book_author'],
                    'name' => $_POST['book_name'],
                ));
                break;
            case 'internet':
                $link = $_POST['internet_link'];
                $html = file_get_contents($link);
                $title = preg_match('/<title>(.+)<\/title>/', $html, $matches) ? $matches[1] : $link;
                $title = mb_convert_encoding($title, 'UTF-8', 'cp1251');

                $host = parse_url($link, PHP_URL_HOST);
                $favicon_url = 'http://www.google.com/s2/favicons?domain=' . $host;
                $favicon = strtr($host, array('.' => '_')) . '.png';
                $favicon_path = Yii::getPathOfAlias('webroot') . '/upload/favicons/' . $favicon;
                file_put_contents($favicon_path, file_get_contents($favicon_url));

                $this->renderPartial('source_type/preview/internet', array(
                    'title' => $title,
                    'favicon' => $favicon,
                ));
                break;
        }
    }

    public function actionSave()
    {
        print_r($_POST);
        $user = User::model()->findByPk(Yii::app()->user->id);
        $user->setAttributes($_POST['User']);
        $user->save(TRUE, array('first_name', 'last_name', 'birthday'));
    }

    public function actionSaveChild()
    {
        //sleep(2);
        $baby = Baby::model()->findByPk($_POST['Baby']['id']);
        $baby->setAttributes($_POST['Baby']);
        $baby->save(TRUE, array('name', 'birthday'));
        echo json_encode($baby->getAttributes());
    }

    public function actionSettlements()
    {
        $data = GeoRusSettlement::model()->findAll('region_id=:region_id', array(':region_id' => (int)$_POST['region_id']));

        $data = CHtml::listData($data, 'id', 'name');
        foreach ($data as $value => $name) {
            echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), TRUE);
        }
    }

    public function actionRubrics()
    {
        $rubrics = CommunityRubric::model()->findAllByAttributes(array('community_id' => Yii::app()->request->getPost('community_id')));
        $htmlOptions = array('prompt' => 'Выберите рубрику');
        echo CHtml::listOptions('', CHtml::listData($rubrics, 'id', 'name'), $htmlOptions);
    }

    public function actionVote()
    {
        if (Yii::app()->request->isAjaxRequest && !Yii::app()->user->isGuest) {
            Yii::import('application.modules.services.modules.vaccineCalendar.models.*');
            Yii::import('application.modules.services.modules.recipeBook.models.*');
            Yii::import('application.modules.services.modules.hospitalBag.models.*');

            $object_id = $_POST['object_id'];
            $vote = $_POST['vote'];
            $model = $_POST['model']::model()->findByPk($object_id);

            if ($model) {
                $depends = Yii::app()->user->id;
                if (isset($_POST['depends'])) {
                    $depends = array('user_id' => Yii::app()->user->id);
                    foreach ($_POST['depends'] as $key => $value)
                        $depends[$key] = $value;
                }

                $model->vote($depends, $vote);
                $model->refresh();

                $response = array('success' => true);
                foreach ($model->vote_attributes as $key => $value) {
                    $response[$value] = $model->$value;
                    $response[$value . '_percent'] = $model->getPercent($key);
                }
                if (isset($model->vote_attributes[0]) && isset($model->vote_attributes[1])) {
                    $response['rating'] = $model->{$model->vote_attributes[1]} - $model->{$model->vote_attributes[0]};
                }
            }
            else
                $response = array('success' => false);

            echo CJSON::encode($response);
        }
    }

    public function actionInterestsForm()
    {
        if (!Yii::app()->request->isAjaxRequest)
            Yii::app()->end();
        Yii::import('site.common.models.interest.*');
        $categories = InterestCategory::model()->findAll();
        $user_interests = Interest::findAllByUser(Yii::app()->user->id);
        $this->renderPartial('interests', compact('categories', 'user_interests'), false, true);
    }

    public function actionSaveInterests()
    {
        if (!Yii::app()->request->isAjaxRequest)
            Yii::app()->end();
        Yii::import('site.common.models.interest.*');
        Interest::saveByUser(Yii::app()->user->id, Yii::app()->request->getPost('Interest'));

        $interests = Yii::app()->user->model->interests;
        $html = CHtml::openTag('ul', array('id' => 'user_interests_list'));
        foreach ($interests as $interest)
            $html .= CHtml::tag('li', array(), CHtml::tag('span', array('class' => 'interest selected ' . $interest->category->css_class), $interest->title));
        $html .= CHtml::closeTag('ul');
        echo $html;
    }

    public function actionToggleFavourites()
    {
        if (Yii::app()->user->checkAccess('manageFavourites')) {
            $modelName = Yii::app()->request->getPost('entity');
            $modelPk = Yii::app()->request->getPost('entity_id');
            $index = Yii::app()->request->getPost('num');
            $param = Yii::app()->request->getPost('param');

            $model = $modelName::model()->findByPk($modelPk);
            $success = false;
            if ($model){
                $success = Favourites::toggle($model, $index, $param);
            }
            echo CJSON::encode(array('status' => $success));
        }
    }

    public function actionWantToChat()
    {
        if (! Yii::app()->user->isGuest && ! WantToChat::hasCooldown(Yii::app()->user->id)) {
            $model = new WantToChat;
            $model->user_id = (int) Yii::app()->user->id;
            $model->created = time();
            echo $model->save();
        }
    }

    public function actionContentsLive($id, $containerClass)
    {
        $model = CommunityContent::model()->full()->findByPk($id);
        $data = array('data' => $model);
        switch ($containerClass) {
            case 'short':
                $view = 'application.widgets.activity.views._live_entry';
                break;
            case 'full':
                $view = '//community/_post';
                $data['full'] = false;
                break;
        }
        $this->renderPartial($view, $data);
    }

    public function actionDuelForm()
    {
        $questions = DuelQuestion::getAvailable();
        $answer = new DuelAnswer;
        $this->renderPartial('duel', compact('questions', 'answer'));
    }
}