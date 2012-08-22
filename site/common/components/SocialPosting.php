<?php
/**
 * Author: alexk984
 * Date: 22.08.12
 */
class SocialPosting
{
    const APIKEY = 'btRzsXd5ky9yCBzC6TDrW';
    /**
     * @static
     * @param CommunityContent $model
     */
    public static function sendPost($model)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($curl, CURLOPT_USERPWD, 'email:password');
        $data = array(
            'apiKey' => self::APIKEY,
            'message' => "this is a message",
            //'socialNetworks' => array(12345),
        );
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($curl, CURLOPT_URL, 'https://api.hootsuite.com/api/2/messages');
        $response = curl_exec($curl);

        var_dump($response);
    }
}
