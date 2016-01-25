<?php

namespace site\frontend\tests\unit\idea;

use site\frontend\modules\som\modules\idea\models\Idea;
use site\frontend\modules\posts\models\Content;
use site\frontend\modules\posts\models\Label;
use site\frontend\modules\posts\models\Tag;

class IdeaTest extends \PHPUnit_Framework_TestCase
{
    protected $idea;

    protected function setUp()
    {
        parent::setUp();

        $this->idea = new Idea();
    }

    public function testTitleIsRequired()
    {
        $this->idea->title = '';
        $this->assertFalse($this->idea->validate(array('title')));
    }

    public function testCollectionIsRequired()
    {
        $this->idea->collectionId = null;
        $this->assertFalse($this->idea->validate(array('collectionId')));
    }

    public function testAuthorIsRequired()
    {
        $this->idea->authorId = null;
        $this->assertFalse($this->idea->validate(array('authorId')));
    }

    public function testCollectionIsGreaterThenZero()
    {
        $this->idea->collectionId = 0;
        $this->assertFalse($this->idea->validate(array('collectionId')));
        $this->idea->collectionId = -1;
        $this->assertFalse($this->idea->validate(array('collectionId')));
    }

    public function testAuthorIsGreaterThenZero()
    {
        $this->idea->authorId = 0;
        $this->assertFalse($this->idea->validate(array('authorId')));
        $this->idea->authorId = -1;
        $this->assertFalse($this->idea->validate(array('authorId')));
    }

    public function testTitleLength()
    {

        $this->idea->title = $this->createTitle(256);
        $this->assertFalse($this->idea->validate(array('title')));


        $this->idea->title = $this->createTitle(255);
        $this->assertTrue($this->idea->validate(array('title')));
    }

    public function testAuthorExists()
    {
        $this->idea->authorId = 400000;
        $this->assertFalse($this->idea->validate(array('authorId')));
    }

    public function testCollectionExists()
    {
        $this->idea->collectionId = 400000;
        $this->assertFalse($this->idea->validate(array('collectionId')));
    }

    private function createTitle($length)
    {
        $title = '';
        for ($i = 0; $i < $length; $i++) {
            $title .= '.';
        }

        return $title;
    }
}