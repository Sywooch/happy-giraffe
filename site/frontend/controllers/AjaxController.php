<?php

class AjaxController extends HController
{
    public function filters()
    {
        return array(
            'ajaxOnly - socialVote',
        );
    }

    public function actionSocialVote($entity, $entity_id, $service = null)
    {
        Yii::app()->clientScript->registerMetaTag('noindex', 'robots');
        Yii::import('site.frontend.modules.contest.models.*');
        Yii::import('site.frontend.modules.cook.models.*');

        if ($service !== null) {
            $authIdentity = Yii::app()->eauth->getIdentity($service);
            $model = CActiveRecord::model($entity)->findByPk($entity_id);
            $authIdentity->redirectUrl = $model->getShare($service);
            $inc = false;

            if ($model->contest->status == Contest::STATUS_ACTIVE) {
                if ($authIdentity->authenticate()) {
                    $vote = new SocialVote;
                    $vote->entity = $entity;
                    $vote->entity_id = $entity_id;
                    $vote->service_key = $service;
                    $vote->service_id = $authIdentity->getAttribute('id');
                    try {
                        $vote->save();
                        Rating::model()->saveByEntity($model, Rating::getShort($service), 1, true);
                        $inc = true;
                    } catch (MongoCursorException $e) {}

                }
            }

            $authIdentity->redirect(null, 'share_redirect', $inc);
        }
    }

    public function actionSetValue()
    {
        if (!Yii::app()->request->isAjaxRequest)
            Yii::app()->end();
        $modelName = Yii::app()->request->getPost('entity');
        $modelPk = Yii::app()->request->getPost('entity_id');
        $attribute = Yii::app()->request->getPost('attribute');
        $value = Yii::app()->request->getPost('value');

        if ($modelName == 'CookDecoration' && $attribute == 'description') {
            Yii::import('site.frontend.modules.cook.models.*');
            $model = $modelName::model()->findByAttributes(array('photo_id' => $modelPk));
        } else {
            $model = $modelName::model()->findByPk($modelPk);
        }
        $model->setAttribute($attribute, $value);
        if ($model->update($attribute))
            echo '1';
    }

    public function actionSetValues()
    {
        if (isset($_POST['Album']['title']))
            $_POST['Album']['title'] = str_replace('Введите название альбома', '', $_POST['Album']['title']);

        $modelName = Yii::app()->request->getPost('entity');
        $modelPk = Yii::app()->request->getPost('entity_id');
        $model = CActiveRecord::model($modelName)->findByPk($modelPk);

        if (isset($_POST['ajax'])) {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }

        $model->attributes = $_POST[$modelName];

        echo $model->save();
    }

    protected function performAjaxValidation($model)
    {

    }

