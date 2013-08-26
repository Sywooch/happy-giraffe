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
    public static $providerToClass = array(
        OEmbed::YOUTUBE_PROVIDER => 'YoutubeVideo',
        OEmbed::VIMEO_PROVIDER => 'VimeoVideo',
        OEmbed::RUTUBE_PROVIDER => 'RutubeVideo',
    );

    public static function factory($url)
    {
        $provider = OEmbed::getProvider($url);

        if ($provider === false)
            throw new CException('Provider is not recognized');

        $className = self::$providerToClass[$provider];
        $object = new $className($url);
        $object->oembedProvider = $provider;
        return $object;
    }
}