<?php
/**
 * Created by PhpStorm.
 * User: mikita
 * Date: 15/08/14
 * Time: 15:34
 */

namespace site\frontend\modules\archive\components;

\Yii::import('zii.widgets.CMenu');

class Menu extends \CMenu
{
    public $htmlOptions = array('class' => 'b-calendar_ul');
    public $itemCssClass = 'b-calendar_li';
} 