<?php

return array(
    'aliases' => array(
        'League' => 'site.common.vendor.League',
        'Guzzle' => 'site.common.vendor.Guzzle',
        'Aws' => 'site.common.vendor.Aws',
        'Symfony' => 'site.common.vendor.Symfony',
        'Imagine' => 'site.common.vendor.Imagine',
        'Gaufrette' => 'site.common.vendor.Gaufrette',
    ),
    'modules' => array(
        'photo' => require(dirname(__FILE__) . '/../../frontend/modules/photo/config/main.php'),
    ),
    'components' => array(
        'api' => array(
            'class' => 'site\frontend\components\api\ApiComponent',
        ),
        'apc' => array(
            'class' => 'CApcCache',
        ),
        'gearman' => array(
            'class' => 'site.common.components.Gearman',
        ),
        'fsFly' => array(
            'class' => '\site\common\components\flysystem\PhotoS3Component',
            'key' => 'AKIAIRCLO4AYJCJRTV4Q',
            'secret' => '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',
            'bucket' => 'test-happygiraffe',
            'cachePathAlias' => 'site.common.uploads.photos.v2',
        ),
        'fs' => array(
            'class' => '\site\common\components\gaufrette\PhotoS3Component',
            'key' => 'AKIAIRCLO4AYJCJRTV4Q',
            'secret' => '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',
            'bucket' => 'test-happygiraffe',
        ),
        'imageProcessor' => array(
            'class' => '\site\frontend\modules\photo\components\imageProcessor\ImageProcessor',
            'quality' => array(
                72 => 100,
                100 => 90,
                200 => 85,
                350 => 80,
                75,
            ),
        ),
        'thumbs' => array(
            'class' => '\site\frontend\modules\photo\components\thumbs\SimpleThumbsManager',
            'presets' => require_once(dirname(__FILE__) . '/presets.php'),
        ),
        'crops' => array(
            'class' => '\site\frontend\modules\photo\components\thumbs\CroppedThumbsManager',
            'presets' => array(
                'avatarSmall' => array(
                    'width' => 24,
                    'height' => 24,
                ),
                'avatarMedium' => array(
                    'width' => 72,
                    'height' => 72,
                ),
                'avatarBig' => array(
                    'width' => 200,
                    'height' => 200,
                ),
            ),
        ),
        'imagine' => array(
            'class' => '\site\common\components\ImagineComponent',
        ),
        'analytics' => array(
            'class' => 'site\frontend\modules\analytics\AnalyticsModule',
        ),
    ),
);