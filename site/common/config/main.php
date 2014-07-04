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
                'uploadPreview' => array(
                    'lepilla',
                    'width' => 155,
                    'height' => 140,
                ),
                'uploadPreviewBig' => array(
                    'lepilla',
                    'width' => 325,
                    'height' => 295,
                ),
                'uploadAlbumCover' => array(
                    'lepilla',
                    'width' => 205,
                    'height' => 140,
                ),
            ),
            'quality' => array(
                72 => 100,
                100 => 90,
                200 => 85,
                350 => 80,
                75,
            ),
        ),
        'imagine' => array(
            'class' => '\site\common\components\ImagineComponent',
        ),
    ),
);