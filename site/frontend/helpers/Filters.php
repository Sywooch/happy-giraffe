<?php

class Filters
{
	public static function add_nofollow($value)
	{
		/*$dom = new DOMDocument('1.0', 'UTF-8');
		$dom->loadHTML($value);
		$dom->strictErrorChecking = false;

		$links = $dom->getElementsByTagName('a');
		foreach ($links as $link)
		{
			$href = $link->getAttribute('href');
			
			if (! $link->hasAttribute('rel') AND strpos($href, 'happy-giraffe.ru') === false)
			{
				$link->setAttribute('rel', 'nofollow');
			}
			elseif ($link->getAttribute('rel') == 'nofollow')
			{
				$link->removeAttribute('rel');
			}
		}

		return $dom->saveHTML();*/
		return $value;
	}
}