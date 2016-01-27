<?php

namespace site\frontend\tests\functional\v1\api;

use GuzzleHttp\Client;

class ClubTest extends \PHPUnit_Framework_TestCase
{
    private $client;

    public function setUp()
    {
        parent::setUp();

        $this->client = new Client(array(
            'base_uri' => 'http://giraffe.code-geek.ru/v1/api/clubs/',
        ));
    }

    /**
     * @test
     */
    public function getClubs()
    {
        $response = $this->client->get('');

        if ($response->getStatusCode() == 404) {
            echo "Clubs empty";
            return;
        }

        
    }
}