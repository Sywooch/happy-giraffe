<?php

class Video extends CComponent
{

	public $url;
	public $title;
	public $description;
	public $code;
	public $preview;
	
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
		$this->code = $xpath->query('//input[@id="pcode"]')->item(0)->getAttribute('value');
		$this->title = $xpath->query('//h1')->item(0)->nodeValue;
		$this->description = $xpath->query('//div[@class="descr"]')->item(0)->nodeValue;
		$this->preview = $xpath->query('//meta[@property="og:image"]')->item(0)->getAttribute('content');
	}
	
	protected function youtubeData()
	{
		$query = $this->parseQuery();
		$v = $query['v'];
		
		$dom = new DOMDocument;
		@$dom->loadHTMLFile($this->url);
		$xpath = new DOMXpath($dom);
		$this->code = "<iframe width=\"560\" height=\"315\" src=\"http://www.youtube.com/embed/$v\" frameborder=\"0\" allowfullscreen></iframe>";
		$this->title = @$xpath->query('//span[@id="eow-title"]')->item(0)->nodeValue;
		$this->description = @$xpath->query('//p[@id="eow-description"]')->item(0)->nodeValue;
		$this->preview = "http://i1.ytimg.com/vi/$v/default.jpg";
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