    public function actionSetDate()
    {
        $modelName = Yii::app()->request->getPost('entity');
        $modelPk = Yii::app()->request->getPost('entity_id');
        $attribute = Yii::app()->request->getPost('attribute');
        $d = Yii::app()->request->getPost('d');
        $m = Yii::app()->request->getPost('m');
        $y = Yii::app()->request->getPost('y');

        if (empty($d) || empty($m) || empty($y)){
            echo CJSON::encode(array('status' => false));
            Yii::app()->end();
        }

        $model = $modelName::model()->findByPk($modelPk);
        $model->setAttribute($attribute, HDate::getStringDate($d, $m, $y));
        if ($model->update($attribute)) {
            $response = array(
                'status' => true,
                'age' => $model->getAge(),
                'birthday' => $model->birthday,
            );
            if ($modelName == 'User')
                $response['birthday_str'] = Yii::app()->dateFormatter->format("d MMMM", $model->birthday) . ' (' . $model->normalizedAge . ')';
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

        if ($modelName == 'ContestWork'
            && $social_key == 'yh'
            && Yii::app()->user->getModel()->score->full == 0
        ) {
            echo 'обломитесь :)';
            Yii::app()->end();
        }

        $model = $modelName::model()->findByPk($objectId);
        if (!$model)
            Yii::app()->end();

        if ($social_key == 'yh')
            $value = 2;
        else
            $value = 1;

        if ($url = Yii::app()->request->getPost('url')) {
            Rating::model()->updateByApi($model, $social_key, $url);
        } else {
            Rating::model()->saveByEntity($model, $social_key, $value, true);
        }

        echo CJSON::encode(array(
            'entity' => $social_key == 'yh' ? Rating::model()->countByEntity($model, $social_key) / 2 : Rating::model()->countByEntity($model, $social_key),
            'count' => Rating::model()->countByEntity($model),
        ));
    }

    public function actionUpdateRating()
    {
        Yii::import('contest.models.*');
        Yii::import('services.modules.recipeBook.models.*');

        $modelName = $_POST['modelName'];
        $objectId = $_POST['objectId'];
        $social_key = $_POST['key'];

        $model = $modelName::model()->findByPk($objectId);
        if (!$model)
            Yii::app()->end();

        $model = Rating::model()->inc($model, $social_key);
        RatingQueue::model()->add($modelName, $objectId, $social_key);

        echo CJSON::encode(array(
            'sum' => $model->sum,
        ));
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

    public function actionSendComment()
    {
        Yii::import('site.frontend.modules.services.modules.recipeBook.models.*');
        Yii::import('site.frontend.modules.route.models.*');

        if (Yii::app()->request->getPost('PhotoViewComment'))
            $_POST['Comment'] = CMap::mergeArray($_POST['Comment'], $_POST['PhotoViewComment']);

        if (isset($_POST['CommentProduct']))
            $model = 'CommentProduct';
        elseif (isset($_POST['Comment']))
            $model = 'Comment'; else
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
            $comment->text = $_POST[$model]['text'];
        }
        if ($comment->save()) {
            $response = array(
                'status' => 'ok',
            );
        } else {
            $response = array(
                'status' => 'error',
            );
        }
        echo CJSON::encode($response);
    }

    public function actionUserViaCommunity()
    {
        $user = User::model()->findByPk(Yii::app()->user->id);
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
        Yii::import('application.modules.cook.models.*');
        Yii::import('application.modules.route.models.*');

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

        //уволенный сотрудник
        if (UserAttributes::isFiredWorker(Yii::app()->user->id, $model->created))
            Yii::app()->end();

        //if user remove commentator comment, then commentator will ignore this users
        if (Yii::app()->user->model->group == UserGroup::USER && $is_entity_author && Yii::app()->user->id != $model->author_id) {
            Yii::import('site.frontend.modules.signal.models.*');
            $commentator = CommentatorWork::getUser($model->author_id);
            if ($commentator !== null) {
                if (!in_array(Yii::app()->user->id, $commentator->ignoreUsers)) {
                    $commentator->ignoreUsers [] = (int)Yii::app()->user->id;
                    $commentator->save();
                }
            }
        }

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
            'BlogContent',
            'RecipeBookRecipe',
            'Dialog',
            'Message',
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

    public function actionVideo()
    {
        $link = $_POST['url'];
        if ($this->isValidURL($link)) {
            $video = new Video($link);

            if (empty($video->preview)) {
                echo CJSON::encode(array('status' => false));
                Yii::app()->end();
            }

            $host = parse_url($link, PHP_URL_HOST);
            $favicon_url = 'http://www.google.com/s2/favicons?domain=' . $host;
            $favicon = strtr($host, array('.' => '_')) . '.png';
            $favicon_path = Yii::getPathOfAlias('webroot') . '/upload/favicons/' . $favicon;
//            file_put_contents($favicon_path, file_get_contents($favicon_url));

            echo CJSON::encode(array(
                'status' => true,
                'html' => $this->renderPartial('video_preview', array(
                    'video' => $video,
                    'favicon' => $favicon,
                ), true)
            ));
        } else {
            echo CJSON::encode(array('status' => false));
        }
    }

    function isValidURL($url)
    {
        return preg_match('|^http(s)?://[a-z0-9-]+(.[a-z0-9-]+)*(:[0-9]+)?(/.*)?$|i', $url);
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
        $rubrics = CommunityRubric::model()->findAll('community_id = :community_id AND parent_id IS NULL', array(':community_id' => Yii::app()->request->getPost('community_id')));
        $htmlOptions = array('prompt' => 'Выберите рубрику');
        echo CHtml::listOptions('', CHtml::listData($rubrics, 'id', 'title'), $htmlOptions);
    }

    public function actionSubRubrics()
    {
        $rubrics = CommunityRubric::model()->findAll('parent_id = :rubric_id', array(':rubric_id' => Yii::app()->request->getPost('rubric_id')));
        $htmlOptions = array('prompt' => 'Выберите подрубрику');
        $response = array(
            'status' => count($rubrics) > 0,
            'html' => CHtml::listOptions('', CHtml::listData($rubrics, 'id', 'title'), $htmlOptions),
        );

        echo CJSON::encode($response);
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
            } else
                $response = array('success' => false);

            echo CJSON::encode($response);
        }
    }

