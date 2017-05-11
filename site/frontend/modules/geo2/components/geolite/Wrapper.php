<?php

namespace site\frontend\modules\geo2\components\geolite;
use GeoIp2\Database\Reader;

/**
 * @author Никита
 * @date 23/03/17
 */
class Wrapper extends \CApplicationComponent
{
    public $filename;
    public $locales;

    private $_record;

    public function init()
    {
        $this->_record = new Reader($this->filename, $this->locales);
        parent::init();
    }

    public function __call($name, $parameters)
    {
        return call_user_func_array([$this->_record, $name], $parameters);
    }
}