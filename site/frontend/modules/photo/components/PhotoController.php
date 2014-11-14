<?php
/**
 * Базовый контроллер модуля.
 *
 * @author Никита
 * @date 03/10/14
 */

namespace site\frontend\modules\photo\components;

class PhotoController extends \PersonalAreaController
{
    public $litePackage = 'photo';

    public function init()
    {
        $this->bodyClass .= ' body__cont-wide';
        parent::init();
    }
} 