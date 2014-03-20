<?php
class WebUser extends CWebUser
{
    private $_model = null;

    public function getModel()
    {
        if (! $this->isGuest && $this->_model === null)
            $this->_model = User::model()->findByPk($this->id);
        return $this->_model;
    }

    protected function afterLogin($fromCookie)
    {
        $model = $this->getModel();
        
        $model->login_date = date('Y-m-d H:i:s');
        $model->online = 1;
        $model->last_ip = $_SERVER['REMOTE_ADDR'];
        $model->update(array('login_date', 'online', 'last_ip'));

        if (! $fromCookie) {
            Yii::import('site.frontend.modules.cook.models.*');
            CookRecipe::checkRecipeBookAfterLogin($model->id);
        }

        Yii::app()->request->cookies['not_guest'] = new CHttpCookie('not_guest', '1', array('expire' => time() + 3600*24*100));
    }

    protected function afterLogout()
    {
        $model = $this->getModel();

        $model->online = 0;
        $model->update(array('online'));

        unset(Yii::app()->request->cookies['not_guest']);
    }

    protected function beforeLogin($id, $states, $fromCookie)
    {
        $referrer = Yii::app()->request->getUrlReferrer();
        $loginUrl = $this->loginUrl;
        if (is_array($loginUrl)) {
            $route = isset($loginUrl[0]) ? $loginUrl[0] : Yii::app()->defaultController;
            $loginUrl = Yii::app()->createAbsoluteUrl($route,array_splice($loginUrl,1));
        }

        if ($referrer !== null && $referrer != $loginUrl)
            Yii::app()->user->returnUrl = Yii::app()->request->getUrlReferrer();
        return parent::beforeLogin($id, $states, $fromCookie);
    }

    public function getRememberDuration()
    {
        return 3600*24*14;
    }

    public function login($identity, $duration = null)
    {
        if ($duration === null)
            $duration = $this->getRememberDuration();
        return parent::login($identity, $duration);
    }
}