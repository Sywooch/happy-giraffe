<?php
/**
 * Created by JetBrains PhpStorm.
 * User: mikita
 * Date: 9/27/13
 * Time: 11:07 PM
 * To change this template use File | Settings | File Templates.
 */

class HhParser
{
    const TOKEN_URL = 'https://m.hh.ru/oauth/token';

    protected $clientId = 'LRLLJS304GJD8QIOQ6SIBI1NL4EOR7RN3E7LKJ5B89066KQKMPM20IBNJKGBISKT';
    protected $clientSecret = 'K03MB8RBA6SN6KHCD4ATI7JKE0A3UM08LFV02EBCFTC16IFB2GI3V1K522GV063H';
    protected $token;

    public function __construct($code)
    {
        $this->token = $this->getToken($code);
    }

    protected function getToken($code)
    {
        $ch = curl_init(self::TOKEN_URL);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, array(
            'grant_type' => 'authorization_code',
            'client_id' => $this->clientId,
            'client_secret' => $this->clientSecret,
            'code' => $code,
        ));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        $response = CJSON::decode($response);
        return $response['access_token'];
    }

    public function parseResume($hash)
    {
        $url = 'https://api.hh.ru/resumes/' . $hash;

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_8_5) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/29.0.1547.76 Safari/537.36');
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Authorization: Bearer ' . $this->token
        ));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $rawResponse = curl_exec($ch);
        if (curl_getinfo($ch, CURLINFO_HTTP_CODE) != 200)
            return false;
        $response = CJSON::decode($rawResponse);

        $firstName = $response['first_name'];
        $lastName = $response['last_name'];
        $middleName = $response['middle_name'];
        $salaryAmount = $response['salary']['amount'];
        $salaryCurrency = $response['salary']['currency'];
        $city = $response['area']['name'];
        $age = (! empty($response['birth_date'])) ? DateTime::createFromFormat('Y-m-d', $response['birth_date'])->diff(new DateTime('now'))->y : null;

        $contacts1 = array_reduce($response['contact'], function($a, $b) {
            switch ($b['type']['id']) {
                case 'cell':
                    $value = '+' . $b['value']['country'] . ' (' . $b['value']['city'] . ') ' . $b['value']['number'];
                    break;
                default:
                    $value = $b['value'];
            }

            $a[$b['type']['name']] = $value;
            return $a;
        }, array());
        $contacts2 = array_reduce($response['site'], function($a, $b) {
            $a[$b['type']['name']] = $b['url'];
            return $a;
        }, array());
        $contacts = CMap::mergeArray($contacts1, $contacts2);

        return compact('firstName', 'lastName', 'middleName', 'salaryAmount', 'salaryCurrency', 'city', 'age', 'contacts', 'rawResponse');
    }
}