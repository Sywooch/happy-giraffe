<?php
/**
 * @var $commentators CommentatorWork[]
 * @var $team int
 *
 * @author Alex Kireev <alexk984@gmail.com>
 */
foreach ($commentators as $commentator)
    if ($commentator->team == $team)
        $this->renderPartial('_user_name', array('user' => $commentator->getUserModel()));
