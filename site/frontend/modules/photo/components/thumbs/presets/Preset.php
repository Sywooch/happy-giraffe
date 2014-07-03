<?php
/**
 * Абстрактный пресет
 */

namespace site\frontend\modules\photo\components\thumbs\presets;


abstract class Preset extends \CComponent
{
    /**
     * @var string псевдоним пресета
     */
    public $name;
} 