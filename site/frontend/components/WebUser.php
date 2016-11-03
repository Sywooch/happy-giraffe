<?php
use Aws\CloudFront\Exception\Exception;

class WebUser extends CWebUser
{
    /**
     * @property User $_model
     */
    private $_model = null;

    private $_apiModel = null;

    /**
     * @return User
     */
    public function getModel()
    {
        Yii::import('site.common.models.User');
        if (! $this->isGuest && $this->_model === null) {
            $this->_model = User::model()->findByPk($this->id);
        }
        return $this->_model;
    }

    public function getApiModel()
    {
        if (! $this->_apiModel) {
            $this->_apiModel = \site\frontend\components\api\models\User::model()->query('get', array(
                'id' => (int) $this->id,
                'avatarSize' => \Avatar::SIZE_MEDIUM,
            ));
        }
        return $this->_apiModel;
    }

    protected function afterLogin($fromCookie)
    {
        $model = $this->getModel();

        OnlineManager::online($model, true);

        if (! $fromCookie) {
            Yii::import('site.frontend.modules.cook.models.*');
            CookRecipe::checkRecipeBookAfterLogin($model->id);
        }

        /** @todo костыль */
        if ($model->specialistProfile !== null) {
            $this->returnUrl = Yii::app()->createUrl('/specialists/pediatrician/default/questions');
        }

        Yii::app()->request->cookies['not_guest'] = new CHttpCookie('not_guest', '1', array('expire' => time() + 3600*24*100));
    }

    protected function beforeLogout()
    {
        if (Yii::app()->user->isGuest) {
            return false;
        }

        $model = $this->getModel();
        OnlineManager::offline($model);
        \User::clearCache();
        unset(Yii::app()->request->cookies['not_guest']);
        return parent::beforeLogout();
    }

    protected function beforeLogin($id, $states, $fromCookie)
    {
        $referrer = Yii::app()->request->getUrlReferrer();
        $loginUrl = $this->loginUrl;
        if (is_array($loginUrl)) {
            $route = isset($loginUrl[0]) ? $loginUrl[0] : Yii::app()->defaultController;
            $loginUrl = Yii::app()->createAbsoluteUrl($route,array_splice($loginUrl,1));
        }

        if ($referrer !== null && $referrer != $loginUrl) {
            /** @todo: fix 'Creating default object from empty value'*/
            $this->setReturnUrl($referrer);
        }
        return parent::beforeLogin($id, $states, $fromCookie);
    }

    public function getRememberDuration()
    {
        return 3600*24*14;
    }

    public function login($identity, $duration = null)
    {
        if ($duration === null) {
            $duration = $this->getRememberDuration();
        }
        return parent::login($identity, $duration);
    }
}