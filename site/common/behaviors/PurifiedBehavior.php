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
    );

    public function __get($name)
    {
        if (in_array($name, $this->attributes)) {
            $cacheId = $this->getCacheId($name);
            $value = Yii::app()->cache->get($cacheId);
            if ($value === false) {
                $purifier = new CHtmlPurifier;
                $purifier->options = CMap::mergeArray($this->_defaultOptions, $this->options);
                $value = $purifier->purify($this->getOwner()->$name);
                $value = $this->wrapNoindex($value);
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

    private function wrapNoindex($text)
    {

        Yii::import('site.frontend.extensions.phpQuery.phpQuery');

        $doc = phpQuery::newDocumentXHTML($text, $charset = 'utf-8');
        $links = $doc->find('a');

        foreach ($links as $link) {
            $url = pq($link)->attr('href');
            $parsed_url = parse_url($url);

            if (isset($parsed_url['host']) and strpos($parsed_url['host'], 'happy-giraffe') === false) {

                if (!pq($link)->parent()->is('noindex'))
                    pq($link)->wrap('<noindex></noindex>');
            }
        }

        $text = $doc->html();
        $doc->unloadDocument();

        return $text;
    }
}
