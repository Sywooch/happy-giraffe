<?php
/**
 * Created by PhpStorm.
 * User: mikita
 * Date: 15/08/14
 * Time: 11:05
 */

namespace site\frontend\modules\blog\components;


class ArchiveUrlRule extends \CBaseUrlRule
{
    public function createUrl($manager, $route, $params, $ampersand)
    {
        if ($route == 'blog/archive/index') {
            if (isset($params['year']) && isset($params['month']) && isset($params['day']) && checkdate($params['month'], $params['day'], $params['year'])) {
                return 'archive/' . $params['year'] . '-' . str_pad($params['month'], 2, "0", STR_PAD_LEFT) . '-' . str_pad($params['day'], 2, "0", STR_PAD_LEFT);
            } else {
                return 'archive';
            }
        }
        return false;
    }

    public function parseUrl($manager, $request, $pathInfo, $rawPathInfo)
    {
        if (preg_match('#^archive\/?(.*)?#', $pathInfo, $matches)) {
            $date = $matches[1];

            $_date = explode('-', $date);

            if (count($_date) == 3 && checkdate($_date[1], $_date[2], $_date[0])) {
                $_GET['year'] = $_date[0];
                $_GET['month'] = $_date[1];
                $_GET['day'] = $_date[2];
            } else {
                $_GET['year'] = date('Y');
                $_GET['month'] = date('m');
                $_GET['day'] = date('d');
            }

            return 'blog/archive/index';
        }
        return false;
    }
} 