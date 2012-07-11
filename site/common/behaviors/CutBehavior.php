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
            $text = $this->owner->$a;
            $pos = strpos($text, '<!--more-->');
            $preview = $pos === false ? $text : substr($text, 0, $pos);
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