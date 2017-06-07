<?php
/**
 * @author Никита
 * @date 28/12/14
 */

namespace site\frontend\modules\signup\controllers;


class RegisterController extends \HController
{

    public $params = [];

    public function actions()
    {
        return array(
            'social' => array(
                'class' => 'site\frontend\modules\signup\components\SignupSocialAction',
                'fromLogin' => false,
                // Родительский хост
                'baseHostInfo' => 'http://pediatr.net'
            ),
            'partner' => array(
                'class' => 'site\frontend\modules\signup\components\PartnerSignupSocialAction',
            ),
        );
    }
}
