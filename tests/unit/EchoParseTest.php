<?php


class EchoParseTest extends \Codeception\TestCase\Test
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
    public function testNoEscape()
    {
        $line = [
            'start' => '<p>Start of string ',
            'echo' => 'foo',
            'escape' => '',
            'end' => 'end of line</p>'
        ];
        $return = ParseEcho::run($line);
        $this->assertEquals('<p>Start of string <?= htmlspecialchars($foo); ?>end of line</p>', $return);
    }

    public function testShortEscape()
    {
        $line = [
            'start' => '<p>Start of string ',
            'echo' => 'foo',
            'escape' => '|e',
            'end' => 'end of line</p>'
        ];
        $return = ParseEcho::run($line);
        $this->assertEquals('<p>Start of string <?= $foo; ?>end of line</p>', $return);
    }

    public function testLongEscape()
    {
        $line = [
            'start' => '<p>Start of string ',
            'echo' => 'foo',
            'escape' => '|escape',
            'end' => 'end of line</p>'
        ];
        $return = ParseEcho::run($line);
        $this->assertEquals('<p>Start of string <?= $foo; ?>end of line</p>', $return);
    }

    public function testArrayNoEscape()
    {
        $line = [
            'start' => '<p>Start of string ',
            'echo' => 'foo.bar.final',
            'escape' => '',
            'end' => 'end of line</p>'
        ];
        $return = ParseEcho::run($line);
        $this->assertEquals("<p>Start of string <?= htmlspecialchars(\$foo['bar']['final']); ?>end of line</p>", $return);
    }

    public function testArrayEscaped()
    {
        $line = [
            'start' => '<p>Start of string ',
            'echo' => 'foo.bar.final',
            'escape' => '|e',
            'end' => 'end of line</p>'
        ];
        $return = ParseEcho::run($line);
        $this->assertEquals("<p>Start of string <?= \$foo['bar']['final']; ?>end of line</p>", $return);
    }

    public function testEsclaimShortEscaped()
    {
        $line = [
            'start' => '<p>Start of string ',
            'echo' => 'foo',
            'escape' => '!e',
            'end' => ' end of line</p>'
        ];
        $return = ParseEcho::run($line);
        $this->assertEquals("<p>Start of string <?= \$foo; ?> end of line</p>", $return);
    }

    public function testEsclaimLongEscaped()
    {
        $line = [
            'start' => '<p>Start of string ',
            'echo' => 'foo',
            'escape' => '!escape',
            'end' => ' end of line</p>'
        ];
        $return = ParseEcho::run($line);
        $this->assertEquals("<p>Start of string <?= \$foo; ?> end of line</p>", $return);
    }
}
