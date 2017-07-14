<?php

namespace site\frontend\modules\geo2\components\fias;

/**
 * @author Никита
 * @date 22/02/17
 */
class Field
{
    const TYPE_INTEGER = 0;
    const TYPE_STRING = 1;
    const TYPE_DATE = 2;
    
    public $name;
    public $comment;
    public $length;
    public $type;
    public $required;
}