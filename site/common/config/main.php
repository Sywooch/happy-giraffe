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
            'presets' => array(
                'uploadPreview' => array(
                    'filter' => 'lepilla',
                    'width' => 155,
                    'height' => 140,
                ),
                'uploadPreviewBig' => array(
                    'filter' => 'lepilla',
                    'width' => 325,
                    'height' => 295,
                ),
                'uploadAlbumCover' => array(
                    'filter' => 'lepilla',
                    'width' => 205,
                    'height' => 140,
                ),
                'rowGrid' => array(
                    'filter' => 'relativeResize',
                    'method' => 'heighten',
                    'parameter' => 200,
                ),
                'myPhotosAlbumCover' => array(
                    'filter' => 'lepilla',
                    'width' => 880,
                    'height' => 580,
                ),
                'myPhotosPreview' => array(
                    'filter' => 'relativeResize',
                    'method' => 'heighten',
                    'parameter' => 70,
                ),
                'postPreviewSmall' => array(
                    'filter' => 'lepilla',
                    'width' => 205,
                    'height' => 140,
                ),
            ),
        ),
        'crops' => array(
            'class' => '\site\frontend\modules\photo\components\thumbs\CroppedThumbsManager',
            'presets' => array(
                'avatarSmall' => array(
                    'width' => 24,
                    'height' => 24,
                ),
                'avatar' => array(
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
    ),
);