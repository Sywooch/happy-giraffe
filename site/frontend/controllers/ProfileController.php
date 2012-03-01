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
            $this->user->save(true, array('last_name', 'first_name', 'gender', 'email', 'settlement_id', 'birthday',
            'country_id', 'street_id', 'house', 'room'));
        }

        $this->render('data', array(

        ));
    }

    public function actionPhoto()
    {
        if (isset($_POST['User'])) {
            $this->user->attributes = $_POST['User'];
            $this->user->save(true, array('pic_small'));
        }

        $this->render('photo');
    }

    public function actionFamily()
    {
        $maxBabies = 10;
        for ($i = 0; $i < $maxBabies; $i++)
        {
            $baby_models[] = (isset($this->user->babies[$i]) && $this->user->babies[$i] instanceof Baby) ? $this->user->babies[$i] : new Baby;
        }

        if (isset($_POST['relationship_status'])) {
            $this->user->relationship_status = $_POST['relationship_status'];
            if (User::relationshipStatusHasPartner($_POST['relationship_status'])){
                UserPartner::savePartner($this->user->id);
            }else
                UserPartner::model()->deleteAll('user_id='.$this->user->id);

            $this->user->update(array('relationship_status'));
        }

        if (isset($_POST['Baby'])) {
            for ($i = 0; $i < $maxBabies; $i++)
            {
                if($_POST['Baby'][$i]['isset'] == 0)
                    continue;
                $baby_models[$i]->attributes = $_POST['Baby'][$i];
                $baby_models[$i]->birthday = $_POST['Baby'][$i]['year'] . '-' . (mb_strlen($_POST['Baby'][$i]['month']) > 1 ? $_POST['Baby'][$i]['month'] : '0'.$_POST['Baby'][$i]['month']) . '-' . (mb_strlen($_POST['Baby'][$i]['day']) > 1 ? $_POST['Baby'][$i]['day'] : '0'.$_POST['Baby'][$i]['day']);
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
        if(isset($this->user->babies[$id]))
        {
            $model = $this->user->babies[$id];
            $model->delete();
        }
        $this->redirect(array('/profile/family'));
    }

    public function actionAccess()
    {
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

    public function actionUploadPartnerPhoto(){
        if (isset($_POST['UserPartner'])) {
            $user = $this->loadUser($_POST['User']['id']);
            if (empty($user->partner)){
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
    public function loadUser($id){
        $model = User::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');
        return $model;
    }
}