<?php declare(strict_types=1);
/**
 * Part Of Speech Tagging
 * Brill Tagger
 *
 * @category   BrillTagger
 * @author     Ekin H. Bayar <me@ekins.space>
 * @version    0.2.0
 */

namespace BrillTagger;

class BrillTagger
{
    private $dictionary = LEXICON;

    /**
     * @param $text
     * @return array
     */
    public function tag($text): array
    {

        preg_match_all("/[\w\.'%@]+/", $text, $matches);

        $tags = [];
        $i    = 0;

        foreach ($matches[0] as $token) {
            # default to a common noun
            $tags[$i] = ['token' => $token, 'tag' => 'NN'];

            # remove trailing full stops
            if (substr(trim($token), -1) === '.') {
                $token = preg_replace('/\.+$/', '', $token);
            }

            # get from dictionary if set
            if ($this->tokenExists($token)) {
                $tags[$i]['tag'] = $this->dictionary[$token][0];
            }

            $tags[$i]['tag'] = $this->transformNumerics($tags[$i]['tag'], $token);

            # Anything that ends 'ly' is an adverb
            if ($this->isAdverb($token)) {
                $tags[$i]['tag'] = 'RB';
            }

            if ($this->isNoun($tags[$i]['tag']) && !$this->isProperNoun($tags[$i]['tag'])) {
                $tags[$i]['tag'] = $this->transformNoun($tags[$i]['tag'], $token);
            }

            if ($i > 0) {
                $tags[$i]['tag'] = $this->transformBetweenNounAndVerb($tags, $i, $token);
            }

            $i++;
        }

        return $tags;
    }

    /**
     * @param string $token
     * @return bool
     */
    public function tokenExists($token): bool
    {
        return isset($this->dictionary[$token]);
    }

    /**
     * @param string $tag
     * @return bool
     */
    public function isNoun($tag): bool
    {
        return strpos(trim($tag), 'N') === 0;
    }

    /**
     * @param string $tag
     * @return bool
     */
    public function isProperNoun($tag): bool
    {
        return strpos(trim($tag), 'NP') === 0;
    }

    /**
     * @param string $tag
     * @return bool
     */
    public function isSingularNoun($tag): bool
    {
        return $tag === 'NN';
    }

    /**
     * @param string $tag
     * @param string $token
     * @return bool
     */
    public function isPluralNoun($tag, $token): bool
    {
        return ($this->isNoun($tag) && substr($token, -1) === 's');
    }

    /**
     * @param string $tag
     * @return bool
     */
    public function isVerb($tag): bool
    {
        return strpos(trim($tag), 'VB') === 0;
    }

    /**
     * @param string $tag
     * @return bool
     */
    public function isPronoun($tag): bool
    {
        return strpos(trim($tag), 'P') === 0;
    }

    /**
     * @param string $token
     * @return bool
     */
    public function isPastTenseVerb($token): bool
    {
        return in_array('VBN', $this->dictionary[$token], true);
    }

    /**
     * @param string $token
     * @return bool
     */
    public function isPresentTenseVerb($token): bool
    {
        return in_array('VBZ', $this->dictionary[$token], true);
    }

    /** it him me us you 'em thee we'uns
     *
     * @param string $tag
     * @return bool
     */
    public function isAccusativePronoun($tag): bool
    {
        return strpos(trim($tag), 'PPO') === 0;
    }

    /** it he she thee
     *
     * @param string $tag
     * @return bool
     */
    public function isThirdPersonPronoun($tag): bool
    {
        return strpos(trim($tag), 'PPS') === 0;
    }

    /** they we I you ye thou you'uns
     *
     * @param string $tag
     * @return bool
     */
    public function isSingularPersonalPronoun($tag): bool
    {
        return strpos(trim($tag), 'PPSS') === 0;
    }

    /** itself himself myself yourself herself oneself ownself
     *
     * @param string $tag
     * @return bool
     */
    public function isSingularReflexivePronoun($tag): bool
    {
        return strpos(trim($tag), 'PPL') === 0;
    }

    /** themselves ourselves yourselves
     *
     * @param string $tag
     * @return bool
     */
    public function isPluralReflexivePronoun($tag): bool
    {
        return strpos(trim($tag), 'PPLS') === 0;
    }

    /** ours mine his her/hers their/theirs our its my your/yours out thy thine
     *
     * @param string $tag
     * @return bool
     */
    public function isPossessivePronoun($tag): bool
    {
        return in_array($tag, ['PP$$', 'PP$'], true);
    }

    /**
     * @param string $token
     * @return bool
     */
    public function isAdjective($token): bool
    {
        return (substr($token, -2) === 'al' || in_array('JJ', $this->dictionary[$token], true));
    }

    /**
     * @param string $token
     * @return bool
     */
    public function isGerund($token): bool
    {
        return substr($token, -3) === 'ing';
    }

    /**
     * @param string $token
     * @return bool
     */
    public function isPastParticiple($token): bool
    {
        return substr($token, -2) === 'ed';
    }

    /**
     * @param string $token
     * @return bool
     */
    public function isAdverb($token): bool
    {
        return substr($token, -2) === 'ly';
    }

    /** Common noun to adj. if it ends with 'al',
     * to gerund if 'ing', to past tense if 'ed'
     *
     * @param string $tag
     * @param string $token
     * @return string
     */
    public function transformNoun($tag, $token): string
    {

        if ($this->isAdjective($token)) {
            $tag = 'JJ';
        } elseif ($this->isGerund($token)) {
            $tag = 'VBG';
        } elseif ($this->isPastParticiple($token)) {
            $tag = 'VBN';
        } elseif ($token === 'I') {
            $tag = 'PPSS';
        } elseif ($this->isPluralNoun($tag, $token)) {
            $tag = 'NNS';
        }

        # Convert noun to number if . appears
        if (strpos($token, '.') !== false) {
            $tag = 'CD';
        }

        return $tag;
    }

    /**
     * @param array  $tags
     * @param int    $i
     * @param string $token
     * @return mixed
     */
    public function transformBetweenNounAndVerb($tags, $i, $token)
    {
        # Noun to verb if the word before is 'would'
        if ($tags[$i - 1]['token'] === 'would' && $this->isSingularNoun($tags[$i]['tag'])) {
            $tags[$i]['tag'] = 'VB';
        }

        # If we get noun noun, and the 2nd can be a verb, convert to verb
        if ($this->tokenExists($token)
            && $this->isNoun($tags[$i]['tag'])
            && $this->isNoun($tags[$i - 1]['tag'])
        ) {
            if ($this->isPastTenseVerb($token)) {
                $tags[$i]['tag'] = 'VBN';
            } elseif ($this->isPresentTenseVerb($token)) {
                $tags[$i]['tag'] = 'VBZ';
            }
        }

        # Converts verbs after 'the' to nouns
        if ($tags[$i - 1]['tag'] === 'DT' && $this->isVerb($tags[$i]['tag'])) {
            $tags[$i]['tag'] = 'NN';
        }

        return $tags[$i]['tag'];
    }

    /**
     * @param string $tag
     * @param string $token
     * @return string
     */
    public function transformNumerics($tag, $token): string
    {
        # tag numerals, cardinals, money (NNS)
        if (preg_match(NUMERAL, $token)) {
            $tag = 'NNS';
        }

        # tag years
        if (preg_match(YEAR, $token, $matches)) {
            $tag = isset($matches['nns']) ? 'NNS' : 'CD';
        }

        # tag percentages
        if (preg_match(PERCENTAGE, $token)) {
            $tag = 'NN';
        }

        return $tag;
    }
}
