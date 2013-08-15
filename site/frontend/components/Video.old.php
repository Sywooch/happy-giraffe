<?php

class Video extends CComponent
{

	public $url;
	public $title;
	public $description;
	public $code;
	public $preview;
    public $image;
	
	private $player = NULL;
	private $accepted_players = array(
		'rutube' => 'rutube.ru',
		'youtube' => 'youtube.com',
	);
	
	
	public function __construct($url)
	{
		$this->url = $url;
		$this->player = $this->identifyPlayer();
		$this->getData();
		
	}
	
	public function getData()
	{
		if (!is_null($this->player))
		{
			$method = $this->player . 'Data';
			$this->$method();
		}
	}
	
	protected function identifyPlayer()
	{
		preg_match('/(?:https?:\/\/)?(?:www\.)?([^\/]+)/', $this->url, $matches);
		if (($k = array_search($matches[1], $this->accepted_players)) !== FALSE)
		{
			return $k;
		}
		else
		{
			return NULL;
		}
	}

	protected function rutubeData()
	{
		$dom = new DOMDocument;
		@$dom->loadHTMLFile($this->url);
		$xpath = new DOMXpath($dom);
		$this->code = @$xpath->query('//*[@id="block-blog-code"]/textarea')->item(0)->nodeValue;
		$this->title = @$xpath->query('//meta[@property="og:title"]')->item(0)->getAttribute('content');
		$this->description = @$xpath->query('//meta[@property="og:description"]')->item(0)->getAttribute('content');
		$this->image = $this->preview = @$xpath->query('//meta[@property="og:image"]')->item(0)->getAttribute('content');
	}
	
	protected function youtubeData()
	{
		$query = $this->parseQuery();
        if (!isset($query['v']))
            return false;
		$v = $query['v'];
		
		$dom = new DOMDocument;
		@$dom->loadHTMLFile($this->url);
		$xpath = new DOMXpath($dom);
		$this->code = "<iframe width=\"580\" height=\"320\" src=\"http://www.youtube.com/embed/$v\" frameborder=\"0\" allowfullscreen></iframe>";
		$this->title = @$xpath->query('//span[@id="eow-title"]')->item(0)->nodeValue;
		$this->description = @$xpath->query('//p[@id="eow-description"]')->item(0)->nodeValue;
		$this->preview = "http://i.ytimg.com/vi/$v/default.jpg";
        $this->image = "http://i.ytimg.com/vi/$v/hqdefault.jpg";
	}

	protected function parseQuery()
	{
		$var  = parse_url($this->url, PHP_URL_QUERY);
		$var  = html_entity_decode($var);
		$var  = explode('&', $var);
		$arr  = array();

		foreach($var as $val)
		{
			$x          = explode('=', $val);
            if (count($x) > 1)
			    $arr[$x[0]] = $x[1];
		}
		unset($val, $x, $var);
		return $arr;
	}
	
	public function getAttributes()
	{
		$fields = array('title','description','code','preview');
		$attributes = array();
		
		foreach($fields as $field)
		{
			$attributes[$field] = $this->$field;
		}
		
		return $attributes;
	}

}