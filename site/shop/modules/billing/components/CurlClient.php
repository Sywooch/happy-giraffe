<?php

class CurlClient extends CComponent
{
    const GET = 'GET';
    const POST = 'POST';
    const PUT = 'PUT';
    const DELETE = 'DELETE';
    const JSPOST = 'JSON_POST';
    const JSPUT = 'JSON_PUT';
    const JSDELETE = 'JSON_DELETE';

    public		$cookies;
    protected	$_IID;

	protected $last_http_status;
    protected $last_http_url;
    protected $last_http_method;
    protected $last_response_headers;
    protected $last_response;
    protected $last_sent_headers;
    protected $last_sent_body;


	static function Instance($iid='default')
	{
		static $instances;
		if (!isset($instances[$iid])) {
			$instances[$iid] = new CurlClient($iid);
		}
	}

    function __construct($iid)
	{
		$this->_IID = $iid;
		parent::__construct();
	}

    protected function getCurl($url)
	{
        $curl = curl_init($this->last_http_url = $url);

        if ($this->cookies===true) {
			$this->cookies = tempnam('/tmp', "curl_sess_".$this->_IID."_");
            curl_setopt($curl, CURLOPT_COOKIEJAR, $this->cookies);
            curl_setopt($curl, CURLOPT_COOKIEFILE, $this->cookies);
        }
        curl_setopt($curl, CURLOPT_FORBID_REUSE, true);
        curl_setopt($curl, CURLOPT_HEADER, true);
        curl_setopt($curl, CURLINFO_HEADER_OUT, true);
        return $curl;
    }

    public function query($url, $data = null, $method=null, $return = false, $headers = null) {
        if (!$method) {
            $method = 'GET';
        }
        $this->last_http_method = $method;
        $ch = false;
        if ($method == 'GET' && $data) {
            $data = http_build_query($data);
            $url .= '?'.$data;
            $ch = $this->getCurl($url);
        } elseif ($method == 'GET') {
            $ch = $this->getCurl($url);
        } elseif ($method == 'POST') {
            $ch = $this->getCurl($url);
            curl_setopt($ch, CURLOPT_POST, TRUE);
            curl_setopt($ch, CURLOPT_POSTFIELDS, @http_build_query($data));
            $this->last_sent_body = @http_build_query($data);
        } elseif(strpos($method, 'JSON_') !== false) {
            $ch = $this->getCurl($url);
            $method = str_replace('JSON_', '', $method);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
            $data = json_encode($data);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        } elseif($method != 'GET') {
            $ch = $this->getCurl($url);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        }

        if ($headers !== null) {
            if (is_array($headers)) {
                $rh = array();
                $hk = array_keys($headers);
                if (!is_numeric($hk[0])) {
                    $ch = count($hk);
                    for($i=0;$i<$ch;$i++) {
                        $k = $hk[i];
                        $rh[] = $k.': '.$headers[$k];
                    }
                    $headers = &$rh;
                }
            } else {
                $headers = array($headers);
            }
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        }

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $ret = curl_exec($ch);
        if (curl_errno($ch)!== 0) {
            throw new Exception('CURL failed: '.curl_error($ch));
        }
        $ret = explode("\r\n\r\n", $ret);
        $this->last_response_headers = array_shift($ret);
        $ret = implode("\r\n\r\n", $ret);
        $this->last_response = $ret;
        $this->last_http_status = (int)curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $this->last_sent_headers = curl_getinfo($ch, CURLINFO_HEADER_OUT);
        curl_close($ch);
        if ($return)
            return $ret;
    }

    public function queryJSON($url, $data = null, $method = null) {
        $body = $this->query($url, $data, $method, true);

        $result = json_decode($body, true, 10);
        if (!$result) {
            throw new Exception('JSON FAILED: '.$body);
        }
        return $result;
    }

    public function getJSON($url, $data = null, $method = null) {
        try {
            return $this->queryJSON($url, $data, $method);
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function get($url, $data = null, $method = null, $headers = null) {
        try {
            return $this->query($url, $data, $method, true, $headers);
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function debugLast() {
        echo '<hr/>';
        echo '<center><h1>Curl debug</h1></center>';
        echo '<hr/>';
        echo '<center><h2>'.$this->last_http_method.' Request</h2></center>';
        echo '<hr/>';
        echo nl2br($this->last_sent_headers."\n\n".$this->last_sent_body);
        echo '<center><h2>Response: '.$this->last_http_status.'</h2></center>';
        echo '<hr/>';
        echo nl2br($this->last_response_headers."\n\n".$this->last_response);
    }
}

?>
