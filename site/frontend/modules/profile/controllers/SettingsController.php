<?php

class SettingsController extends HController
{
    public $layout = 'settings';
    public $tempLayout = true;
    public $user;
    public $title = 'Мои настройки';

    public function filters()
    {
        return array(
            'accessControl',
            'ajaxOnly - personal, social, subscribes, password, captcha, remove, socialAuth',
        );
    }

    public function accessRules()
    {
        return array(
            array('deny',
                'users' => array('?'),
            ),
        );
    }

    public function actions()
    {
        return array(
            'captcha' => array(
                'class' => 'CaptchaAction',
                'backColor' => 0xFFFFFF,
                'width' => 128,
                'height' => 45,
                'onlyDigits' => TRUE,
            ),
            'socialAuth' => array(
                'class' => 'SocialAction',
                'successCallback' => function($eauth) {
                    $model = new UserSocialService();
                    $model->user_id = Yii::app()->user->id;
                    $model->service_id = $eauth->getAttribute('uid');
                    $model->service = $eauth->getServiceName();
                    $model->name = $eauth->getAttribute('first_name') . ' ' . $eauth->getAttribute('last_name');
                    $model->save();

                    $eauth->redirect(Yii::app()->controller->createUrl('social'));
                },
            ),
        );
    }

    public function beforeAction($action)
    {
        $this->user = Yii::app()->user->getModel();

        return parent::beforeAction($action);
    }

    public function actionPersonal()
    {
        $this->pageTitle = 'Мои настройки - Личные данные';
        $this->render('personal');
    }

    public function actionSocial()
    {
        $this->pageTitle = 'Мои настройки - Социальные сети';
        $this->render('social');
    }

    public function actionSubscribes()
    {
        $this->pageTitle = 'Мои настройки - Рассылки';
        $form = new SubscribesForm(Yii::app()->user->id);
        $this->render('subscribes', compact('form'));
    }

    public function actionRemoveService()
    {
        $id = Yii::app()->request->getPost('id');
        $service = UserSocialService::model()->findByAttributes(array(
            'id' => $id,
            'user_id' => Yii::app()->user->id,
        ));
        if ($service !== null)
            echo CJavaScript::encode($service->delete());
    }

    public function actionPassword()
    {
        $this->pageTitle = 'Мои настройки - Изменение пароля';
        $this->user->scenario = 'change_password';

        if (isset($_POST['User'])) {
            $this->user->attributes = $_POST['User'];
            if ($this->user->validate(array('current_password', 'new_password', 'new_password_repeat', 'verifyCode'))) {
                $this->user->password = $this->user->new_password;
                $this->user->save(true, array('password'));
                Yii::app()->user->setFlash('success', 1);
            }
        }

        $this->render('password', array(
            'user' => $this->user,
        ));
    }

    public function actionSetValue()
    {
        $attr = Yii::app()->request->getPost('attribute');
        $value = Yii::app()->request->getPost('value');
        if (in_array($attr, array('first_name', 'last_name', 'birthday', 'gender'))) {
            $this->user->$attr = $value;
            $success = $this->user->save();
            User::clearCache();
            echo CJSON::encode(array(
                'status' => $success,
                'error' => $this->user->getErrorsText()
            ));
        }
    }

    public function actionMailSubscription(){
        $value = Yii::app()->request->getPost('value');
        Yii::app()->user->getModel()->getMailSubs()->weekly_news = $value;
        Yii::app()->user->getModel()->getMailSubs()->save();
    }

    public function actionRemove()
    {
        FriendEvent::userDeleted($this->user);
        $this->user->deleted = 1;
        $this->user->update(array('deleted'));
        User::clearCache();
        Yii::app()->user->logout();
        $this->redirect('/');
    }

    public function actionRegions(){
        $country_id = Yii::app()->request->getPost('country_id');
        echo CJSON::encode(GeoRegion::getRegions($country_id));
    }

    public function actionCities()
    {
        $term = Yii::app()->request->getPost('term');
        $region_id = Yii::app()->request->getPost('region_id');
        $filter_parts = FilterParts::model()->findAll();
        foreach ($filter_parts as $filter_part) {
            $term = str_replace($filter_part->part . ' ', '', $term);
        }
        $term = trim($term);

        $cities = GeoCity::model()->findAll(array(
            'condition' => 't.name LIKE :term AND t.region_id = :region_id',
            'params' => array(
                ':term' => $term . '%',
                ':region_id' => $region_id,
            ),
            'limit' => 10,
            'with' => array(
                'district'
            )
        ));

        $_cities = array();
        foreach ($cities as $city) {
            $_cities[] = array(
                'label' => $city->getLabel($cities),
                'name' => $city->name,
                'id' => (int)$city->id,
            );
        }
        echo CJSON::encode($_cities);
    }

    public function actionSaveLocation()
    {
        $country_id = Yii::app()->request->getPost('country_id');
        $region_id = Yii::app()->request->getPost('region_id');
        $city_id = Yii::app()->request->getPost('city_id');

        $user = Yii::app()->user->getModel();
        $address = $user->address;
        $address->country_id = empty($country_id) ? null : $country_id;
        $address->region_id = empty($region_id) ? null : $region_id;
        $address->city_id = empty($city_id) ? null : $city_id;

        echo CJSON::encode(array('status' => $address->save()));
    }
}