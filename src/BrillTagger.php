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
            if (isset($this->dictionary[strtolower($token)])) {
                $tags[$i]['tag'] = $this->dictionary[strtolower($token)][0];
            }

            # Converts verbs after 'the' to nouns
            if ($i > 0) {
                if ($tags[$i-1]['tag'] == 'DT' && $this->isVerb($tags[$i]['tag'])) {
                    $tags[$i]['tag'] = 'NN';
                }
            }

            # Convert noun to number if . appears
            if ($tags[$i]['tag'][0] == 'N' && strpos($token, '.') !== false) {
                $tags[$i]['tag'] = 'CD';
            }

            # manually tag numerals, cardinals, money (NNS)
            if (preg_match(NUMERAL, $token)) {
                $tags[$i]['tag'] = 'NNS';
            }

            # manually tag years
            if (preg_match(YEAR, $token, $matches)) {
                $tags[$i]['tag'] = (isset($matches['nns'])) ? 'NNS' : 'CD';
            }

            # manually tag percentages
            if (preg_match(PERCENTAGE, $token)) {
                $tags[$i]['tag'] = 'NN';
            }

            # Convert noun to past participle if ends with 'ed'
            if ($tags[$i]['tag'][0] == 'N' && substr($token, -2) == 'ed') {
                $tags[$i]['tag'] = 'VBN';
            }

            # Anything that ends 'ly' is an adverb
            if (substr($token, -2) == 'ly') {
                $tags[$i]['tag'] = 'RB';
            }

            # Common noun to adjective if it ends with 'al', to gerund if 'ing'
            if ($this->isNoun($tags[$i]['tag'])) {
                if (substr($token, -2) == 'al') {
                    $tags[$i]['tag'] = 'JJ';
                } elseif (substr($token, -3) == 'ing') {
                    $tags[$i]['tag'] = 'VBG';
                } elseif ($token === 'I') {
                    $tags[$i]['tag'] = 'PPSS';
                }
            }

            # Noun to verb if the word before is 'would'
            if ($i > 0) {
                if ($tags[$i]['tag'] == 'NN' && strtolower($tags[$i-1]['token']) == 'would') {
                    $tags[$i]['tag'] = 'VB';
                }
            }

            # Noun to plural if it ends with an 's'
            if ($tags[$i]['tag'] == 'NN' && substr($token, -1) == 's') {
                $tags[$i]['tag'] = 'NNS';
            }

            # If we get noun noun, and the 2nd can be a verb, convert to verb
            if ($i > 0) {

                if ($this->isNoun($tags[$i]['tag'])
                    && $this->isNoun($tags[$i-1]['tag'])
                    && isset($this->dictionary[strtolower($token)])
                ) {
                    if (in_array('VBN', $this->dictionary[strtolower($token)])) {
                        $tags[$i]['tag'] = 'VBN';
                    } else if (in_array('VBZ', $this->dictionary[strtolower($token)])) {
                        $tags[$i]['tag'] = 'VBZ';
                    }
                }
            }

            $i++;
        }

        return $tags;
    }

    public function isNoun($tag) {
        return in_array($tag, ['NN', 'NNS']);
    }

    public function isVerb($tag) {
        return substr(trim($tag), 0, 2) == 'VB';
    }

    public function isPronoun($tag) {
        return substr(trim($tag), 0, 1) == 'P';
    }

    # it him me us you 'em thee we'uns
    public function isAccusativePronoun($tag) {
        return $tag === 'PPO';
    }

    # it he she thee
    public function isThirdPersonPronoun($tag) {
        return $tag === 'PPS';
    }

    # they we I you ye thou you'uns
    public function isSingularPersonalPronoun($tag) {
        return $tag === 'PPSS';
    }

    # itself himself myself yourself herself oneself ownself
    public function isSingularReflexivePronoun($tag) {
        return $tag === 'PPL';
    }

    # themselves ourselves yourselves
    public function isPluralReflexivePronoun($tag) {
        return $tag === 'PPLS';
    }

    #  ours mine his her/hers their/theirs our its my your/yours out thy thine
    public function isPossessivePronoun($tag) {
        return in_array($tag,['PP$$', 'PP$']);
    }

}
