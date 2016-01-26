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

    public function testClubIsRequired()
    {
        $this->idea->club = null;
        $this->assertFalse($this->idea->validate(array('club')));
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

    public function testClubExists()
    {
        $this->idea->club = 99999;
        $this->assertFalse($this->idea->validate(array('club')));
    }

    public function testForumsIsMatchPattern()
    {
        $this->idea->forums = null;
        $this->assertTrue($this->idea->validate(array('forums')));

        $this->idea->forums = '';
        $this->assertTrue($this->idea->validate(array('forums')));

        $this->idea->forums = '20';
        $this->assertTrue($this->idea->validate(array('forums')));

        $this->idea->forums = '20,';
        $this->assertTrue($this->idea->validate(array('forums')));

        $this->idea->forums = '20,30';
        $this->assertTrue($this->idea->validate(array('forums')));

        $this->idea->forums = '20,30,';
        $this->assertTrue($this->idea->validate(array('forums')));

        $this->idea->forums = 'a';
        $this->assertFalse($this->idea->validate(array('forums')));

        $this->idea->forums = '20,a,30';
        $this->assertFalse($this->idea->validate(array('forums')));
    }

    public function testRubricsIsMatchPattern()
    {
        $this->idea->rubrics = null;
        $this->assertTrue($this->idea->validate(array('rubrics')));

        $this->idea->rubrics = '';
        $this->assertTrue($this->idea->validate(array('rubrics')));

        $this->idea->rubrics = '20';
        $this->assertTrue($this->idea->validate(array('rubrics')));

        $this->idea->rubrics = '20,';
        $this->assertTrue($this->idea->validate(array('rubrics')));

        $this->idea->rubrics = '20,30';
        $this->assertTrue($this->idea->validate(array('rubrics')));

        $this->idea->rubrics = '20,30,';
        $this->assertTrue($this->idea->validate(array('rubrics')));

        $this->idea->rubrics = 'a';
        $this->assertFalse($this->idea->validate(array('rubrics')));

        $this->idea->rubrics = '20,a,30';
        $this->assertFalse($this->idea->validate(array('rubrics')));
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