<?php

namespace site\frontend\tests\functional\v1\api;

use GuzzleHttp\Client;

class IdeaTest extends \PHPUnit_Framework_TestCase
{
    private $client;

    const COLLECTION = 606;
    const CLUB = 2;

    const EMAIL = '2@mail.ru';
    const PASSWORD = 'test';

    private static $ideaId;

    public function setUp()
    {
        parent::setUp();

        $this->client = new Client(array(
            'base_uri' => 'http://giraffe.code-geek.ru/v1/api/ideas/',
        ));
    }

    /**
     * @test
     */
    public function getIdeas()
    {
        $response = $this->client->get('');

        if ($response->getStatusCode() == 404) {
            echo "Ideas empty";
            return;
        }

        $this->assertEquals($response->getStatusCode(), 200);

        $ideas = json_decode($response->getBody()->getContents());
        $this->assertTrue(count($ideas) > 0);

        $response = $this->client->get('', array(
            'query' => array(
                'expand' => 'author,collection',
            ),
        ));

        $this->assertEquals($response->getStatusCode(), 200);

        $ideas = json_decode($response->getBody()->getContents());
        $this->assertTrue(count($ideas) > 0);

        foreach ($ideas as $idea) {
            $this->assertTrue(isset($idea->author));
            $this->assertTrue(isset($idea->collection));
            $this->assertTrue(count($idea->collection->attaches) >= 3);
        }

        $id = $ideas[0]->id;
        $response = $this->client->get($id . '/');

        $this->assertEquals($response->getStatusCode(), 200);

        $idea = json_decode($response->getBody()->getContents());

        $this->assertEquals(count($idea), 1);
    }

    /**
     * @test
     */
    public function createIdeas()
    {
        $this->handlePost(401);

        $params = array(
            'auth_email' => self::EMAIL,
            'auth_password' => self::PASSWORD,
        );

        $this->handlePost(400, $params);

        $params['title'] = 'Idea From Tests';
        $this->handlePost(400, $params);

        $params['collectionId'] = self::COLLECTION;
        $this->handlePost(400, $params);

        $params['club'] = self::CLUB;
        $this->handlePost(400, $params);

        $params['forums'] = '2,3';
        $this->handlePost(400, $params);

        $params['rubrics'] = '9,10,11,12';
        $response = $this->handlePost(200, $params);
        $idea = json_decode($response->getBody()->getContents());
        self::$ideaId = $idea[0]->id;
    }

    private function handlePost($code, $params = null)
    {
        $response = $this->makePostRequest($params);
        $this->assertEquals($response->getStatusCode(), $code);
        return $response;
    }

    private function makePostRequest($params = null)
    {
        return $this->client->post('', array(
            'http_errors' => false,
            'form_params' => $params,
        ));
    }

    /**
     * @test
     */
    public function updateIdeas()
    {
        /*$this->handlePut(401);

        $params = array(
            'auth_email' => self::EMAIL,
            'auth_password' => self::PASSWORD,
        );

        $this->handlePut(400, $params);

        $params['id'] = self::$ideaId;
        $this->handlePut(400, $params);

        $params['title'] = 'Idea From Tests Changed';
        $this->handlePut(400, $params);

        $params['collectionId'] = self::COLLECTION;
        $this->handlePut(200, $params);*/
    }

    private function handlePut($code, $params = null)
    {
        $response = $this->makePutRequest($params);
        $this->assertEquals($response->getStatusCode(), $code);
        return $response;
    }

    private function makePutRequest($params = null)
    {
        return $this->client->put('', array(
            'http_errors' => false,
            'body' => implode(',', $params),
        ));
    }

    /**
     * @test
     */
    public function deleteIdeas()
    {
        $this->handleDelete(401);

        $params = array(
            'auth_email' => self::EMAIL,
            'auth_password' => self::PASSWORD,
        );

        $this->handleDelete(400, $params);

        $params['action'] = 'delete';

        $this->handleDelete(400, $params);

        $params['id'] = self::$ideaId;
        $response = $this->handleDelete(200, $params);
        $idea = json_decode($response->getBody()->getContents())[0];
        $this->assertEquals($idea->isRemoved, 1);

        $params['action'] = 'restore';
        $response = $this->handleDelete(200, $params);
        $idea = json_decode($response->getBody()->getContents())[0];
        $this->assertEquals($idea->isRemoved, 0);

        //И окончательно удаляю.
        $params['action'] = 'delete';
        $response = $this->handleDelete(200, $params);
        $idea = json_decode($response->getBody()->getContents())[0];
        $this->assertEquals($idea->isRemoved, 1);
    }

    private function handleDelete($code, $params = null)
    {
        $response = $this->makeDeleteRequest($params);
        $this->assertEquals($response->getStatusCode(), $code);
        return $response;
    }

    private function makeDeleteRequest($params = null)
    {
        return $this->client->delete('', array(
            'http_errors' => false,
            'query' => $params,
        ));
    }
}