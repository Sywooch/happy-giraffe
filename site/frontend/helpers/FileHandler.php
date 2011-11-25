<?php

class FileHandler
{

	public static function run($src, $dst, $params)
	{		
		$image = Image::factory($src);
		
		foreach ($params as $p => $v)
		{
			if (method_exists($image, $p))
			{
				call_user_func_array(array($image, $p), $v);
			}
		}
		
		$image->save($dst, FALSE);
	}

}