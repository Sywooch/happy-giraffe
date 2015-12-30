<?php

namespace site\frontend\modules\v1\actions;

use site\frontend\modules\v1\models\UserApiToken;

class LoginAction extends RoutedAction implements IPostProcessable
{
    public function run()
    {
        $this->controller->setAction($this);
        $this->route(null, 'login', null, null);
    }

    public function login()
    {
        if ($this->controller->auth()) {
            $this->controller->data['user'] = \User::model()->findByPk($this->controller->identity->getId());

            /*$c = new \EMongoCriteria(array(
                'condition' => array('user_id' => $this->controller->identity->getId()),
            ));*/

            //\Yii::log($this->controller->identity->getId(), 'info', 'login');

            //$c->addCondition(array('user_id' => $this->controller->identity->getId()));

            //$tokens = UserApiToken::model()->findAll(array('user_id' => $this->controller->identity->getId()));

            $token = UserApiToken::model()->findByPk($this->controller->identity->getId());

            if ($token) {
                $token->delete();
            }

            /*if ($tokens) {
                //\Yii::log(print_r($tokens, true), 'info', 'login');
                foreach ($tokens as $token) {
                    if ($token->user_id == $this->controller->identity->getId()) {
                        $token->delete();
                    }
                }
            }*/

            $this->controller->data['token'] = UserApiToken::model()->create($this->controller->data['user']);
        }
    }

    public function postProcessing(&$data)
    {
        /*$data['user'] = $data[0];
        $data['token'] = $data[1];
        unset($data[0]);
        unset($data[1]);*/

        /*$token = $data[1];
        $data = $data[0];
        $data['token'] = $token;*/
    }
}