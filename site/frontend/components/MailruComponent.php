<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class MailruComponent extends CComponent
{

	public $api_id = '640514';
	public $protect_key = 'bad7ed6365450d725e31518e2d4db28a';

	public function getClubCount()
	{
		$filename = '../protected/runtime/count.txt';
		$count = 0;
		if(is_file($filename))
		{
			$s = file_get_contents($filename);
			$arr = explode(':', $s);
			if(time() - $arr[0] < 3600)
			{
				$count = $arr[1];
			}
		}
		if(!$count)
		{
			$file = file_get_contents('http://my.mail.ru/community/nepromokashka/');
			$i = strpos($file, 'ico_people');
			$i = strpos($file, '<span>', $i);
			$file = substr($file, $i + 6);
			$arr = explode('</span>', $file);
			$count = $arr[0];
			@unlink('../count.txt');
			$f = fopen($filename, 'a');
			fwrite($f, time() . ':' . $count);
		}
		return $count;
	}

	function getAuthorizedPage($url)
	{
		$login = 's.karnyushin';
		$pass = 'Chedalles1';
		$curl = curl_init();

		$ckfile = tempnam("/tmp", "CURLCOOKIE");
		curl_setopt($curl, CURLOPT_COOKIEJAR, $ckfile);

		$header[0] = "Accept: text/xml,application/xml,application/xhtml+xml,";
		$header[0] .= "text/html;q=0.9,text/plain;q=0.8,image/png,*/*;q=0.5";
		$header[] = "Cache-Control: max-age=0";
		$header[] = "Connection: keep-alive";
		$header[] = "Keep-Alive: 300";
		$header[] = "Accept-Charset: windows-1251,utf-8;q=0.7,*;q=0.7";
		$header[] = "Accept-Language: ru,en-us;q=0.7,en;q=0.3";
		$header[] = "Pragma: ";

		curl_setopt($curl, CURLOPT_URL, 'http://auth.mail.ru/cgi-bin/auth');
		curl_setopt($curl, CURLOPT_POST, 1);
		curl_setopt($curl, CURLOPT_POSTFIELDS, 'Login=' . $login . '&Password=' . $pass . '&Domain=mail.ru');
		curl_setopt($curl, CURLOPT_VERBOSE, true);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (X11; U; Linux i686; ru;
		rv:1.9.2.16) Gecko/20110323 Ubuntu/10.10 (maverick) Firefox/3.6.16');
		curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
		curl_setopt($curl, CURLOPT_REFERER, 'http://my.mail.ru/cgi-bin/login?noclear=1&page=' . urlencode($url));
		curl_setopt($curl, CURLOPT_ENCODING, 'gzip,deflate');
		curl_setopt($curl, CURLOPT_AUTOREFERER, true);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_TIMEOUT, 10);
		$html = curl_exec($curl);

		curl_setopt($curl, CURLOPT_POST, 0);

		curl_setopt($curl, CURLOPT_URL, $url);
		$html = curl_exec($curl); // execute the curl command

		return $html;
	}

	function parseUsers($login, $pass, $page=1)
	{
		$curl = curl_init();

		$ckfile = tempnam("/tmp", "CURLCOOKIE");
		curl_setopt($curl, CURLOPT_COOKIEJAR, $ckfile);

		$header[0] = "Accept: text/xml,application/xml,application/xhtml+xml,";
		$header[0] .= "text/html;q=0.9,text/plain;q=0.8,image/png,*/*;q=0.5";
		$header[] = "Cache-Control: max-age=0";
		$header[] = "Connection: keep-alive";
		$header[] = "Keep-Alive: 300";
		$header[] = "Accept-Charset: windows-1251,utf-8;q=0.7,*;q=0.7";
		$header[] = "Accept-Language: ru,en-us;q=0.7,en;q=0.3";
		$header[] = "Pragma: ";

		curl_setopt($curl, CURLOPT_URL, 'http://auth.mail.ru/cgi-bin/auth');
		curl_setopt($curl, CURLOPT_POST, 1);
		curl_setopt($curl, CURLOPT_POSTFIELDS, 'Login=' . $login . '&Password=' . $pass . '&Domain=mail.ru');
		curl_setopt($curl, CURLOPT_VERBOSE, true);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (X11; U; Linux i686; ru;
		rv:1.9.2.16) Gecko/20110323 Ubuntu/10.10 (maverick) Firefox/3.6.16');
		curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
		curl_setopt($curl, CURLOPT_REFERER, 'http://my.mail.ru/cgi-bin/login?noclear=1&page=http%3a%2f%2fmy.mail.ru%2fcommu
		nity%2fnepromokashka%2fcommunity-friends');
		curl_setopt($curl, CURLOPT_ENCODING, 'gzip,deflate');
		curl_setopt($curl, CURLOPT_AUTOREFERER, true);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_TIMEOUT, 10);
		if(!$html = curl_exec($curl))
		{
			return false;
		}
		$urls = array();
		//--------

		curl_setopt($curl, CURLOPT_POST, 0);

		curl_setopt($curl, CURLOPT_URL, 'http://my.mail.ru/community/nepromokashka/friends?&sort=&page=' . $page);
		if(!$html = curl_exec($curl))
		{
			return false;
		}
		preg_match_all('%<a href="(/((mail)|(list)|(inbox)|(bk))/[^/]+/)%', $html, $m);
		if(!empty($m[1]) && is_array($m[1]))
		{
			$urls = array_merge($urls, $m[1]);
		}

		curl_close($curl); // close the connection
		return $urls; // and finally, return $html
	}

	private function signServerServer(array $request_params, $secret_key)
	{
		ksort($request_params);
		$params = '';
		foreach($request_params as $key => $value)
		{
			$params .= "$key=$value";
		}
		return md5($params . $secret_key);
	}

	public function sendMailruRequest(array $request_params)
	{
		$request_params['app_id'] = $this->api_id;
		$sig = $this->signServerServer($request_params, $this->protect_key);
		$request_params['sig'] = $sig;
		$data = http_build_query($request_params);
		$packet = "GET /platform/api?" . $data . " HTTP/1.0\r\n";
		$packet.="Host: appsmail.ru\r\n";
		$packet.="Referer: http://nepromokashka.ru\r\n";
		$packet.="Content-Type: application/x-www-form-urlencoded\r\n\r\n";
		$ock = fsockopen(gethostbyname('www.appsmail.ru'), 80);
		fputs($ock, $packet);
		$ans = '';
		while(!feof($ock))
		{
			$ans .= fgets($ock);
		}
		fclose($ock);
		preg_match('/(\{.+\})/', $ans, $ans);
		$ans = $ans[1];
		$ans = json_decode($ans, true);
		return $ans;
	}

	public function parseJsonAns($ans)
	{
		preg_match('/(\{.+\})/', $ans, $ans);
		$ans = $ans[1];
		$ans = json_decode($ans, true);
		return $ans;
	}

	public function simpleGet($host, $uri = '')
	{
		$packet = "GET $uri HTTP/1.0\r\n";
		$packet.="Host: $host\r\n";
		$packet.="Referer: http://nepromokashka.ru\r\n";
		$packet.="Content-Type: application/x-www-form-urlencoded\r\n\r\n";
		$ock = fsockopen(gethostbyname($host), 80);
		fputs($ock, $packet);
		$ans = '';
		while(!feof($ock))
		{
			$ans .= fgets($ock);
		}
		fclose($ock);
		return $ans;
	}

	public function parseMailruRss($url)
	{
		$doc = new DOMDocument();
		$rssString = $this->getAuthorizedPage($url);
		@$doc->loadXML($rssString);
		$newPosts = array();
		foreach($doc->getElementsByTagName('item') as $node)
		{
			$itemRSS = array(
				'title' => $node->getElementsByTagName('title')->item(0)->nodeValue,
				'content' => $node->getElementsByTagName('description')->item(0)->nodeValue,
				'url' => $node->getElementsByTagName('link')->item(0)->nodeValue,
				'create_time' => strtotime($node->getElementsByTagName('pubDate')->item(0)->nodeValue),
				'author_id' => 0
			);
			$model = ClubPost::model()->find("url = '" . $itemRSS['url'] . "'");
			if(is_null($model))
			{
				$author = $node->getElementsByTagName('author')->item(0)->nodeValue;
				$authorMail = explode(' ', $author);
				$authorMail = $authorMail[0];
				$authorModel = User::model()->find("email = '" . $authorMail . "'");
				$authorMailArr = explode('@', $authorMail);
				$authorMailArr[1] = explode('.', $authorMailArr[1]);
				$authorMailArr[1] = $authorMailArr[1][0];
				if(is_null($authorModel))
				{
					$ans = $this->simpleGet('appsmail.ru', '/platform/' . $authorMailArr[1] . '/' . $authorMailArr[0]);
					$ans = $this->parseJsonAns($ans);
					if(isset($_COOKIE['mrc']))
					{
						parse_str(urldecode($_COOKIE['mrc']), $mrcArray);
						$profile = $this->getProfile($mrcArray['session_key'], $ans['uid']);
						if(!empty($profile['external_id']))
						{
							$user = User::model()->find('external_id = "' . $profile['external_id'] . '"');
							if(is_null($user))
							{
								$user = new User;
							}
							$user->attributes = $profile;
							$user->club = 1;
							if($user->save())
							{
								$itemRSS['author_id'] = $user->id;
							}
						}
					}
				} else
				{
					$itemRSS['author_id'] = $authorModel->id;
				}
				if($itemRSS['author_id'] > 0)
				{
					$model = new ClubPost;
					$model->attributes = $itemRSS;
					if($model->save())
					{
						$newPosts[] = $itemRSS;
					}
				}
			}
		}
		return $newPosts;
	}

	public function getProfile($session_key, $uid = false)
	{
		$properties = array(
			'method' => 'users.getInfo',
			'session_key' => $session_key,
			'secure' => '1',
		);
		if($uid)
			$properties['uids'] = $uid;
		$arr = $this->sendMailruRequest($properties);
		$profile = array();
		$profile['external_id'] = $arr['uid'];
		$profile['nick'] = $arr['nick'];
		$profile['email'] = $arr['email'];
		$profile['first_name'] = $arr['first_name'];
		$profile['last_name'] = $arr['last_name'];
		$profile['avatar'] = $arr['pic'];
		$profile['link'] = $arr['link'];
		$profile['country'] = $arr['location']['country']['name'];
		$profile['city'] = $arr['location']['city']['name'];
		return $profile;
	}

}