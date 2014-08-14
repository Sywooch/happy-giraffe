<?php
/**
 * Created by PhpStorm.
 * User: mikita
 * Date: 14/08/14
 * Time: 16:30
 */

class CalendarController extends HController
{
    public function actionIndex()
    {
        $dp = new site\frontend\components\multiModel\DataProvider(array(
            'CommunityContent' => array(),
            'CookRecipe' => array(),
        ), 'created');


    }
} 