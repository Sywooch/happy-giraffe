<?php
/**
 * Author: alexk984
 * Date: 13.05.12
 */
class SController extends CController
{
    public $pageTitle = '';
    public $fast_nav = null;

    public function filters()
    {
        return array(
            'accessControl',
        );
    }

    public function accessRules()
    {
        return array(
            array('allow',
                'users' => array('@'),
            ),
            array('deny',
                'users' => array('*'),
            ),
        );
    }
}
