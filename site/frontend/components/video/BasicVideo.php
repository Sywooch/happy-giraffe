<?php
/**
 * Created by JetBrains PhpStorm.
 * User: mikita
 * Date: 8/14/13
 * Time: 2:39 PM
 * To change this template use File | Settings | File Templates.
 */

Yii::import('site.frontend.extensions.phpQuery.phpQuery');

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

    public function getEmbed($width = 580)
    {
        return $this->addTransparent($this->_getEmbed($width));
    }

    protected function _getEmbed($width)
    {
        if ($width === 580)
            return $this->oembed->html;

        $oembed = new OEmbed($this->url, array('maxwidth' => $width), $this->oembedProvider);
        return $oembed->html;
    }

    public function getThumbnail()
    {
        return $this->oembed->thumbnail_url;
    }

    public function __get($name)
    {
        return isset($this->oembed->data[$name]) ? $this->oembed->data[$name] : parent::__get($name);
    }

    protected function addTransparent($html)
    {
        $doc = phpQuery::newDocumentHTML($html);
        $iframe = $doc->find('iframe');
        $src = $iframe->attr('src');
        $newSrc = $src . (strpos($src, '?') === false ? '?' : '&') . 'wmode=transparent';
        $iframe->attr('src', $newSrc);
        return $doc->html();
    }
}