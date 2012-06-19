<?php

class SignupController extends HController
{

    public $layout = 'signup';

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

    public function actionIndex()
    {
        $session = Yii::app()->session;
        $service = Yii::app()->request->getQuery('service');
        if (isset($service)) {
            $authIdentity = Yii::app()->eauth->getIdentity($service);
            $authIdentity->redirectUrl = $this->createAbsoluteUrl('signup/index');

            if ($authIdentity->authenticate()) {
                Yii::app()->user->setFlash('regdata', $authIdentity->getItemAttributes());
                $name = $authIdentity->getServiceName();
                $id = $authIdentity->getAttribute('id');
                $check = UserSocialService::model()->findByAttributes(array(
                    'service' => $name,
                    'service_id' => $id,
                ));
                if ($check) {
                    $this->redirect(array('/site/login', 'service' => $service, 'register' => true));
                }
                $session['service'] = array(
                    'name' => $name,
                    'id' => $id,
                );
            }

            $authIdentity->redirect();
        }
        $regdata = Yii::app()->user->getFlash('regdata');

        $model = new User;

        $this->render('index', array(
            'model' => $model,
            'regdata' => $regdata,
        ));
    }

    public function actionFinish()
    {
        $session = Yii::app()->session;
        $model = new User('signup');

        if (isset($_POST['User'])) {
            $model->attributes = $_POST['User'];
            $current_service = $session['service'];
            if ($current_service) {
                $service = new UserSocialService;
                $service->setAttributes(array(
                    'service' => $current_service['name'],
                    'service_id' => $current_service['id'],
                ));
                $model->social_services = array($service);
            }
            $model->register_date = date('Y-m-d H:i:s');
            if ($model->save(true, array('first_name', 'last_name', 'password', 'email', 'gender', 'birthday'))) {

                if (isset($_POST['User']['avatar'])) {
                    $url = $_POST['User']['avatar'];
                    $src = AlbumPhoto::model()->getTempPath() . 'avatar.jpeg';
                    file_put_contents($src, file_get_contents($url));
                    file_put_contents(AlbumPhoto::model()->getOriginalPath() . 'avatar.jpeg', file_get_contents($url));

                    $photo = new AlbumPhoto;
                    $photo->file_name = 'avatar.jpeg';
                    $photo->fs_name = 'avatar.jpeg';
                    $photo->author_id = $model->id;
                    $photo->save();

                    $picture = new Imagick($src);

                    $a1 = clone $picture;
                    $a1->resizeimage(24, 24, imagick::COLOR_OPACITY, 1);
                    $a1->writeImage($photo->getAvatarPath('small'));

                    $a2 = clone $picture;
                    $a2->resizeimage(72, 72, imagick::COLOR_OPACITY, 1);
                    $a2->writeImage($photo->getAvatarPath('ava'));

                    $attach = new AttachPhoto;
                    $attach->entity = 'User';
                    $attach->entity_id = $model->id;
                    $attach->photo_id = $photo->id;
                    $attach->save();

                    $model->avatar_id = $photo->id;
                    $model->save();
                }

                unset($session['service']);
                $identity = new UserIdentity($model->getAttributes());
                $identity->authenticate();
                Yii::app()->user->login($identity);
                $model->login_date = date('Y-m-d H:i:s');
                $model->last_ip = $_SERVER['REMOTE_ADDR'];
                $model->save(false);
                if (!Yii::app()->request->getQuery('redirectUrl') || Yii::app()->request->getQuery('redirectUrl') == '')
                    $this->redirect(array('/user/profile', 'user_id' => $model->id));
                else
                    $this->redirect(array(urldecode(Yii::app()->request->getQuery('redirectUrl'))));
            }
        }
    }

    public function actionValidate($step)
    {
        $steps = array(
            array('first_name', 'password', 'email', 'verifyCode'),
            array('gender'),
        );

        $model = new User('signup');
        $model->setAttributes($_POST['User']);

        if ($model->validate($steps[$step - 1])) {
            $response = array(
                'status' => 'ok',
            );
        } else {
            $errors = $model->getErrors();
            $_errors = array();
            foreach ($errors as $attribute) {
                foreach ($attribute as $error) {
                    $_errors[] = $error;
                }
            }
            $errors = $this->renderPartial('errors', array('errors' => $_errors), TRUE);
            $response = array(
                'status' => 'error',
                'errors' => $errors,
            );
        }
        echo CJSON::encode($response);
    }

}