<?php

return array(
    'class' => 'site\frontend\modules\ads\AdsModule',
    'lines' => array(
        'bigPost' => 231258382,
        'smallPost' => 231258622,
        'photoPost' => 231258862,
    ),
    'templates' => array(
        'bigPost' => array(
            'size' => array(
                'width' => 615,
                'height' => 450,
            ),
        ),
        'smallPost' => array(
            'size' => array(
                'width' => 300,
                'height' => 315,
            ),
        ),
        'photoPost' => array(
            'size' => array(
                'width' => 300,
                'height' => 450,
            ),
        ),
    ),
    'components' => array(
        'dfp' => array(
            'class' => 'site\frontend\modules\ads\components\DfpHelper',
            'advertiserId' => 119452822,
        ),
        'manager' => array(
            'class' => 'site\frontend\modules\ads\components\AdsManager'
        ),
    ),
);