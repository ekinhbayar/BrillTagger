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
    public function verbAfterArticleInputProvider()
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
     * Data provider for pronouns
     *
     * @return array
     */
    public function pronounsInputProvider()
    {
        return require(__DIR__ . '/data_provider/pronouns.php');
    }

    /**
     * Data provider for accusative pronouns
     *
     * @return array
     */
    public function accusativePronounsInputProvider()
    {
        return require(__DIR__ . '/data_provider/accusative_pronouns.php');
    }

    /**
     * Data provider for singular personal pronouns
     *
     * @return array
     */
    public function singularPersonalPronounsInputProvider()
    {
        return require(__DIR__ . '/data_provider/singular_personal_pronouns.php');
    }

    /**
     * Data provider for singular reflexive pronouns
     *
     * @return array
     */
    public function singularReflexivePronounsInputProvider()
    {
        return require(__DIR__ . '/data_provider/singular_reflexive_pronouns.php');
    }

    /**
     * Data provider for plural reflexive pronouns
     *
     * @return array
     */
    public function pluralReflexivePronounsInputProvider()
    {
        return require(__DIR__ . '/data_provider/plural_reflexive_pronouns.php');
    }

    /**
     * Data provider for possessive pronouns
     *
     * @return array
     */
    public function possessivePronounsInputProvider()
    {
        return require(__DIR__ . '/data_provider/possessive_pronouns.php');
    }

    /**
     * Test sample tagging result
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
     * @dataProvider verbAfterArticleInputProvider
     */
    public function testVerbAfterArticleToNoun(string $input, array $expected)
    {
        $tags = $this->tagger->tag($input);
        $this->assertEquals($expected, $tags);
    }

    /**
     * Test tagging percentages as nouns
     *
     * @param string $input
     * @param array $expected
     *
     * @dataProvider percentageInputProvider
     */
    public function testPercentageTagging(string $input, array $expected)
    {
        $tags = $this->tagger->tag($input);
        $this->assertEquals($expected, $tags[0]);
    }

    /**
     * Test if a tag is a noun
     *
     * @param string $input
     * @param array $expected
     *
     * @dataProvider sampleInputProvider
     */
    public function testIsNoun(string $input, array $expected)
    {
        $tags = $this->tagger->tag($input);
        $this->assertEquals($expected[3]['tag'], $tags[3]['tag']);
    }

    /**
     * Test if a tag is a verb
     *
     * @param string $input
     * @param array $expected
     *
     * @dataProvider sampleInputProvider
     */
    public function testIsVerb(string $input, array $expected)
    {
        $tags = $this->tagger->tag($input);
        $this->assertEquals($expected[4]['tag'], $tags[4]['tag']);
    }

    /**
     * Test if a tag is a pronoun
     *
     * @param string $input
     * @param array $expected
     *
     * @dataProvider pronounsInputProvider
     */
    public function testIsPronoun(string $input, array $expected)
    {
        $tags = $this->tagger->tag($input);
        $this->assertEquals(
            [
                $expected[0]['tag'],
                $expected[2]['tag'],
                $expected[4]['tag'],
                $expected[6]['tag']
            ],
            [
                $tags[0]['tag'],
                $tags[2]['tag'],
                $tags[4]['tag'],
                $tags[6]['tag']
            ]
        );
    }

    /**
     * Test if a tag is an accusative pronoun
     *
     * @param string $input
     * @param array $expected
     *
     * @dataProvider accusativePronounsInputProvider
     */
    public function testIsAccusativePronoun(string $input, array $expected)
    {
        $tags = $this->tagger->tag($input);
        $this->assertEquals(
            [
                $expected[0]['tag'],
                $expected[2]['tag'],
                $expected[5]['tag']
            ],
            [
                $tags[0]['tag'],
                $tags[2]['tag'],
                $tags[5]['tag']
            ]
        );
    }

    /**
     * Test if a tag is a 3rd person pronoun
     *
     * @param string $input
     * @param array $expected
     *
     * @dataProvider pronounsInputProvider
     */
    public function testIsThirdPersonPronoun(string $input, array $expected)
    {
        $tags = $this->tagger->tag($input);
        $this->assertEquals($expected[0]['tag'], $tags[0]['tag']);
    }

    /**
     * Test if a tag is a singular personal pronoun
     *
     * @param string $input
     * @param array $expected
     *
     * @dataProvider singularPersonalPronounsInputProvider
     */
    public function testIsSingularPersonalPronoun(string $input, array $expected)
    {
        $tags = $this->tagger->tag($input);
        $this->assertEquals(
            [
                $expected[0]['tag'],
                $expected[3]['tag'],
                $expected[7]['tag']
            ],
            [
                $tags[0]['tag'],
                $tags[3]['tag'],
                $tags[7]['tag']
            ]
        );
    }

    /**
     * Test if a tag is a reflexive singular pronoun
     *
     * @param string $input
     * @param array $expected
     *
     * @dataProvider singularReflexivePronounsInputProvider
     */
    public function testIsSingularReflexivePronoun(string $input, array $expected)
    {
        $tags = $this->tagger->tag($input);
        $this->assertEquals(
            [
                $expected[2]['tag'],
                $expected[4]['tag'],
                $expected[12]['tag']
            ],
            [
                $tags[2]['tag'],
                $tags[4]['tag'],
                $tags[12]['tag']
            ]
        );
    }

    /**
     * Test if a tag is a reflexive plural pronoun
     *
     * @param string $input
     * @param array $expected
     *
     * @dataProvider pluralReflexivePronounsInputProvider
     */
    public function testIsPluralReflexivePronoun(string $input, array $expected)
    {
        $tags = $this->tagger->tag($input);
        $this->assertEquals(
            [
                $expected[3]['tag'],
                $expected[7]['tag']
            ],
            [
                $tags[3]['tag'],
                $tags[7]['tag']
            ]
        );
    }

    /**
     * Test if a tag is a possessive pronoun
     *
     * @param string $input
     * @param array $expected
     *
     * @dataProvider possessivePronounsInputProvider
     */
    public function testIsPossessivePronoun(string $input, array $expected)
    {
        $tags = $this->tagger->tag($input);
        $this->assertEquals(
            [
                $expected[0]['tag'],
                $expected[5]['tag'],
                $expected[7]['tag'],
                $expected[9]['tag']
            ],
            [
                $tags[0]['tag'],
                $tags[5]['tag'],
                $tags[7]['tag'],
                $tags[9]['tag']
            ]
        );
    }
}
