<?php
/**
 * This file contains a sample input sentence and expected resulting array with parts of speech and respective tags
 *
 * @todo Add more tests data
 */


return [
    [
        'The quick brown fox jumps over the lazy dog.',
        array (
            0 =>
                array (
                    'token' => 'The',
                    'tag' => 'AT',
                ),
            1 =>
                array (
                    'token' => 'quick',
                    'tag' => 'JJ',
                ),
            2 =>
                array (
                    'token' => 'brown',
                    'tag' => 'JJ',
                ),
            3 =>
                array (
                    'token' => 'fox',
                    'tag' => 'NN',
                ),
            4 =>
                array (
                    'token' => 'jumps',
                    'tag' => 'VBZ',
                ),
            5 =>
                array (
                    'token' => 'over',
                    'tag' => 'IN',
                ),
            6 =>
                array (
                    'token' => 'the',
                    'tag' => 'AT',
                ),
            7 =>
                array (
                    'token' => 'lazy',
                    'tag' => 'JJ',
                ),
            8 =>
                array (
                    'token' => 'dog.',
                    'tag' => 'NN',
                ),
        )
    ]
];
