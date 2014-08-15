<?php
/**
 * Created by PhpStorm.
 * User: mikita
 * Date: 15/08/14
 * Time: 11:05
 */

namespace site\frontend\modules\archive\components;


class ArchiveUrlRule extends \CBaseUrlRule
{
    public function createUrl($manager, $route, $params, $ampersand)
    {
        if ($route == 'archive/default/index') {
            if (isset($params['year']) && isset($params['month']) && isset($params['day']) && checkdate($params['month'], $params['day'], $params['year'])) {
                $url = 'archive/' . $params['year'] . '-' . str_pad($params['month'], 2, "0", STR_PAD_LEFT) . '-' . str_pad($params['day'], 2, "0", STR_PAD_LEFT);
            } else {
                $url = 'archive';
            }
            unset($params['year']);
            unset($params['month']);
            unset($params['day']);

            if (! empty($params)) {
                $url .= $manager->urlSuffix . '?' . $manager->createPathInfo($params, '=', $ampersand);
            }
            return $url;
        }
        return false;
    }

    public function parseUrl($manager, $request, $pathInfo, $rawPathInfo)
    {
        if (preg_match('#^archive\/?(.*)?#', $pathInfo, $matches)) {
            $date = $matches[1];

            $_date = explode('-', $date);

            if (count($_date) == 3 && strlen($_date[1]) == 2 && strlen($_date[2]) == 2 && checkdate($_date[1], $_date[2], $_date[0])) {
                $_GET['year'] = $_date[0];
                $_GET['month'] = $_date[1];
                $_GET['day'] = $_date[2];
            } else {
                if ($date == '') {
                    $_GET['year'] = date('Y');
                    $_GET['month'] = date('m');
                    $_GET['day'] = date('d');
                } else {
                    \Yii::app()->request->redirect(\Yii::app()->createUrl('archive/default/index'));
                }
            }

            return 'archive/default/index';
        }
        return false;
    }
} 