<?php
return [
    'ctrl' => [
        'title' => 'LLL:EXT:events2/Resources/Private/Language/locallang_db.xlf:tx_events2_domain_model_day',
        'label' => 'day',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'cruser_id' => 'cruser_id',
        'hideTable' => true,
        'enablecolumns' => [
            'disabled' => 'hidden',
        ],
    ],
    'interface' => [
        'showRecordFieldList' => 'day',
    ],
    'columns' => [
        'day' => [
            'label' => 'Day',
            'config' => [
                'type' => 'input',
                'eval' => 'date',
            ],
        ],
        'day_time' => [
            'label' => 'DayTime',
            'config' => [
                'type' => 'input',
                'eval' => 'datetime',
            ],
        ],
        'sort_day_time' => [
            'label' => 'DayTime',
            'config' => [
                'type' => 'input',
                'eval' => 'datetime',
            ],
        ],
        'event' => [
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'foreign_table' => 'tx_events2_domain_model_event',
            ],
        ],
    ],
    'types' => [
        '1' => ['showitem' => 'day,'],
    ],
    'palettes' => [
        '1' => ['showitem' => ''],
    ],
];
