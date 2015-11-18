<?php
namespace site\frontend\modules\som\modules\qa;
/**
 * @author Никита
 * @date 09/11/15
 */

class QaModule extends \CWebModule
{
    public $periods = array(
        'day' => array(
            'label' => 'За 24 часа',
            'duration' => 86400,
        ),
        'week' => array(
            'label' => 'За неделю',
            'duration' => 604800,
        ),
        'all' => array(
            'label' => 'За все время',
            'duration' => 0,
        ),
    );

    public $controllerNamespace = 'site\frontend\modules\som\modules\qa\controllers';
}