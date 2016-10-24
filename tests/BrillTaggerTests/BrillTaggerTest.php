<?php

namespace BrillTaggerTests;

use BrillTagger\BrillTagger;

class BrillTaggerTest extends \PHPUnit_Framework_TestCase
{
    private $tagger;
    protected $preserveGlobalState = FALSE;
    protected $runTestInSeparateProcess = TRUE;

    public function setUp()
    {
        $this->tagger = new BrillTagger();
    }

    public function tearDown()
    {
        $this->tagger = null;
    }

    /**
     * Data provider for brill tagger
     *
     * @return array
     */
    public function inputProvider()
    {
        return require(__DIR__ . '/data_provider/sample_input.php');
    }

    /**
     * Test tagging result array
     *
     * @param string $input
     * @param array $expected
     *
     * @dataProvider inputProvider
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    public function testBrillTagger(string $input, array $expected)
    {
        $tags = $this->tagger->tag($input);

        $this->assertEquals($expected, $tags);
    }
}
