<?php
/**
 * @author Никита
 * @date 21/07/16
 */

namespace site\frontend\modules\posts\components;


use site\frontend\modules\photo\components\thumbs\Thumb;
use site\frontend\modules\posts\models\Content;

class ArticleHelper
{
    public static function getJsonLd(Content $post)
    {
        $object = [
            '@context' => 'http://schema.org',
            '@type' => 'Article',
            'url' => $post->url,
            'datePublished' => date('c', $post->dtimePublication),
            'dateModified' => date('c', $post->dtimeUpdate),
            'headline' => $post->title,
            'mainEntityOfPage' => [
                '@type' => 'WebPage',
                'url' => $post->url,
            ],
            'author' => [
                '@type' => 'Person',
                'name' => $post->getUser()->fullName,
                'url' => $post->getUser()->profileUrl,
            ],
            'publisher' => [
                '@type' => 'Organization',
                'name' => 'Веселый Жираф',
                'logo' => [
                    '@type' => 'ImageObject',
                    'url' => 'http://www.happy-giraffe.ru/lite/images/base/logo.png',
                    'width' => 230,
                    'height' => 65,
                ],
            ],
        ];

        if ($photo = self::getPhoto($post)) {
            /** @var Thumb $thumb */
            $thumb = \Yii::app()->thumbs->getThumb($photo['photo'], 'postCollectionCover');
            $object['image'] = [
                '@type' => 'ImageObject',
                'url' => $thumb->getUrl(),
                'width' => $thumb->getWidth(),
                'height' => $thumb->getHeight(),
            ];
        }
        
        return \CJSON::encode($object);
    }

    protected static function getPhoto(Content $post)
    {
        $fields = ['preview', 'html'];

        foreach ($fields as $f) {
            $parser = new ReverseParser($post->{$f});
            if (count($parser->images) > 0) {
                return $parser->images[0];
            }
        }
        return null;
    }
}