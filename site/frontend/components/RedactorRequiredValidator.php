<?php
/**
 * Created by JetBrains PhpStorm.
 * User: mikita
 * Date: 14/03/14
 * Time: 19:00
 * To change this template use File | Settings | File Templates.
 */

class RedactorRequiredValidator extends CRequiredValidator
{
    protected function isEmpty($value, $trim = false)
    {
        $value = preg_replace("#<p>(<br>)?[\xe2\x80\x8b ]*<\/p>#u", '', $value);
        return parent::isEmpty($value, $trim);
    }
}