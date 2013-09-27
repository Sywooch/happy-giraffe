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

    public $clientId = 'LRLLJS304GJD8QIOQ6SIBI1NL4EOR7RN3E7LKJ5B89066KQKMPM20IBNJKGBISKT';
    public $clientSecret = 'K03MB8RBA6SN6KHCD4ATI7JKE0A3UM08LFV02EBCFTC16IFB2GI3V1K522GV063H';
    public $code;

    public function __construct($code)
    {
        $this->code = $code;
    }

    public function run()
    {
        $resumes = $this->getResumes();

        $data = array();
        $token = $this->getToken();
        foreach ($resumes as $hash) {
            $url = 'https://api.hh.ru/resumes/' . $hash;

            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_8_5) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/29.0.1547.76 Safari/537.36');
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Authorization: Bearer ' . $token
            ));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($ch);
            $response = CJSON::decode($response);

            $name = $response['last_name'] . ' ' . $response['first_name'] . ' ' . $response['middle_name'];
            $salary = $response['salary']['amount'] . ' ' . $response['salary']['currency'];
            $city = $response['area']['name'];
            if (! empty($response['birth_date'])) {
                $years = DateTime::createFromFormat('Y-m-d', $response['birth_date'])->diff(new DateTime('now'))->y;
                $age = $years . ' ' . Str::GenerateNoun(array('год', 'года', 'лет'), $years);
            } else
                $age = '';
            $contacts1 = array_reduce($response['contact'], function($a, $b) {
                switch ($b['type']['id']) {
                    case 'cell':
                        $value = '+' . $b['value']['country'] . ' (' . $b['value']['city'] . ') ' . $b['value']['number'];
                        break;
                    default:
                        $value = $b['value'];
                }

                return $a . $b['type']['name'] . ': ' . $value . "\n";
            }, '');
            $contacts2 = array_reduce($response['site'], function($a, $b) {
                return $a . $b['type']['name'] . ': ' . $b['url'] . "\n";
            }, '');
            $contacts = $contacts1 . $contacts2;

            $data[] = compact('name', 'salary', 'city', 'age', 'contacts');
        }

        return $data;
    }

    public function getToken()
    {
        $ch = curl_init(self::TOKEN_URL);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, array(
            'grant_type' => 'authorization_code',
            'client_id' => $this->clientId,
            'client_secret' => $this->clientSecret,
            'code' => $this->code,
        ));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        $response = CJSON::decode($response);
        return $response['access_token'];
    }

    public function getResumes()
    {
        $filename = Yii::getPathOfAlias('site.common.data.hh');
        return $lines = file($filename, FILE_IGNORE_NEW_LINES);
    }
}