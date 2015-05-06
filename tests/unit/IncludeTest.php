<?php


class IncludeTest extends \Codeception\TestCase\Test
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    protected function _before()
    {
        file_put_contents('templates/' . TEMPLATE_FILE, 'Included');
    }

    protected function _after()
    {
        unlink('templates/' . TEMPLATE_FILE);
    }

    // tests
    public function testFindInclude()
    {
        $line = '<h1>{{ include(title) }}</h1>';
        $return = FindInclude::run($line);
        $this->assertEquals('<h1>', $return['start']);
        $this->assertEquals('</h1>', $return['end']);
        $this->assertEquals('title', $return['file']);
    }

    public function testParseInclude()
    {
        $line = [
            'start' => '<h1>',
            'file' => TEMPLATE_FILE,
            'end' => '</h1>'
        ];
        $return = ParseInclude::run($line);
        $this->assertEquals('<h1><?php Templator::load("'.TEMPLATE_FILE.'", Templator::$definedVars); ?></h1>', $return);
    }
}
