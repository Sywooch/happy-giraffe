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
        'analytics' => array(
            'class' => 'site\frontend\modules\analytics\AnalyticsModule',
            'components' => array(
                'piwik' => array(
                    'class' => 'site\frontend\modules\analytics\components\PiwikHttpApi',
                ),
                'visitsManager' => array(
                    'class' => 'site\frontend\modules\analytics\components\VisitsManager',
                ),
            ),
        ),
        'ads' => require(dirname(__FILE__) . '/../../frontend/modules/ads/config/main.php'),
        'som' => array(
            'class' => 'site\frontend\modules\som\SomModule',
        ),
        'api' => array(
            'class' => 'site\frontend\modules\api\ApiModule',
        ),
        'geo2' => [
            'class' => 'site\frontend\modules\geo2\Geo2Module',
        ],
    ),
    'components' => array(
        'dbBackup' => array(
            'class'=>'CDbConnection',
            'connectionString' => 'mysql:host=88.198.46.134;dbname=happy_giraffe',
            'emulatePrepare' => true,
            'username' => 'happy_giraffe',
            'password' => 'BbnfLTq1t2Xh',
            'charset' => 'utf8',
            'enableProfiling' => true,
            'enableParamLogging' => true,
        ),
        /* компонент для кеширования по зависимости, без удаления записей */
        'dbCache' => array(
            'class' => 'site.frontend.components.InfinityCache',
            'connectionID' => 'db',
            // сборщик мусора не нужен, храним по зависимости, вечно
            'gCProbability' => 0,
            'cacheTableName' => 'infiniteCache',
        ),
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
        'NStream' => array (
            'class' => 'site\frontend\modules\api\modules\v1_3\components\nstream\NginxStream',
            'host' => 'stream.happy-giraffe.ru',
            'port' => '80',
        ),
        'serviceStatus' => [
            'class' => '\site\common\components\ServiceStatusManager',
            'statuses' => [
                'commentatorsContest' => false,
            ],
        ],
    ),
);