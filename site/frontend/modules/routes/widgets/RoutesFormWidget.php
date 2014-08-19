<?php
/**
 * Created by PhpStorm.
 * User: mikita
 * Date: 12/08/14
 * Time: 14:33
 */

class RoutesFormWidget extends CWidget
{
    public function run()
    {
        /**
         * @var $cs ClientScript
         */
        $cs = Yii::app()->clientScript;
        $cs->registerAMD('routes', array('Routes' => 'routes'), 'Routes.initAutoComplete();');

        $this->render('RoutesFormWidget');
    }
} 