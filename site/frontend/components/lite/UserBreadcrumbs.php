<?php
/**
 * @author Никита
 * @date 25/11/14
 */

namespace site\frontend\components\lite;

\Yii::import('zii.widgets.CBreadcrumbs');

class UserBreadcrumbs extends \CBreadcrumbs
{
    public $user;

    public function run()
    {
        if ($this->user !== null) {
            $avatar = $this->widget('Avatar', array(
                'user' => $this->user,
                'size' => \Avatar::SIZE_MICRO,
                'tag' => 'span',
            ), true);
            $this->links = array($avatar => array('/profile/default/index', 'user_id' => $this->user->id)) + $this->links;
        }
        parent::run();
    }
} 