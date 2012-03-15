<?php

class ProfileController extends Controller
{
    /**
     * @var User
     */
    public $user;

    public function actions()
    {
        return array(
            'captcha' => array(
                'class' => 'CaptchaAction',
                'backColor' => 0xFFFFFF,
                'width' => 125,
                'height' => 46,
                'onlyDigits' => TRUE,
            ),
        );
    }

    public function filters()
    {
        return array(
            'accessControl',
        );
    }

    public function accessRules()
    {
        return array(
            array('allow',
                'users' => array('@'),
            ),
            array('deny',
                'users' => array('*'),
            ),
        );
    }

    public $layout = '//layouts/profile';

    protected function beforeAction($action)
    {
        Yii::import('site.frontend.modules.geo.models.*');
        $this->user = User::model()->with('settlement')->findByPk(Yii::app()->user->getId());
        return true;
    }

    public function actionIndex()
    {
        if (isset($_POST['User'])) {
            $address = new AddressForm();
            $address->attributes = $_POST;
            $address->saveAddress($this->user);
            $this->user->attributes = $_POST['User'];

            if (isset($_POST['User']['last_name']) && isset($_POST['User']['first_name']) &&
                isset($_POST['User']['gender']) && isset($_POST['city_id']) &&
                isset($_POST['User']['birthday'])
            ) {
                //add scores to user
                Yii::import('site.frontend.modules.scores.models.*');
                UserScores::checkProfileScores(Yii::app()->user->getId(), ScoreActions::ACTION_PROFILE_MAIN);
            }

            $this->user->save(true, array('last_name', 'first_name', 'gender', 'email', 'settlement_id', 'birthday',
                'country_id', 'street_id', 'house', 'room'));
        }

        $this->render('data', array());
    }

    public function actionPhoto($returnUrl = null)
    {
        if (isset($_POST['User'])) {
            $this->user->attributes = $_POST['User'];
            if ($this->user->save(true, array('pic_small'))){
                //add scores to user
                Yii::import('site.frontend.modules.scores.models.*');
                UserScores::checkProfileScores(Yii::app()->user->getId(), ScoreActions::ACTION_PROFILE_PHOTO);
            }
            if (isset($_POST['returnUrl']) && !empty($_POST['returnUrl']))
                $this->redirect(urldecode($_POST['returnUrl']));
        }

        $this->render('photo', array(
            'returnUrl' => $returnUrl
        ));
    }

    public function actionFamily()
    {
        $maxBabies = 10;
        for ($i = 0; $i < $maxBabies; $i++)
            $baby_models[] = (isset($this->user->babies[$i]) && $this->user->babies[$i] instanceof Baby) ? $this->user->babies[$i] : new Baby;

        if (isset($_POST['User']['relationship_status'])) {
            $this->user->relationship_status = $_POST['User']['relationship_status'];
            if (User::relationshipStatusHasPartner($_POST['User']['relationship_status'])) {
                UserPartner::savePartner($this->user->id);
            } else{
                UserPartner::model()->deleteAll('user_id=' . $this->user->id);

                //add scores to user
                Yii::import('site.frontend.modules.scores.models.*');
                UserScores::checkProfileScores(Yii::app()->user->getId(), ScoreActions::ACTION_PROFILE_FAMILY);
            }

            $this->user->update(array('relationship_status'));
            $this->user->refresh();
        }

        if (isset($_POST['Baby'])) {
            $files_copy = $_FILES;
            for ($i = 0; $i < $maxBabies; $i++)
            {
                if ($_POST['Baby'][$i]['isset'] == 0)
                    continue;

                $_FILES['Baby']['tmp_name']['photo'] = $files_copy['Baby']['tmp_name'][$i]['photo'];
                $_FILES['Baby']['name']['photo'] = $files_copy['Baby']['name'][$i]['photo'];
                $_FILES['Baby']['type']['photo'] = $files_copy['Baby']['type'][$i]['photo'];
                $_FILES['Baby']['error']['photo'] = $files_copy['Baby']['error'][$i]['photo'];
                $_FILES['Baby']['size']['photo'] = $files_copy['Baby']['size'][$i]['photo'];
                UFiles::prefetchFiles();

                $baby_models[$i]->attributes = $_POST['Baby'][$i];
                if (isset($_POST['Baby'][$i]['photo']) && !empty($_POST['Baby'][$i]['photo']))
                    $baby_models[$i]->photo = $_POST['Baby'][$i]['photo'];
                $baby_models[$i]->birthday = $_POST['Baby'][$i]['year'] . '-'
                    . (mb_strlen($_POST['Baby'][$i]['month']) > 1 ? $_POST['Baby'][$i]['month'] : '0' . $_POST['Baby'][$i]['month']) . '-'
                    . (mb_strlen($_POST['Baby'][$i]['day']) > 1 ? $_POST['Baby'][$i]['day'] : '0' . $_POST['Baby'][$i]['day']);
                $baby_models[$i]->parent_id = Yii::app()->user->id;
                $baby_models[$i]->save();
            }
        }
        $this->render('family', array(
            'maxBabies' => $maxBabies,
            'baby_models' => $baby_models,
        ));
    }

