<?php
/**
 * Test data for tagging singular personal pronouns
 *
 * @todo Add more tests data
 */

return [
    [
        'They saw that we were working and I felt great.',
        array (
            0 =>
                array (
                    'token' => 'They',
                    'tag' => 'PPSS',
                ),
            1 =>
                array (
                    'token' => 'saw',
                    'tag' => 'NN',
                ),
            2 =>
                array (
                    'token' => 'that',
                    'tag' => 'CS',
                ),
            3 =>
                array (
                    'token' => 'we',
                    'tag' => 'PPSS',
                ),
            4 =>
                array (
                    'token' => 'were',
                    'tag' => 'BED',
                ),
            5 =>
                array (
                    'token' => 'working',
                    'tag' => 'VBG',
                ),
            6 =>
                array (
                    'token' => 'and',
                    'tag' => 'CC',
                ),
            7 =>
                array (
                    'token' => 'I',
                    'tag' => 'PPSS',
                ),
            8 =>
                array (
                    'token' => 'felt',
                    'tag' => 'NN',
                ),
            9 =>
                array (
                    'token' => 'great.',
                    'tag' => 'JJ',
                ),
        )
    ]
];

