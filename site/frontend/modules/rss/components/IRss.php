<?php

namespace site\frontend\modules\rss\components;

/**
 * @author Никита
 * @date 28/11/14
 */

interface IRss
{
    public function getTitle();
    public function getDescription();
    public function getDate();
    public function getAuthor();
} 