<?php

namespace site\frontend\modules\iframe\components;

abstract class BaseVoteManager
{
    abstract public function loadAnswerData($answers, $userId);

    abstract public function isVoted($answerId, $userId);
}