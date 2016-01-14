<?php

namespace site\frontend\modules\v1\actions;

use site\frontend\modules\v1\helpers\ApiLog;
use site\frontend\modules\v1\helpers\TrustedMethods;

class RoutedAction extends \CAction
{
    #region route
    /**
     * Routing a request to a method by request type.
     *
     * @param string $get - get method name
     * @param string $post - post method name
     * @param string $update - update method name
     * @param string $delete - delete method name
     */
    protected function route($get, $post, $update, $delete)
    {
        $methods = array(
            'POST' => 'Post',
            'PUT' => 'Put',
            'DELETE' => 'Param',
            'GET' => 'Param',
        );

        /*ApiLog::i(print_r(\Yii::app()->request->restParams, true));
        ApiLog::i('GET' . print_r($_GET, true));
        ApiLog::i('POST' . print_r($_POST, true));
        ApiLog::i(print_r($_REQUEST, true));*/
        try {
            $this->controller->requestType = $methods[\Yii::app()->request->requestType];

            //ApiLog::i("Request with type " . \Yii::app()->request->requestType);
            //ApiLog::i(print_r(\Yii::app()->request->getCookies()->toArray(), true));
            if ((\Yii::app()->request->requestType == 'GET' && !TrustedMethods::isTrusted($get))
                || \Yii::app()->request->requestType != 'GET') {
                if ($post != 'login') {
                    if (\Yii::app()->user->isGuest && !$this->controller->auth()) {
                        return;
                    }

                    \Yii::app()->params['is_api_request'] = true;
                }
            }

            switch (\Yii::app()->request->requestType) {
                case 'POST':
                    $this->execute($post);
                    break;
                case 'PUT':
                    $this->execute($update);
                    break;
                case 'DELETE':
                    $this->execute($delete);
                    break;
                default:
                    $this->execute($get);
            }
        } catch (Exception $e) {
            $this->controller->setError(/*$e->getMessage()*/'SomethingWrong', 400);
        }
    }

    private function execute($action)
    {
        if ($action != null) {
            $this->$action();
        } else {
            $this->controller->setError("NotSupportedRoute", 405);
        }
    }
    #endregion
}