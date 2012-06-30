<?php
/**
 * Author: choo
 * Date: 27.06.2012
 */
class JunkController extends HController
{
    function actionIndex($lol = null)
    {
        echo Yii::app()->request->url . Yii::app()->user->id;
    }
}
