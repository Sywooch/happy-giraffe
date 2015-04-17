<?php
namespace site\frontend\modules\posts\modules\myGiraffe\components\channels;
use site\frontend\modules\posts\models\Content;

/**
 * @author Никита
 * @date 17/04/15
 */

abstract class BaseChannel
{
    abstract public function getUserIds(Content $post);
}