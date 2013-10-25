<?php
/**
 * Created by JetBrains PhpStorm.
 * User: mikita
 * Date: 8/14/13
 * Time: 2:39 PM
 * To change this template use File | Settings | File Templates.
 */

class BasicVideo extends CComponent
{
    public $url;
    public $oembed;
    public $oembedProvider;

    protected $oembedParams = array('maxwidth' => 580);

    public function __construct($url)
    {
        $this->url = $url;
        $this->oembed = new OEmbed($url, $this->oembedParams, $this->oembedProvider);
    }

    public function getEmbed()
    {
        return $this->oembed->html;
    }

    public function getThumbnail()
    {
        return $this->oembed->thumbnail_url;
    }

    public function __get($name)
    {
        return isset($this->oembed->data[$name]) ? $this->oembed->data[$name] : parent::__get($name);
    }
}