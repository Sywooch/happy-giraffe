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
    'components' => array(
        'fs' => array(
            'class' => '\site\common\components\gaufrette\PhotoS3Component',
            'key' => 'AKIAIRCLO4AYJCJRTV4Q',
            'secret' => '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',
            'bucket' => 'test-happygiraffe',
            'cachePathAlias' => 'site.common.uploads.photos.v2',
        ),
        'thumbs' => array(
            'class' => '\site\frontend\modules\photo\components\thumbs\ThumbsManager',
            'presets' => array(
                'uploadMin' => array(
                    'lepilla',
                    'width' => 155,
                    'height' => 140
                ),
                'uploadMid' => array(
                    'lepilla',
                    'width' => 310,
                    'height' => 280
                ),
                'uploadMax' => array(
                    'lepilla',
                    'width' => 620,
                    'height' => 560,
                ),
            ),
        ),
    ),
);