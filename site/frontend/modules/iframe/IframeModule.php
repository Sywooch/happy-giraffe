<?php

use site\frontend\modules\iframe\modules\admin\models\FramePartners;

/*
 * Iframe приложение для партнеров
 */
class IframeModule extends \CWebModule
{
    public function init()
    {
        // Используем новый AuthManager
        \Yii::app()->setComponent('authManager', array(
            'class' => '\site\frontend\components\AuthManager',
        ));
        \Yii::app()->clientScript->registerPackage('iframe');

        $iframeKey = \Yii::app()->request->getQuery('iframe-key');
        $this->initIframeKey($iframeKey);

        // Cписок модулей
        $this->setModules([
            'userProfile' => [
                'class' => 'site\frontend\modules\iframe\modules\userProfile\UserProfileModule',
            ],
            'specialists' => [
                'class' => 'site\frontend\modules\iframe\modules\specialists\SpecialistsModule',
            ],
            'family' => [
                'class' => 'site\frontend\modules\iframe\modules\family\FamilyModule',
            ],
            'notifications' => [
                'class' => 'site\frontend\modules\iframe\modules\notifications\NotificationsModule',
            ],
            'admin' => [
                'class' => 'site\frontend\modules\iframe\modules\admin\AdminModule',
            ],
        ]);
    }

    protected function initIframeKey($key)
    {
        $session=new \CHttpSession;
        $session->open();
        if(!empty($session->get("partner"))){
            if($session['partner']['type'] == 'domain' || $session['partner']['type'] == 'subdomain'){
                if($session['partner']['key'] != md5($_SERVER['HTTP_HOST'])){
                    $session->remove('partner');
                }
            } else {
                return true;
            }
        }
        if(
            substr_count(\Yii::app()->request->requestUri, '/iframe/admin/') ||
            $this->setPartnersSession($key)
        ) {
            return true;
        }
        throw new \CHttpException(404);
    }

    protected function setPartnersSession($key)
    {
        $session=new \CHttpSession;
        $session->open();
        if(empty($key)){
            $key = md5($_SERVER['HTTP_HOST']);
        }
        $model = FramePartners::model()->findByAttributes(array('key' => $key));
        if (count($model)) {
            $session['partner'] = [
                'id' => $model->id,
                'type' => $model->type,
                'description' => $model->description,
                'key' => $key,
            ];
            return true;
        }
        return false;
    }
}
