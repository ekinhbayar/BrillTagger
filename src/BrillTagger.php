<?php
/**
 * Part Of Speech Tagging
 * Brill Tagger
 *
 * @category   BrillTagger
 * @author     Ekin H. Bayar <ekin@coproductivity.com>
 * @version    0.1.0
 */

namespace BrillTagger;

class BrillTagger
{
    private $dictionary = LEXICON;

    /**
     * @param $text
     * @return array
     */
    public function tag($text) {

        preg_match_all("/[\w\d\.'%@]+/", $text, $matches);

        $tags = [];
        $i = 0;

        foreach ($matches[0] as $token) {
            # default to a common noun
            $tags[$i] = ['token' => $token, 'tag' => 'NN'];

            # remove trailing full stops
            if (substr(trim($token), -1) == '.') {
                $token = preg_replace('/\.+$/', '', $token);
            }

            # get from dictionary if set
            $tags[$i]['tag'] = $this->tokenExists($token)
                ? $this->dictionary[strtolower($token)][0]
                : 'NN';

            $tags[$i]['tag'] = $this->transformNumerics($tags[$i]['tag'], $token);

            # Anything that ends 'ly' is an adverb
            if ($this->isAdverb($token)) {
                $tags[$i]['tag'] = 'RB';
            }

            if ($this->isNoun($tags[$i]['tag'])) {
                $tags[$i]['tag'] = $this->transformNoun($tags[$i]['tag'], $token);
            }

            if ($i > 0) {
                if ($this->isNoun($tags[$i]['tag'])) {
                    $tags[$i]['tag'] = $this->transformNounToVerb($tags, $i, $token);
                } elseif ($this->isVerb($tags[$i]['tag'])) {
                    $tags[$i]['tag'] = $this->transformVerbToNoun($tags, $i);
                }
            }

            $i++;
        }

        return $tags;
    }

    /**
     * @param string $token
     * @return bool
     */
    public function tokenExists($token) {
        return isset($this->dictionary[strtolower($token)]);
    }

    /**
     * @param string $tag
     * @return bool
     */
    public function isNoun($tag) {
        return substr(trim($tag), 0, 1) == 'N';
    }

    /**
     * @param string $tag
     * @return bool
     */
    public function isSingularNoun($tag) {
        return $tag == 'NN';
    }

    /**
     * @param string $tag
     * @param string $token
     * @return bool
     */
    public function isPluralNoun($tag, $token) {
        return ($this->isNoun($tag) && substr($token, -1) == 's');
    }

    /**
     * @param string $tag
     * @return bool
     */
    public function isVerb($tag) {
        return substr(trim($tag), 0, 2) == 'VB' || $this->isVerbToHave($tag);
    }

    /**
     * @param string $tag
     * @return bool
     */
    public function isVerbToHave($tag) {
        return substr(trim($tag), 0, 3) == 'HVD' || substr(trim($tag), 0, 3) == 'HVN';
    }

    /**
     * @param string $tag
     * @return bool
     */
    public function isPronoun($tag) {
        return substr(trim($tag), 0, 1) == 'P';
    }

    /**
     * @param string $token
     * @return bool
     */
    public function isPastTenseVerb($token) {
        return in_array('VBN', $this->dictionary[strtolower($token)]);
    }

    /**
     * @param string $token
     * @return bool
     */
    public function isPresentTenseVerb($token) {
        return in_array('VBZ', $this->dictionary[strtolower($token)]);
    }

    /** it him me us you 'em thee we'uns
     * @param string $tag
     * @return bool
     */
    public function isAccusativePronoun($tag) {
        return $tag === 'PPO';
    }

    /** it he she thee
     * @param string $tag
     * @return bool
     */
    public function isThirdPersonPronoun($tag) {
        return $tag === 'PPS';
    }

    /** they we I you ye thou you'uns
     * @param string $tag
     * @return bool
     */
    public function isSingularPersonalPronoun($tag) {
        return $tag === 'PPSS';
    }

    /** itself himself myself yourself herself oneself ownself
     * @param string $tag
     * @return bool
     */
    public function isSingularReflexivePronoun($tag) {
        return $tag === 'PPL';
    }

