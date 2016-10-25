<?php
/**
 * Test percentages
 *
 * @todo Add more tests data
 */


return [
    [
        '90% of all purchasing decisions are made subconsciously.',
        array (
            0 =>
                array (
                    'token' => '90%',
                    'tag' => 'NN',
                ),
            1 =>
                array (
                    'token' => 'of',
                    'tag' => 'IN',
                ),
            2 =>
                array (
                    'token' => 'all',
                    'tag' => 'ABN',
                ),
            3 =>
                array (
                    'token' => 'purchasing',
                    'tag' => 'VBG',
                ),
            4 =>
                array (
                    'token' => 'decisions',
                    'tag' => 'NNS',
                ),
            5 =>
                array (
                    'token' => 'are',
                    'tag' => 'BER',
                ),
            6 =>
                array (
                    'token' => 'made',
                    'tag' => 'NIL',
                ),
            7 =>
                array (
                    'token' => 'subconsciously.',
                    'tag' => 'RB',
                ),
        )
    ]
];
