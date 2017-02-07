<?php

namespace site\frontend\modules\chat\components;

interface IChat
{
    /**
     * @param array $participants
     */
    function onCreate($participants);
    function onMessage();
}