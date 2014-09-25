<?php
/**
 * Created by PhpStorm.
 * User: mikita
 * Date: 25/09/14
 * Time: 01:16 PM
 */

namespace site\frontend\modules\photo\tests;


use Guzzle\Http\Client;

class ApiTest extends \PHPUnit_Framework_TestCase
{
    public function testAlbums()
    {
        $client = new Client('http://www.virtual-giraffe.ru');
        $request = $client->post('/api/photo/albums/create/', null, json_encode(array(
            'attributes' => array(
                'title' => 'Тестовый альбом',
                'description' => 'Тестовое описание',
            ),
        )));

        $response = $request->send()->getBody(true);

        $response = json_decode($response);

        var_dump($response);
    }
}