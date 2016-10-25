<?php

namespace BrillTaggerTests;

use BrillTagger\BrillTagger;

class BrillTaggerTest extends \PHPUnit_Framework_TestCase
{
    private $tagger;

    public function setUp()
    {
        $this->tagger = new BrillTagger();
    }

    public function tearDown()
    {
        $this->tagger = null;
    }

    /**
     * Data provider for sample input
     *
     * @return array
     */
    public function sampleInputProvider()
    {
        return require(__DIR__ . '/data_provider/sample_input.php');
    }

    /**
     * Data provider for conversion of verbs after 'the' to nouns
     *
     * @return array
     */
    public function verbToArticleInputProvider()
    {
        return require(__DIR__ . '/data_provider/noun_after_article.php');
    }

    /**
     * Data provider for percentages
     *
     * @return array
     */
    public function percentageInputProvider()
    {
        return require(__DIR__ . '/data_provider/percentage.php');
    }

    /**
     * Test tagging result array
     *
     * @param string $input
     * @param array $expected
     *
     * @dataProvider sampleInputProvider
     */
    public function testBrillTagger(string $input, array $expected)
    {
        $tags = $this->tagger->tag($input);
        $this->assertEquals($expected, $tags);
    }

    /**
     * Test conversion of verbs after 'the' to nouns
     *
     * @param string $input
     * @param array $expected
     *
     * @dataProvider verbToArticleInputProvider
     */
    public function testVerbAfterArticleToNoun(string $input, array $expected)
    {
        $tags = $this->tagger->tag($input);
        $this->assertEquals($expected, $tags);
    }

    /**
     * Test conversion of verbs after 'the' to nouns
     *
     * @param string $input
     * @param array $expected
     *
     * @dataProvider percentageInputProvider
     */
    public function testPercentageTagging(string $input, array $expected)
    {
        $tags = $this->tagger->tag($input);
        $this->assertEquals($expected, $tags);
    }
}
