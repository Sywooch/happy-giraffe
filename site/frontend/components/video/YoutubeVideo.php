<?php
/**
 * Created by JetBrains PhpStorm.
 * User: mikita
 * Date: 8/14/13
 * Time: 2:02 PM
 * To change this template use File | Settings | File Templates.
 */

class YoutubeVideo extends BasicVideo
{
    public function getId()
    {
        parse_str(parse_url($this->url, PHP_URL_QUERY), $params);
        return $params['v'];
    }

    public function getThumbnail()
    {
        $maxres = 'http://i1.ytimg.com/vi/' . $this->getId() . '/maxresdefault.jpg';
        $ch = curl_init($maxres);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        return $httpCode == 200 ? $maxres : $this->oembed->data['thumbnail_url'];
    }
}