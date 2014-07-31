<?php
/**
 * Created by PhpStorm.
 * User: mikita
 * Date: 31/07/14
 * Time: 15:27
 */

require_once('mobiledetect/Mobile_Detect.php');

class VersionManager extends CApplicationComponent
{
    const VERSION_MOBILE = 0;
    const VERSION_TABLET = 1;
    const VERSION_DESKTOP = 2;

    private $_version;

    public function getVersion()
    {
        if ($this->_version === null) {
            $detect = new Mobile_Detect();
            if ($detect->isMobile()) {
                if ($detect->isTablet()) {
                    $this->_version = self::VERSION_TABLET;
                } else {
                    $this->_version = self::VERSION_MOBILE;
                }
            } else {
                $this->_version = self::VERSION_DESKTOP;
            }
        }
        return $this->_version;
    }
} 