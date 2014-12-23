<?php
/**
 * @author Никита
 * @date 05/12/14
 */

namespace site\frontend\modules\rss\components;


abstract class RssBehavior extends \CActiveRecordBehavior
{
    abstract public function getRssTitle();
    abstract public function getRssDescription();
    abstract public function getRssDate();
    abstract public function getRssAuthor();
    abstract public function getRssUrl();
} 