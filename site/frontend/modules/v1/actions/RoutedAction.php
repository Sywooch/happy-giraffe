<?php

namespace site\frontend\modules\v1\actions;

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
            'DELETE' => 'Delete',
            'GET' => 'Param',
        );

        $this->controller->requestType = $methods[\Yii::app()->request->requestType];

        if (\Yii::app()->request->requestType != 'GET' && $post != 'login') {
            if (!$this->controller->auth()) {
                return;
            }

            \Yii::app()->params['is_api_request'] = true;
        }

        switch($this->controller->requestType){
            case 'Post':
                $this->execute($post);
                break;
            case 'Put':
                $this->execute($update);
                break;
            case 'Delete':
                $this->execute($delete);
                break;
            default:
                $this->execute($get);
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