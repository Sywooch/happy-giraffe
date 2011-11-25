<?php

/**
 * Description of inLikeWidget
 *
 * @author Slava Rudnev <slava.rudnev@gmail.com>
 *
 * <script src="http://platform.linkedin.com/in.js" type="text/javascript"></script>
<script type="IN/Share" data-counter="right"></script>
 * top
 */
class inLikeWidget extends CWidget
{
	/**
	 * Place where counter to be showed
	 * @var string right/top/empty
	 */
	public $data_counter = 'right';

	public function run()
	{
		echo '<script type="IN/Share" data-counter="'.$this->data_counter.'"></script>';

		Y::script()->registerScriptFile('http://platform.linkedin.com/in.js');
	}

	/**
	 * Rate counter
	 * @param string $url
	 */
	public static function getRate($url)
	{
		if (!($request = file_get_contents('http://www.linkedin.com/cws/share-count?url='.$url)))
            return false;
        $tmp = array();
        if (!(preg_match('/^IN.Tags.Share.handleCount\({"count":(\d+),"url":"(.*?)"}\);$/i',$request,$tmp)))
            return false;
        return $tmp[1];
	}

}