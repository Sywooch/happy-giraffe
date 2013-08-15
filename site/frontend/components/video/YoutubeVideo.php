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
        return 'http://i1.ytimg.com/vi/' . $this->getId() . '/maxresdefault.jpg';
    }
}