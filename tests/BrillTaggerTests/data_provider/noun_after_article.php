<?php
/**
 * Test data for conversion of verbs after 'the' to nouns
 *
 * @todo Add more tests data
 */


return [
    [
        'They stalled all the work to be done this week.',
        array (
            0 =>
                array (
                    'token' => 'They',
                    'tag' => 'PPSS',
                ),
            1 =>
                array (
                    'token' => 'stalled',
                    'tag' => 'VBD',
                ),
            2 =>
                array (
                    'token' => 'all',
                    'tag' => 'ABN',
                ),
            3 =>
                array (
                    'token' => 'the',
                    'tag' => 'AT',
                ),
            4 =>
                array (
                    'token' => 'work',
                    'tag' => 'NN',
                ),
            5 =>
                array (
                    'token' => 'to',
                    'tag' => 'IN',
                ),
            6 =>
                array (
                    'token' => 'be',
                    'tag' => 'BE',
                ),
            7 =>
                array (
                    'token' => 'done',
                    'tag' => 'DOD',
                ),
            8 =>
                array (
                    'token' => 'this',
                    'tag' => 'DT',
                ),
            9 =>
                array (
                    'token' => 'week.',
                    'tag' => 'NN',
                ),
        )
    ]
];
