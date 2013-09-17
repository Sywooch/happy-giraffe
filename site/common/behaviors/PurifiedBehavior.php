<?php
/**
 * Author: choo
 * Date: 09.06.2012
 */
class PurifiedBehavior extends CActiveRecordBehavior
{
    public $attributes = array();
    public $options = array();
    public $show_video = true;

    private $_defaultOptions = array(
        'URI.AllowedSchemes' => array(
            'http' => true,
            'https' => true,
        ),
        'Attr.AllowedFrameTargets' => array('_blank' => true),
        'Attr.AllowedRel' => array('nofollow'),
        'HTML.AllowedCommentsRegexp' => '/widget/',
        'HTML.SafeIframe' => true,
        'URI.SafeIframeRegexp' => '%.*%',
        'HTML.SafeObject' => true,
    );

    public function __get($name)
    {
        if (in_array($name, $this->attributes)) {
            $cacheId = $this->getCacheId($name);
            $value = Yii::app()->cache->get($cacheId);
            if ($value === false) {
                $purifier = new CHtmlPurifier;
                $purifier->options = CMap::mergeArray($this->_defaultOptions, $this->options);
                $value = $this->getOwner()->$name;
                if ($this->show_video) {
                    $value = $this->linkifyYouTubeURLs($value);
                    $value = $this->linkifyVimeo($value);
                }
                $value = $purifier->purify($value);
                $value = $this->setWidgets($value);
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
        include_once Yii::getPathOfAlias('site.frontend.vendor.simplehtmldom_1_5') . DIRECTORY_SEPARATOR . 'simple_html_dom.php';

        $doc = str_get_html($text);
        if ($doc == false)
            return $text;

        $links = $doc->find('a');

        foreach ($links as $link) {
            $url = $link->href;
            if (strpos($url, '/user/') === 0 || empty($url) || strpos($url, '/site/out/?') === 0)
                continue;

            $parsed_url = parse_url($url);

            if (!isset($parsed_url['host'])) {
                $link->outertext = '';
            } elseif (strpos($parsed_url['host'], $_SERVER["HTTP_HOST"]) === false) {
                //внешние ссылки ставим в nofollow, _black, меняет url на /site/out/?url=
                $link->rel = 'nofollow';
                $link->target = '_blank';
                $link->href = '/site/out/?url=' . $link->href;
            } else {
                //внутренние ссылки обрабатываем дополнительно
                $link->target = '';
                //убираем из конца ссылки лишние символы
                $url = $link->href;
                $url = str_replace('%C2%A0', '', $url);
                for ($i = 0; $i < 10; $i++) {
                    $url = trim($url, "., /");
                }
                $url = $url . '/';
                $link->href = $url;
            }
        }

        return $doc->save();
    }

    public function fetchHtml($matches)
    {
        $url = 'http://www.youtube.com/oembed?url=' . $matches[0] . '&format=json&maxwidth=580';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        $httpStatus = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        $json = CJSON::decode($response);
        return ($httpStatus == 200) ? $this->wrapVideo($json['html']) : $matches[0];
    }

    public function vimeo($matches)
    {
        $url = 'http://vimeo.com/api/oembed.xml?url=' . $matches[0] . '&format=json&maxwidth=580';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        $httpStatus = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        $json = CJSON::decode($response);
        return ($httpStatus == 200) ? $this->wrapVideo($json['html']) : $matches[0];
    }

    public function linkifyYouTubeURLs($text)
    {
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

    public function linkifyVimeo($text)
    {
        $text = preg_replace_callback('~https?://vimeo\.com/\d+~ix', array($this, 'vimeo'), $text);
        return $text;
    }

    private function wrapVideo($text)
    {
        return '<div class="b-article_in-img">' . $text . '</div>';
    }

    private function endsWith($haystack, $needle)
    {
        $length = strlen($needle);
        if ($length == 0) {
            return true;
        }

        return (substr($haystack, -$length) === $needle);
    }

    private function setWidgets($text)
    {
        return preg_replace_callback('#<!-- widget: (.*) -->(.*)<!-- /widget -->#sU', array($this, 'replaceWidgets'), $text);
    }

    private function replaceWidgets($matches)
    {
        $data = CJSON::decode($matches[1]);
        extract($data);
        if (isset($entity) && isset($entity_id)) {
            $model = CActiveRecord::model($entity)->findByPk($entity_id);
            if ($model) {
                return $model->getWidget(false, $this->getOwner());
            }
        }
        return '';
    }
}
