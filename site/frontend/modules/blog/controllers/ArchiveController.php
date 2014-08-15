<?php
/**
 * Created by PhpStorm.
 * User: mikita
 * Date: 14/08/14
 * Time: 16:30
 */

class ArchiveController extends LiteController
{
    public function actionIndex($year, $month, $day)
    {
        $dp = new MultiModelDataProvider(array(
            'CommunityContent' => array(),
            'CookRecipe' => array(),
        ), 'created');
        $this->render('index', compact('dp', 'year', 'month', 'day'));
    }
} 