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
    protected $maxAge = 90;
    protected $minAge = 16;

    public function run()
    {
        Yii::app()->clientScript->registerPackage('ko_registerWidget');
        $model = new User();
        $minYear = date('Y') - 90;
        $maxYear = date('Y') - 16;
        $json = compact('minYear', 'maxYear');
        $this->render('RegisterWidget', compact('model', 'json'));
    }
}