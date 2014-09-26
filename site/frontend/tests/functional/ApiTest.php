<?php
/**
 * Created by PhpStorm.
 * User: mikita
 * Date: 25/09/14
 * Time: 01:16 PM
 */

namespace site\frontend\modules\photo\tests;


use Guzzle\Http\Client;
use Guzzle\Plugin\Cookie\CookieJar\FileCookieJar;
use Guzzle\Plugin\Cookie\CookiePlugin;
use site\frontend\modules\photo\models\Photo;
use site\frontend\modules\photo\models\PhotoAlbum;
use site\frontend\modules\photo\models\PhotoAttach;
use site\frontend\modules\photo\models\PhotoCollection;

class ApiTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        \Yii::import('site.common.components.*');
        \Yii::import('site.frontend.modules.photo.models.*');

        Photo::model()->deleteAll();
        PhotoAttach::model()->deleteAll();
        PhotoAlbum::model()->deleteAll();
        PhotoCollection::model()->deleteAll();
    }

    public function testAlbums()
    {
        $user1Cookie = new CookiePlugin(new FileCookieJar(\Yii::getPathOfAlias('site.common.data.user1')));
        $user2Cookie = new CookiePlugin(new FileCookieJar(\Yii::getPathOfAlias('site.common.data.user2')));

        $user1Client = new Client('http://www.virtual-giraffe.ru');
        $user2Client = new Client('http://www.virtual-giraffe.ru');

        $user1Client->addSubscriber($user1Cookie);
        $user2Client->addSubscriber($user2Cookie);


        $this->login($user1Client);
        $this->login($user2Client);

        $r1 = $this->addAlbum($user1Client, array(
            'title' => 'Тестовый альбом Никиты',
            'description' => 'Он даже с описанием',
        ));
        $this->assertTrue($r1->success);



        $r2 = $this->editAlbum($user1Client, array(
            'title' => 'Измененный Никитой тайтл',
        ), $r1->data->id);
        $this->assertTrue($r2->success);

        $r3 = $this->editAlbum($user2Client, array(
            'title' => 'Измененный Сашей тайтл',
        ), $r1->data->id);
        $this->assertFalse($r3->success);
    }

    protected function login($client)
    {
        $request = $client->post('/signup/login/default/', null, array(
            'LoginForm[email]' => 'nikita@happy-giraffe.ru',
            'LoginForm[password]' => '111111',
        ));

        $request->send();
    }

    protected function addAlbum($client, $attributes)
    {
        $request = $client->post('/api/photo/albums/create/', null, json_encode(array(
            'attributes' => $attributes,
        )));
        $response = $request->send()->getBody(true);
        return json_decode($response);
    }

    protected function editAlbum($client, $attributes, $id)
    {
        $request = $client->post('/api/photo/albums/edit/', null, json_encode(array(
            'attributes' => $attributes,
            'id' => $id,
        )));
        $response = $request->send()->getBody(true);
        return json_decode($response);
    }
}