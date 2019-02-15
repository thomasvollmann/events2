<?php

//#######################################################################
// Extension Manager/Repository config file for ext: "events2"
//
// Auto generated by Extension Builder 2013-03-18
//
// Manual updates:
// Only the data in the array - anything else is removed by next write.
// "version" and "dependencies" must not be touched!
//#######################################################################

$EM_CONF[$_EXTKEY] = [
    'title' => 'Events 2',
    'description' => 'Create single and recurring events',
    'category' => 'plugin',
    'author' => 'Stefan Froemken',
    'author_email' => 'projects@jweiland.net',
    'author_company' => 'jweiland.net',
    'shy' => '',
    'priority' => '',
    'module' => '',
    'state' => 'stable',
    'internal' => '',
    'uploadfolder' => '1',
    'createDirs' => '',
    'modify_tables' => '',
    'clearCacheOnLoad' => 0,
    'lockType' => '',
    'version' => '3.3.8',
    'constraints' => [
        'depends' => [
            'typo3' => '8.7.0-9.99.99',
            'static_info_tables' => '6.3.9',
        ],
        'conflicts' => [
        ],
        'suggests' => [
            'maps2' => '4.2.0',
        ],
    ],
];
