<?php
/**
 * Author: choo
 * Date: 09.06.2012
 */
class PurifiedBehavior extends CActiveRecordBehavior
{
    public $attributes = array();
    public $options = array();

    private $_defaultOptions = array(
        'URI.AllowedSchemes' => array(
            'http' => true,
            'https' => true,
        ),
        'Attr.AllowedFrameTargets' => array('_blank' => true),
        'Attr.AllowedRel' => array('nofollow'),
        'HTML.SafeIframe' => true,
        'URI.SafeIframeRegexp' => '%^(http://www.youtube.com/embed/|http://player.vimeo.com/video/|https://w.soundcloud.com/)%',
        'HTML.SafeObject' => true,
    );

    public function __get($name)
    {
        if (in_array($name, $this->attributes)) {
            $cacheId = $this->getCacheId($name);
            $value = false;
            if ($value === false) {
                $purifier = new CHtmlPurifier;
                $purifier->options = CMap::mergeArray($this->_defaultOptions, $this->options);
                $value = $this->getOwner()->$name;
                $value = $this->linkifyYouTubeURLs($value);
                $value = $this->linkifyVimeo($value);
                $value = $purifier->purify($value);
                $value = $this->fixUrls($value);
                Yii::app()->cache->set($cacheId, $value);
            }
            return $value;
        } else {
            return null;
        }
    }

    public function getCacheId($attributeName)
    {
        return get_class($this->getOwner()) . '_' . $this->getOwner()->primaryKey . '_' . $attributeName;
    }

    public function clearCache()
    {
        foreach ($this->attributes as $a) {
            Yii::app()->cache->delete($this->getCacheId($a));
        }
    }

    public function attach($owner)
    {
        parent::attach($owner);

        $owner->attachEventHandler('onAfterSave', array($this, 'clearCache'));
    }

    public function detach($owner)
    {
        parent::detach($owner);

        $owner->detachEventHandler('onAfterSave', array($this, 'clearCache'));
    }

    private function fixUrls($text)
    {
        Yii::import('site.frontend.extensions.phpQuery.phpQuery');

        $doc = phpQuery::newDocumentXHTML($text, $charset = 'utf-8');
        $links = $doc->find('a');

        foreach ($links as $link) {
            $url = pq($link)->attr('href');
            $parsed_url = parse_url($url);

            if (!isset($parsed_url['host'])){
                pq($link)->remove();
            } elseif (strpos($parsed_url['host'], $_SERVER["HTTP_HOST"]) === false) {
                //внешние ссылки ставим в noindex
                if (!pq($link)->parent()->is('noindex'))
                    pq($link)->wrap('<noindex></noindex>');

                if (pq($link)->attr('rel') != 'nofollow')
                    pq($link)->attr('rel', 'nofollow');

                if (pq($link)->attr('target') != '_blank')
                    pq($link)->attr('target', '_blank');

            } else {
                //внутренние ссылки обрабатываем дополнительно
                pq($link)->removeAttr('target');

                //убираем из конца ссылки лишние символы
                $url = pq($link)->attr('href');
                $url = str_replace('%C2%A0', '', $url);
                for($i=0;$i<10;$i++){
                    $url = trim($url, "., /");
                }
                $url = $url.'/';

                pq($link)->attr('href', $url);
            }
        }

        $text = $doc->html();
        $doc->unloadDocument();

        return $text;
    }

    public function fetchHtml($matches)
    {
        $url = 'http://www.youtube.com/oembed?url=' . $matches[0] . '&format=json&maxwidth=700';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        $httpStatus = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        $json = CJSON::decode($response);
        return ($httpStatus == 200) ? $json['html'] : $matches[0];
    }

    public function vimeo($matches)
    {
        $url = 'http://vimeo.com/api/oembed.xml?url=' . $matches[0] . '&format=json&maxwidth=700';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        $httpStatus = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        $json = CJSON::decode($response);
        return ($httpStatus == 200) ? $json['html'] : $matches[0];
    }

    public function linkifyYouTubeURLs($text) {
        $text = preg_replace_callback('~
        # Match non-linked youtube URL in the wild. (Rev:20111012)
        https?://         # Required scheme. Either http or https.
        (?:[0-9A-Z-]+\.)? # Optional subdomain.
        (?:               # Group host alternatives.
          youtu\.be/      # Either youtu.be,
        | youtube\.com    # or youtube.com followed by
          \S*             # Allow anything up to VIDEO_ID,
          [^\w\-\s]       # but char before ID is non-ID char.
        )                 # End host alternatives.
        ([\w\-]{11})      # $1: VIDEO_ID is exactly 11 chars.
        (?=[^\w\-]|$)     # Assert next char is non-ID or EOS.
        (?!               # Assert URL is not pre-linked.
          [?=&+%\w]*      # Allow URL (query) remainder.
          (?:             # Group pre-linked alternatives.
            [\'"][^<>]*>  # Either inside a start tag,
          | </a>          # or inside <a> element text contents.
          )               # End recognized pre-linked alts.
        )                 # End negative lookahead assertion.
        [?=&+%\w-;]*        # Consume any URL (query) remainder.
        ~ix',
            array($this, 'fetchHtml'),
            $text);
        return $text;
    }

    public function linkifyVimeo($text) {
        $text = preg_replace_callback('~https?://vimeo\.com/\d+~ix',
            array($this, 'vimeo'),
            $text);
        return $text;
    }

    private function endsWith($haystack, $needle)
    {
        $length = strlen($needle);
        if ($length == 0) {
            return true;
        }

        return (substr($haystack, -$length) === $needle);
    }
}
