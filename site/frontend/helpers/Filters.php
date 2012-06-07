<?php

Yii::import('ext.phpQuery.phpQuery');

class Filters
{
	public static function add_nofollow($value)
	{
        $doc = phpQuery::newDocumentXHTML($value, $charset = 'utf-8');

		foreach (pq('a') as $link) {
            if (strpos(pq($link)->attr('href'), $_SERVER["HTTP_HOST"])) {
                if ($link->hasAttribute('target'))
                    pq($link)->removeAttr('target');
            } else {
                if (pq($link)->attr('rel') != 'nofollow')
                    pq($link)->attr('rel', 'nofollow');
                if (pq($link)->attr('target') != '_blank') {
                    pq($link)->attr('target', '_blank');
                }
            }
        }

		return $doc;
	}
}