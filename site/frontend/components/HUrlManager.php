<?php
/**
 * Author: choo
 * Date: 08.06.2012
 */
class HUrlManager extends CUrlManager
{
    public function createUrl($route,$params=array(),$ampersand='&')
    {
        if (strpos($route, 'community/view') !== FALSE && (isset($params['community_id']) ? $params['community_id'] === null : true))
            Yii::log('Causing 404 errors' . "\n" . 'Controller: ' . Yii::app()->controller->id . "\n" . 'Action: ' . Yii::app()->controller->action->id . "\n", 'error');

        return parent::createUrl($route, $params, $ampersand);
    }
}
