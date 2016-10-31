<?php
/**
 * Test data for tagging singular reflexive pronouns
 *
 * @todo Add more tests data
 */

return [
    [
        'They went out themselves, we had fun ourselves.',
        array (
            0 =>
                array (
                    'token' => 'They',
                    'tag' => 'PPSS',
                ),
            1 =>
                array (
                    'token' => 'went',
                    'tag' => 'VBD',
                ),
            2 =>
                array (
                    'token' => 'out',
                    'tag' => 'IN',
                ),
            3 =>
                array (
                    'token' => 'themselves',
                    'tag' => 'PPLS',
                ),
            4 =>
                array (
                    'token' => 'we',
                    'tag' => 'PPSS',
                ),
            5 =>
                array (
                    'token' => 'had',
                    'tag' => 'HVD',
                ),
            6 =>
                array (
                    'token' => 'fun',
                    'tag' => 'NN',
                ),
            7 =>
                array (
                    'token' => 'ourselves.',
                    'tag' => 'PPLS',
                ),
        )
    ]
];

