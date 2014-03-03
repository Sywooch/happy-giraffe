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
        $this->model->login_date = date('Y-m-d H:i:s');
        $this->model->online = 1;
        $this->model->last_ip = $_SERVER['REMOTE_ADDR'];
        $this->model->update(array('login_date', 'online', 'last_ip'));

        Yii::import('site.frontend.modules.cook.models.*');
        CookRecipe::checkRecipeBookAfterLogin($this->model->id);

        Yii::app()->request->cookies['not_guest'] = new CHttpCookie('not_guest', '1', array('expire' => time() + 3600*24*100));
    }

    protected function afterLogout()
    {
        $this->model->online = 0;
        $this->model->update(array('online'));

        unset(Yii::app()->request->cookies['not_guest']);
    }

    protected function beforeLogin($id, $states, $fromCookie)
    {
        Yii::app()->user->returnUrl = Yii::app()->request->getUrlReferrer();
        return parent::beforeLogin($id, $states, $fromCookie);
    }
}