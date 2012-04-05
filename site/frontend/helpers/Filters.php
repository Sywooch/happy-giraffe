<?php

require_once(Yii::getPathOfAlias('site.frontend') . '/vendor/simplehtmldom_1_5/simple_html_dom.php');

class Filters
{
	public static function add_nofollow($value)
	{
		$html = str_get_html($value);

		$links = $html->find('a');
		foreach ($links as $link)
		{
			if (! isset($link->rel) AND strpos($link->href, 'happy-giraffe.ru') === false)
			{
				$link->rel = 'nofollow';
			}
			elseif ($link->rel == 'nofollow')
			{
				$link->rel = null;
			}
		}

		return $html;
	}
}