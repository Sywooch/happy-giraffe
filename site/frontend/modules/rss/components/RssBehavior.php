<?php
/**
 * @author Никита
 * @date 05/12/14
 */

namespace site\frontend\modules\rss\components;


abstract class RssBehavior extends \CActiveRecordBehavior
{
    abstract public function getTitle();
    abstract public function getDescription();
    abstract public function getDate();
    abstract public function getAuthor();
} 