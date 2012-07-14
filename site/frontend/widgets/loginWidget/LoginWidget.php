<?php
class LoginWidget extends CWidget
{
    public function run()
    {
        if (Yii::app()->user->isGuest) {
            $basePath = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR;
            $baseUrl = Yii::app()->getAssetManager()->publish($basePath, false, 1, YII_DEBUG);
            Yii::app()->clientScript->registerScriptFile($baseUrl . '/login.js');

            $model = new User;
            $this->render('form', array('model' => $model));
        } else {
            $this->render('cabinet');
        }
    }
}
