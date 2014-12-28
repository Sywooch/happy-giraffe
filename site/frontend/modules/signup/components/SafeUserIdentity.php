<?php

namespace site\frontend\modules\signup\components;

/**
 * @author Никита
 * @date 28/12/14
 */

class SafeUserIdentity extends \CBaseUserIdentity
{
    public $user;

    public function __construct(\User $user)
    {
        $this->user = $user;
    }

    public function authenticate()
    {
        foreach ($this->user->attributes as $k => $v)
            $this->setState($k, $v);
        return true;
    }

    public function getId()
    {
        return $this->getState('id');
    }

    public function getName()
    {
        return $this->getState('first_name');
    }
} 