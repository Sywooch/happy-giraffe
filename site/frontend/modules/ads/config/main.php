<?php

return array(
    'class' => 'site\frontend\modules\ads\AdsModule',
    'lines' => array(
        'bigPost' => array(
            'lineId' => 231258382,
            'size' => array(
                'width' => 615,
                'height' => 450,
            ),
        ),
        'smallPost' => array(
            'lineId' => 231258622,
            'size' => array(
                'width' => 300,
                'height' => 315,
            ),
        ),
        'photoPost' => array(
            'lineId' => 231258862,
            'size' => array(
                'width' => 300,
                'height' => 450,
            ),
        ),
    ),
    'templates' => array(
        'bigPost' => array(
            'render' => 'site\frontend\modules\ads\components\renderers\BaseRenderer',

        ),
        'smallPost' => array(
            'render' => 'site\frontend\modules\ads\components\renderers\BaseRenderer',

        ),
        'photoPost' => array(
            'render' => 'site\frontend\modules\ads\components\renderers\BaseRenderer',

        ),
    ),
    'components' => array(
        'dfp' => array(
            'class' => 'site\frontend\modules\ads\components\DfpHelper',
            'advertiserId' => 119452822,
            'version' => 'v201411',
        ),
        'manager' => array(
            'class' => 'site\frontend\modules\ads\components\AdsManager'
        ),
    ),
);