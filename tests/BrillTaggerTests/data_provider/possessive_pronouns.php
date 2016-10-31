<?php
/**
 * Test data for tagging possessive pronouns
 *
 * @todo Add more tests data
 */

return [
    [
        'Yours is there along with his and hers stuff. Theirs was already gone.',
        array (
            0 =>
                array (
                    'token' => 'Yours',
                    'tag' => 'PP$$',
                ),
            1 =>
                array (
                    'token' => 'is',
                    'tag' => 'BEZ',
                ),
            2 =>
                array (
                    'token' => 'there',
                    'tag' => 'EX',
                ),
            3 =>
                array (
                    'token' => 'along',
                    'tag' => 'IN',
                ),
            4 =>
                array (
                    'token' => 'with',
                    'tag' => 'IN',
                ),
            5 =>
                array (
                    'token' => 'his',
                    'tag' => 'PP$',
                ),
            6 =>
                array (
                    'token' => 'and',
                    'tag' => 'CC',
                ),
            7 =>
                array (
                    'token' => 'hers',
                    'tag' => 'PP$$',
                ),
            8 =>
                array (
                    'token' => 'stuff.',
                    'tag' => 'NN',
                ),
            9 =>
                array (
                    'token' => 'Theirs',
                    'tag' => 'PP$$',
                ),
            10 =>
                array (
                    'token' => 'was',
                    'tag' => 'BEDZ',
                ),
            11 =>
                array (
                    'token' => 'already',
                    'tag' => 'QL',
                ),
            12 =>
                array (
                    'token' => 'gone.',
                    'tag' => 'VBN',
                ),
        )
    ]
];

