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

    /**
     * Пеобразует строку с unicode символами в UTF-8
     *
     * @param   $value
     * @return  string
     * @author Sergey Gubarev
     */
	public static function unicodeToString($value)
    {
        $str = '';

        for ($i = 0; $i < mb_strlen($value, 'UTF-8'); $i++)
        {
            $char = mb_substr($value, $i, 1, 'UTF-8');

            if (preg_match('/^[а-яА-Яa-zA-Z0-9-_\\s]+/', $char))
            {
                $str .= $char;
            }
            else
            {
                $str .= trim(json_encode($char), '"');
            }
        }

        return $str;
    }

    /**
     * Преобразует строку с unicode кодами в строку с символами
     *
     * @param   string $value Значение
     * @return  string
     * @author Sergey Gubarev
     */
    public static function decodeUnicodeToString($value)
    {
        if (preg_match('/[^\w$\x{0080}-\x{FFFF}]+/u', $value))
        {
            return json_decode('"' . $value . '"');
        }

        return $value;
    }
}