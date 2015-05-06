<?php


class EchoRegexTest extends \Codeception\TestCase\Test
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    protected function _before()
    {
    }

    protected function _after()
    {
    }

    // tests
    public function testNoSpace()
    {
        $line = '<p>{{var}}</p>';
        $result = FindEcho::run($line);
        $this->assertEquals('var', $result['echo']);
    }

    public function testLeftSpace()
    {
        $line = '<p>{{ var}}</p>';
        $result = FindEcho::run($line);
        $this->assertEquals('var', $result['echo']);
    }

    public function testRightSpace()
    {
        $line = '<p>{{var }}</p>';
        $result = FindEcho::run($line);
        $this->assertEquals('var', $result['echo']);
    }

    public function testSpaces()
    {
        $line = '<p>{{ var }}</p>';
        $result = FindEcho::run($line);
        $this->assertEquals('var', $result['echo']);
    }

    public function testShortEscape()
    {
        $line = '<p>{{var|e}}</p>';
        $result = FindEcho::run($line);
        $this->assertEquals('var', $result['echo']);
        $this->assertEquals('|e', $result['escape']);
    }

    public function testLongEscape()
    {
        $line = '<p>{{var|escape}}</p>';
        $result = FindEcho::run($line);
        $this->assertEquals('var', $result['echo']);
        $this->assertEquals('|escape', $result['escape']);
    }

    public function testBeforeAndAfterString()
    {
        $line = '<p>{{var}}</p>';
        $result = FindEcho::run($line);
        $this->assertEquals('var', $result['echo']);
        $this->assertEquals('<p>', $result['start']);
        $this->assertEquals('</p>', $result['end']);
    }

    public function testShortEscapeWithExclaim() 
    {
        $line = '<p>{{var!e}}</p>';
        $result = FindEcho::run($line);
        $this->assertEquals('var', $result['echo']);
        $this->assertEquals('!e', $result['escape']);
    }

    public function testLongEscapeWithExclaim()
    {
        $line = '<p>{{var!escape}}</p>';
        $result = FindEcho::run($line);
        $this->assertEquals('var', $result['echo']);
        $this->assertEquals('!escape', $result['escape']);
    }
}
