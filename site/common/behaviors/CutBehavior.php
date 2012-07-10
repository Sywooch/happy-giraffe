<?php

class CutBehavior extends CActiveRecordBehavior
{
    public $attributes = array();
    public $edit_routes = array();
    public $visible_html = '<hr class="cuttable" />';
    public $hidden_html = '<!--more-->';

    public function beforeSave($event)
    {
        parent::beforeSave($event);

        foreach ($this->attributes as $a) {
            $this->owner->$a = str_replace($this->visible_html, $this->hidden_html, $this->owner->$a);
            $p = new CHtmlPurifier();
            $p->options = array(
                'URI.AllowedSchemes' => array(
                    'http' => true,
                    'https' => true,
                ),
                'Attr.AllowedFrameTargets' => array('_blank' => true),
                'Attr.AllowedRel' => array('nofollow'),
                'HTML.AllowedComments' => array('more' => true),
            );
            $text = $p->purify($this->owner->$a);
            $text = $this->wrapNoindex($text);
            $pos = strpos($text, '<!--more-->');
            $preview = $pos === false ? $text : substr($text, 0, $pos);
            $preview = $p->purify($preview);
            $preview = $this->wrapNoindex($preview);
            $this->owner->content->preview = $preview;
            $this->owner->content->save(false);
            $this->owner->$a = $text;
        }
    }

    public function afterFind($event)
    {
        parent::afterFind($event);

        if (isset(Yii::app()->controller->route) && in_array(Yii::app()->controller->route, $this->edit_routes)) {
            foreach ($this->attributes as $a) {
                $this->owner->$a = str_replace($this->hidden_html, $this->visible_html, $this->owner->$a);
            }
        }
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