<?php
/**
 * Test data for tagging accusative pronouns
 *
 * @todo Add more tests data
 */

return [
    [
        'It was you that annoyed him.',
        array (
            0 =>
                array (
                    'token' => 'It',
                    'tag' => 'PPO',
                ),
            1 =>
                array (
                    'token' => 'was',
                    'tag' => 'BEDZ',
                ),
            2 =>
                array (
                    'token' => 'you',
                    'tag' => 'PPO',
                ),
            3 =>
                array (
                    'token' => 'that',
                    'tag' => 'CS',
                ),
            4 =>
                array (
                    'token' => 'annoyed',
                    'tag' => 'VBD',
                ),
            5 =>
                array (
                    'token' => 'him.',
                    'tag' => 'PPO',
                ),
        )
    ]
];