    public function actionRemoveBaby($id)
    {
        if (isset($this->user->babies[$id])) {
            $model = $this->user->babies[$id];
            $model->delete();
        }
        $this->redirect(array('/profile/family'));
    }

    public function actionAccess()
    {
        if (isset($_POST['User'])) {
            $this->user->attributes = $_POST['User'];
            $this->user->save(true, array('profile_access', 'guestbook_access', 'im_access'));
        }

        $this->render('access');
    }

    public function actionBlacklist()
    {
        $this->render('blacklist');
    }

    public function actionSubscription()
    {
        $this->render('subscription');
    }

    public function actionSocials()
    {
        $this->render('socials');
    }

    public function actionPassword()
    {
        $this->user->scenario = 'change_password';

        if (isset($_POST['User'])) {
            $this->user->attributes = $_POST['User'];
            if ($this->user->validate(array('current_password', 'new_password', 'new_password_repeat', 'verifyCode'))) {
                $this->user->password = $this->user->new_password;
                $this->user->save(true, array('password'));
            }
        }

        $this->render('password', array(
            'user' => $this->user,
        ));
    }

    public function actionRemove()
    {
        $this->user->deleted = 1;
        $this->user->save();
        Yii::app()->user->logout();
        $this->redirect(array('/site/index'));
    }

    public function actionUploadPartnerPhoto()
    {
        if (isset($_POST['UserPartner'])) {
            $user = $this->loadUser($_POST['User']['id']);
            if (empty($user->partner)) {
                $partner = new UserPartner;
                $partner->user_id = $user->id;
            }
            else
                $partner = $user->partner;
            $partner->photo = $_POST['UserPartner']['photo'];
            if ($partner->save()) {
                $response = array(
                    'status' => true,
                    'url' => $partner->photo->getUrl('ava'),
                    'title' => '',
                );
            }
            else
            {
                $response = array(
                    'status' => false,
                );
            }
            echo CJSON::encode($response);
        }
    }

    /**
     * @param int $id model id
     * @return User
     * @throws CHttpException
     */
    public function loadUser($id)
    {
        $model = User::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');
        return $model;
    }

    /**
     * @param int $id model id
     * @return Baby
     * @throws CHttpException
     */
    public function loadBaby($id)
    {
        $model = Baby::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');
        return $model;
    }

    public function actionPreview()
    {
        $dst = '/upload/preview/' . time() . '_' . $_FILES['Baby']['name'][$_POST['baby_num']]['photo'];
        FileHandler::run($_FILES['Baby']['tmp_name'][$_POST['baby_num']]['photo'], Yii::getPathOfAlias('webroot') . $dst, array(
            'accurate_resize' => array(
                'width' => 76,
                'height' => 79,
            ),
        ));
        echo Yii::app()->baseUrl . $dst;
    }

    public function actionRemoveBabyPhoto()
    {
        $baby = $this->loadBaby($_POST['id']);
        if ($baby->parent_id == Yii::app()->user->getId()) {
            $baby->photo = null;
            if ($baby->save()) {
                $response = array(
                    'status' => true,
                    'img' => '/images/profile_age_img_01.png'
                );
                echo CJSON::encode($response);
            }
        }
    }

    public function actionRemovePartnerPhoto()
    {
        $user = $this->loadUser(Yii::app()->user->getId());
        $user->partner->photo = null;
        if ($user->partner->save()) {

            $response = array(
                'status' => true,
            );
            echo CJSON::encode($response);
        }
    }

    public function actionRemovePhoto()
    {
        $res = Yii::app()->db->createCommand('update user set pic_small = null WHERE id = '.Yii::app()->user->getId())->execute();
        if ($res > 0) {
            $response = array(
                'status' => true,
            );
            echo CJSON::encode($response);
        }
    }

    public function actionDisableSocialService($name)
    {
        $check = UserSocialService::model()->findByUser($name, Yii::app()->user->id);
        if ($check)
            $check->delete();
        $this->redirect($_SERVER['HTTP_REFERER']);
    }
}