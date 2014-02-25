<?php

class RegisterController extends HController
{
    public function actions()
    {
        return array(
            'captcha' => array(
                'class' => 'CaptchaExtendedAction',
                'mode' => CaptchaExtendedAction::MODE_WORDS,
            ),
            'social' => array(
                'class' => 'signup.components.SocialAction',
                'successCallback' => function($eauth) {
                    $eauth->component->setRedirectView('signup.views.redirect');
                    $eauth->redirect(null, array(
                        'attributes' => $eauth->getAttributes(),
                        'fromLogin' => false,
                    ));
                }
            ),
        );
    }

    public function actionTest2()
    {
        $this->render('test2');
    }

    public function actionStep1()
    {
        $model = new RegisterFormStep1('signupStep1');
        $this->performAjaxValidation($model);

        $model->attributes = $_POST['RegisterFormStep1'];
        $model->registration_finished = 0;
        $success = $model->save();
        $response['success'] = $success;
        if ($success)
            $response['id'] = $model->id;
        echo CJSON::encode($response);
    }

    public function actionStep2()
    {
        $userId = Yii::app()->request->getPost('userId');
        $social = Yii::app()->request->getPost('social');
        $scenario = ($social == 'true') ? 'signupStep2Social' : 'signupStep2';
        $model = empty($userId) ? new RegisterFormStep2() : RegisterFormStep2::model()->findByPk($userId);
        $model->scenario = $scenario;
        $this->performAjaxValidation($model);

        $model->attributes = $_POST['RegisterFormStep2'];
        $success = $model->save();
        $response['success'] = $success;
        if ($success)
            $model->register();
        echo CJSON::encode($response);
    }

    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && in_array($_POST['ajax'], array('registerFormStep1', 'registerFormStep2', 'registerSocial')))
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}