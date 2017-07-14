<?php

namespace site\frontend\modules\geo2\components\fias\output;

/**
 * @author Никита
 * @date 22/02/17
 */
abstract class Output extends \CComponent
{
    abstract public function output($query);
    abstract public function finish();
}