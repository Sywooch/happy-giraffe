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
                $value = $this->getOwner()->$name;
                if (! empty($value)) {
                    $purifier = new CHtmlPurifier;
                    $purifier->options = CMap::mergeArray($this->_defaultOptions, $this->options);
                    if ($this->show_video)
                        $value = $this->linkifyVideos($value);
                    $value = $purifier->purify($value);
                    $value = $this->setWidgets($value);
                    $value = $this->fixUrls($value);
                    $value = $this->fixh1($value);
                    $value = $this->clean($value);
                    Yii::app()->cache->set($cacheId, $value);
                }
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

    private function fixh1($text)
    {
        include_once Yii::getPathOfAlias('site.frontend.vendor.simplehtmldom_1_5') . DIRECTORY_SEPARATOR . 'simple_html_dom.php';

        $doc = str_get_html($text);
        if ($doc == false)
            return $text;

        $h1 = $doc->find('h1');
        foreach ($h1 as $header) {
            $header->outertext = '<h2>' . $header->innertext . '</h2>';
        }
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
                $link->href = strpos($parsed_url['host'], 'adriver') === false ? '/site/out/?url=' . $link->href : $link->href;
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

    protected function linkifyVideos($text)
    {
        include_once Yii::getPathOfAlias('site.frontend.vendor.simplehtmldom_1_5') . DIRECTORY_SEPARATOR . 'simple_html_dom.php';

        // process links
        $html = str_get_html($text);
        foreach ($html->find('a') as $link) {
            $href = $link->href;
            try {
                $v = Video::factory($href);
                $link->outertext = '<div class="b-article_in-img">' . $v->embed . '</div>';
            } catch (CException $e) {}
        }

        foreach ($html->find('iframe') as $iframe) {
            $parent = $iframe->parent();
            if ($parent->tag != 'div' || $parent->class != 'b-article_in-img')
                $iframe->outertext = '<div class="b-article_in-img">'. $iframe->outertext . '</div>';
        }

        // process text
        return preg_replace_callback('/((([A-Za-z]{3,9}:(?:\/\/)?)(?:[-;:&=\+\$,\w]+@)?[A-Za-z0-9.-]+|(?:www.|[-;:&=\+\$,\w]+@)[A-Za-z0-9.-]+)((?:\/[\+~%\/.\w-_]*)?\??(?:[-\+=&;%@.\w_]*)#?(?:[\w]*))?)/', function($matches) {
            try {
                $v = Video::factory($matches[0]);
                return '<div class="b-article_in-img">' . $v->embed . '</div>';
            } catch (CException $e) {
                return $matches[0];
            }
        }, $html);
    }

    protected function clean($text)
    {
        include_once Yii::getPathOfAlias('site.frontend.vendor.simplehtmldom_1_5') . DIRECTORY_SEPARATOR . 'simple_html_dom.php';

        $html = str_get_html($text);

        if ($html === false)
            return $text;

        foreach ($html->find('p') as $p) {
            $v = str_replace('​', '', $p->innertext);
            if (empty($v))
                $p->outertext = '';
        }

        return (string) $html;
    }
}
