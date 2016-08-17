<?php

namespace site\frontend\modules\quests\components;

interface IQuest
{
    function getHandledEvents();
    function run($model, $event);
}