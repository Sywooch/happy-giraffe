<?php
/**
 * Created by JetBrains PhpStorm.
 * User: mikita
 * Date: 8/14/13
 * Time: 2:02 PM
 * To change this template use File | Settings | File Templates.
 */

class VimeoVideo extends BasicVideo
{
    public function getThumbnail()
    {
        $oembed = new OEmbed($this->url);
        return $oembed->thumbnail_url;
    }
}