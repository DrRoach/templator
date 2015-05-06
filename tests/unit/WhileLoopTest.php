<?php


class WhileLoopTest extends \Codeception\TestCase\Test
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
    public function testFindWhileTag()
    {
        $line = '<ul>{{ while(count < 10) }}';
        $result = FindWhile::run($line);
        $this->assertEquals('<ul>', $result['start']);
        $this->assertEquals('count < 10', $result['expr']);
    }

    public function testParseWhileTagVarOnLeft()
    {
        $line = [
            'start' => '<li>',
            'expr' => 'count < 10',
            'end' => ''
        ];
        $result = ParseWhile::run($line);
        $this->assertEquals('<li><?php while($count < 10): ?>', $result);
    }

    public function testParseWhileTagVarOnRight()
    {
        $line = [
            'start' => '<li>',
            'expr' => '10 > count',
            'end' => ''
        ];
        $result = ParseWhile::run($line);
        $this->assertEquals('<li><?php while(10 > $count): ?>', $result);
    }
}
