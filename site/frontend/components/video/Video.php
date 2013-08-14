<?php
/**
 * Created by JetBrains PhpStorm.
 * User: mikita
 * Date: 8/14/13
 * Time: 1:54 PM
 * To change this template use File | Settings | File Templates.
 */

class Video extends CComponent
{
    const YOUTUBE_PROVIDER = 0;
    const VIMEO_PROVIDER = 1;
    const RUTUBE_PROVIDER = 2;

    public static $providers = array(
        self::YOUTUBE_PROVIDER => array(
            'regex' => '|https?://(www\.)?youtube.com/watch.*|i',
            'endpoint' => 'http://www.youtube.com/oembed',
            'class' => 'YoutubeVideo',
        ),
        self::VIMEO_PROVIDER => array(
            'regex' => '|https?://(www\.)?vimeo.com/.*|i',
            'endpoint' => 'http://vimeo.com/api/oembed.json',
            'class' => 'VimeoVideo',
        ),
        self::RUTUBE_PROVIDER => array(
            'regex' => '|https?://(www\.)?rutube.ru/.*|i',
            'endpoint' => 'http://rutube.ru/api/oembed/',
            'class' => 'RutubeVideo',
        ),
    );

    public static function getProvider($url)
    {
        foreach (self::$providers as $provider => $providerData) {
            if (preg_match($providerData['regex'], $url))
                return $provider;
        }
        return false;
    }

    public static function factory($url)
    {
        $class = self::$providers[self::getProvider($url)]['class'];
        return new $class($url);
    }
}