    /** themselves ourselves yourselves
     * @param string $tag
     * @return bool
     */
    public function isPluralReflexivePronoun($tag) {
        return $tag === 'PPLS';
    }

    /** ours mine his her/hers their/theirs our its my your/yours out thy thine
     * @param string $tag
     * @return bool
     */
    public function isPossessivePronoun($tag) {
        return in_array($tag, ['PP$$', 'PP$']);
    }

    /**
     * @param string $token
     * @return bool
     */
    public function isAdjective($token) {
        return ($this->tokenExists($token))
            ? in_array('JJ', $this->dictionary[strtolower($token)])
            : substr($token, -2) == 'al';
    }

    /**
     * @param string $token
     * @return bool
     */
    public function isGerund($token) {
        return substr($token, -3) == 'ing';
    }

    /**
     * @param string $token
     * @return bool
     */
    public function isPastParticiple($token) {
        return substr($token, -2) == 'ed';
    }

    /**
     * @param string $token
     * @return bool
     */
    public function isAdverb($token) {
        return substr($token, -2) == 'ly' && strlen($token) !== 3;
    }

    /** Common noun to adj. if it ends with 'al',
     * to gerund if 'ing', to past tense if 'ed'
     *
     * @param string $tag
     * @param string $token
     * @return string
     */
    public function transformNoun($tag, $token) {

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
     * @param array $tags
     * @param int $i
     * @param string $token
     * @return mixed
     */
    public function transformNounToVerb($tags, $i, $token) {
        # Noun to verb if the word before is 'would'
        if ($this->isSingularNoun($tags[$i]['tag']) && strtolower($tags[$i-1]['token']) == 'would') {
            $tags[$i]['tag'] = 'VB';
        }

        # If we get noun noun, and the 2nd can be a verb, convert to verb
        if ($this->isNoun($tags[$i]['tag']) &&
            $this->isNoun($tags[$i-1]['tag']) &&
            $this->tokenExists($token)
        ) {
            if ($this->isPastTenseVerb($token)) {
                $tags[$i]['tag'] = 'VBN';
            } elseif ($this->isPresentTenseVerb($token)) {
                $tags[$i]['tag'] = 'VBZ';
            }
        }

        return $tags[$i]['tag'];
    }

    /**
     * @param array $tags
     * @param int $i
     * @return mixed
     */
    public function transformVerbToNoun($tags, $i) {
        # Converts verbs after 'the' to nouns
        if ($tags[$i-1]['tag'] == 'DT' && $this->isVerb($tags[$i]['tag'])) {
            $tags[$i]['tag'] = 'NN';
        }

        return $tags[$i]['tag'];
    }

    /**
     * @param string $tag
     * @param string $token
     * @return string
     */
    public function transformNumerics($tag, $token) {
        # tag numerals, cardinals, money (NNS)
        if (preg_match(NUMERAL, $token)) {
            $tag = 'NNS';
        }

        # tag years
        if (preg_match(YEAR, $token, $matches)) {
            $tag = (isset($matches['nns'])) ? 'NNS' : 'CD';
        }

        # tag percentages
        if (preg_match(PERCENTAGE, $token)) {
            $tag = 'NN';
        }

        return $tag;
    }
    
    public function transformVerbsToThirdPerson($tag, $token) {
        $verbs = ['can', 'shall', 'am', 'was', 'were', 'haz', 'said', 'made', 'do', 'go'];
        $isVB  = $this->isVerb($tag) || in_array($token, $verbs);
        # Disregard verb tags that don't need s|es|ies
        $isOK = in_array($tag, [ 'VBD', 'VBG', 'VBN', 'VBZ', 'MD' ]);

        if ($isVB) {
            if (substr($token, -1 ) == 'o') {
                $o = $token . 'es';
            } elseif (substr($token, -1 ) == 'y') {
                $o = substr($token, 0, 2) . 'ies';
            } elseif ($isOK) {
                $o = $token;
            } else {
                $o = $token . 's';
            }

            return $o;

        } else {
            return $token;
        }

    }
}
