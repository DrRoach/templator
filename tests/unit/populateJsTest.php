<?php


class populateJsTest extends \Codeception\TestCase\Test
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
    public function testThatPopulateJsFunctionReturnsTrue()
    {
        $result = Templator::populateJs(['test' => 'This is test data']);
        $this->assertTrue($result);
    }

}