    public function actionDuelVote()
    {
        if (Yii::app()->request->isAjaxRequest && !Yii::app()->user->isGuest) {
            $id = Yii::app()->request->getPost('id');
            $model = DuelAnswer::model()->findByPk($id);
            $model->vote(Yii::app()->user->id, 1);
            echo true;
        } else {
            echo false;
        }
    }

    public function actionInterestsForm()
    {
        Yii::import('site.common.models.interest.*');

        Yii::app()->clientScript->scriptMap = array(
            'jquery.js' => false,
            'jquery.min.js' => false,
            'jquery-ui.js' => false,
            'jquery-ui.min.js' => false,
            'jquery-ui.css' => false,
            'global.css'=>false,
            'jquery.tmpl.min.js'=>false
            //'jquery.yiiactiveform.js'=>false
        );
        $categories = InterestCategory::model()->with('interests')->findAll();
        $user_interests = Yii::app()->user->model->interests;
        $this->renderPartial('interests', compact('categories', 'user_interests'), false, true);
    }

    public function actionSaveInterests()
    {
        Yii::import('site.common.models.interest.*');
        Yii::import('site.frontend.widgets.user.*');

        if (Interest::saveByUser(Yii::app()->user->id, Yii::app()->request->getPost('Interest'))) {
            ob_start();
            $this->widget('InterestsWidget', array('user' => Yii::app()->user->model));
            $content = ob_get_clean();

            echo CJSON::encode(array(
                'status' => true,
                'html' => $content,
                'full' => (Yii::app()->user->model->score->full == 1) ? true : false
            ));
        } else
            echo CJSON::encode(array('status' => false));
        /*
        $interests = Yii::app()->user->model->interests;
        $html = CHtml::openTag('ul', array('id' => 'user_interests_list'));
        foreach ($interests as $interest)
            $html .= CHtml::tag('li', array(), CHtml::tag('span', array('class' => 'interest selected ' . $interest->category->css_class), $interest->title));
        $html .= CHtml::closeTag('ul');
        echo $html;
        */
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
            if ($model) {
                $success = Favourites::toggle($model, $index, $param);
                $model->full = null;
                $model->update(array('full'));
            }
            echo CJSON::encode(array('status' => $success));
        }
    }

    public function actionWantToChat()
    {
        if (!Yii::app()->user->isGuest && !WantToChat::hasCooldown(Yii::app()->user->id)) {
            $model = new WantToChat;
            $model->user_id = (int)Yii::app()->user->id;
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
        $questions = DuelQuestion::getAvailable(Yii::app()->user->id);
        $answer = new DuelAnswer;
        $answer->text = 'Блесните знаниями!';
        $this->renderPartial('duel', compact('questions', 'answer'));
    }

    public function actionDuelSubmit()
    {
        if ($_POST['DuelAnswer']) {
            $answer = new DuelAnswer;
            $answer->attributes = $_POST['DuelAnswer'];
            $answer->user_id = Yii::app()->user->id;
            if ($answer->save()) {
                $question = $answer->getRelated('question', false, array(
                    'with' => 'answers.user',
                ));
                if (count($question->answers) == 2) {
                    UserAction::model()->add($question->answers[0]->user_id, UserAction::USER_ACTION_DUEL, array('model' => $question));
                    UserAction::model()->add($question->answers[1]->user_id, UserAction::USER_ACTION_DUEL, array('model' => $question));
                    $question->ends = new CDbExpression('NOW() + INTERVAL 3 DAY');
                    if ($question->save())
                        Yii::app()->cache->set('activityLastUpdated', time());
                }
                $response = array(
                    'status' => true,
                    'html' => $this->renderPartial('duel_submit', compact('question'), true),
                );
            } else {
                $response = array(
                    'status' => false,
                    'error' => $answer->errors,
                );
            }
            echo CJSON::encode($response);
        }
    }

    public function actionDuelShow($question_id)
    {
        $question = DuelQuestion::model()->with('answers.user')->findByPk($question_id);
        $this->renderPartial('duel_show', compact('question'));
    }

    public function actionEditMeta($route = null, $params = null)
    {
        if (!Yii::app()->user->checkAccess('editMeta'))
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');

        Yii::import('site.seo.modules.promotion.models.*');
        Yii::import('site.seo.models.*');

        $id = Yii::app()->request->getPost('_id');

        if (!empty($id)) {
            $model = $this->loadModel($id);
        } else {
            $model = PageMetaTag::getModel(urldecode($route), unserialize(urldecode($params)), true);
        }

        $page = $model->getPage();
        $dataProvider = $model->getPhrases($page);

        if (isset($_POST['meta'])) {
            $model->attributes = $_POST['meta'];
            $model->save();
            echo CJSON::encode(array('status' => true));
        } else
            $this->renderPartial('_edit_meta', compact('model', 'dataProvider', 'page'));
    }

    public function actionArticleVisits()
    {

    }

    /**
     * @param int $id model id
     * @return PageMetaTag
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        $model = PageMetaTag::model()->findByPk(new MongoId($id));
        if ($model === null) {
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');
        }
        return $model;
    }

    public function actionBirthday()
    {
        Yii::import('site.common.models.forms.DateForm');
        Yii::import('site.frontend.widgets.user.*');
        $date = new DateForm();
        $date->attributes = $_POST['DateForm'];
        if (isset($_POST['ajax'])) {
            echo CActiveForm::validate($date);
            Yii::app()->end();
        }

        $date->validate();
        $user = Yii::app()->user->getModel();
        $user->birthday = trim($date->date);
        UserScores::checkProfileScores($user->id, ScoreAction::ACTION_PROFILE_BIRTHDAY);

        if ($user->save('birthday')) {
            ob_start();
            $this->widget('HoroscopeWidget', array('user' => $user));
            $horoscope = ob_get_clean();

            echo CJSON::encode(array(
                'status' => true,
                'text' => '<span>День рождения:</span>' . Yii::app()->dateFormatter->format("d MMMM", $user->birthday) . ' (' . $user->normalizedAge . ')',
                'horoscope' => $horoscope,
                'full' => ($user->score->full == 0) ? false : true
            ));
        } else
            echo CJSON::encode(array('status' => false));
    }

    public function actionLink($text = null)
    {
        Yii::import('site.common.models.forms.*');
        $model = new LinkForm();
        if (!empty($text))
            $model->title = $text;

        if (isset($_POST['LinkForm']))
            $model->attributes = $_POST['LinkForm'];

        if (isset($_POST['ajax'])) {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }

        Yii::app()->clientScript->scriptMap = array(
            'jquery.js' => false,
            'jquery.min.js' => false,
            'jquery-ui.js' => false,
            'jquery-ui.min.js' => false,
            'jquery.ba-bbq.js' => false,
            'jquery-ui.css' => false,
            //'jquery.yiiactiveform.js'=>false
        );

        $this->renderPartial('link', compact('model'), false, true);
    }

    public function actionServiceUsed(){
        $service = Service::model()->findByPk(Yii::app()->request->getPost('id'));
        $service->userUsedService();
    }
}