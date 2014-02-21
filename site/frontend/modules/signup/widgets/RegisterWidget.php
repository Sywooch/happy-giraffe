<?php
/**
 * Created by JetBrains PhpStorm.
 * User: mikita
 * Date: 20/02/14
 * Time: 11:44
 * To change this template use File | Settings | File Templates.
 */

class RegisterWidget extends CWidget
{
    public function run()
    {
        Yii::app()->clientScript->registerPackage('ko_registerWidget');
        $model = new User();
        $daysRange = range(1, 31);
        $json = compact('daysRange');
        $this->render('RegisterWidget', compact('model', 'json'));
    }
}