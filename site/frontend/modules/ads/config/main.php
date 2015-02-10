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
    'components' => array(
        'dfp' => array(
            'class' => 'site\frontend\modules\ads\components\DfpHelper',
            'advertiserId' => 119452822,
            'version' => 'v201411',
        ),
        'manager' => array(
            'class' => 'site\frontend\modules\ads\components\AdsManager'
        ),
        'creativesFactory' => array(
            'class' => 'site\frontend\modules\ads\components\creatives\creativesFactory',
            'presets' => array(
                'bigPost' => array(
                    'class' => 'site\frontend\modules\ads\components\creatives\PostCreative',
                    'type' => 'big',
                ),
                'smallPost' => array(
                    'class' => 'site\frontend\modules\ads\components\creatives\PostCreative',
                    'type' => 'small',
                ),
            ),
        ),
    ),
);