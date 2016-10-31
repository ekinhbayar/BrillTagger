<?php
/**
 * Test data for tagging singular reflexive pronouns
 *
 * @todo Add more tests data
 */

return [
    [
        'She went herself. I myself enjoyed the day. It\'ll be solved by itself.',
        array (
            0 =>
                array (
                    'token' => 'She',
                    'tag' => 'PPS',
                ),
            1 =>
                array (
                    'token' => 'went',
                    'tag' => 'VBD',
                ),
            2 =>
                array (
                    'token' => 'herself.',
                    'tag' => 'PPL',
                ),
            3 =>
                array (
                    'token' => 'I',
                    'tag' => 'NN',
                ),
            4 =>
                array (
                    'token' => 'myself',
                    'tag' => 'PPL',
                ),
            5 =>
                array (
                    'token' => 'enjoyed',
                    'tag' => 'VBD',
                ),
            6 =>
                array (
                    'token' => 'the',
                    'tag' => 'AT',
                ),
            7 =>
                array (
                    'token' => 'day.',
                    'tag' => 'NN',
                ),
            8 =>
                array (
                    'token' => 'It\'ll',
                    'tag' => 'PPS+MD',
                ),
            9 =>
                array (
                    'token' => 'be',
                    'tag' => 'BE',
                ),
            10 =>
                array (
                    'token' => 'solved',
                    'tag' => 'VBD',
                ),
            11 =>
                array (
                    'token' => 'by',
                    'tag' => 'IN',
                ),
            12 =>
                array (
                    'token' => 'itself.',
                    'tag' => 'PPL',
                ),
        )
    ]
];

