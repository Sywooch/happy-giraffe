<?php
/**
 * @author Никита
 * @date 28/12/14
 */

namespace site\frontend\modules\signup\controllers;


class RegisterController extends \HController
{
    public function actions()
    {
        return array(
            'social' => array(
                'class' => 'site\frontend\modules\signup\components\SignupSocialAction',
                'fromLogin' => false,
                // Родительский хост
                'baseHostInfo' => 'http://ds1.localhosttt.dev'
            ),
        );
    }
}
