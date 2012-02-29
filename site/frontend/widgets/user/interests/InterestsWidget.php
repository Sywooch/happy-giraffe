<?php
/**
 * Author: alexk984
 * Date: 29.02.12
 */
class InterestsWidget extends CWidget
{
    /**
     * @var User
     */
    public $user = null;

    public function run()
    {
        Yii::import('application.modules.interests.models.*');
        if (empty($this->user->interests))
            return;

        $this->render('interests', array(
            'user' => $this->user
        ));
    }
}
