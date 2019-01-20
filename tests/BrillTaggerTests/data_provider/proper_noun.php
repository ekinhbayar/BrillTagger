<?php
/**
 * This file contains a sample input sentence and expected resulting array with parts of speech and respective tags
 *
 * @todo Add more tests data
 */


return [
    [
        'James was walking down the alley.',
        array (
            0 =>
                array (
                    'token' => 'James',
                    'tag' => 'NP',
                ),
            1 =>
                array (
                    'token' => 'was',
                    'tag' => 'BEDZ',
                ),
            2 =>
                array (
                    'token' => 'walking',
                    'tag' => 'VBG',
                ),
            3 =>
                array (
                    'token' => 'down',
                    'tag' => 'RP',
                ),
            4 =>
                array (
                    'token' => 'the',
                    'tag' => 'AT',
                ),
            5 =>
                array (
                    'token' => 'alley',
                    'tag' => 'NNS',
                ),
        )
    ]
];
