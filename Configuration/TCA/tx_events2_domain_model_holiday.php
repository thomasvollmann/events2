<?php
return [
    'ctrl' => [
        'title' => 'LLL:EXT:events2/Resources/Private/Language/locallang_db.xlf:tx_events2_domain_model_holiday',
        'label' => 'title',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'cruser_id' => 'cruser_id',
        'rootLevel' => 1,
        'searchFields' => 'title',
        'iconfile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath('events2') . 'Resources/Public/Icons/tx_events2_domain_model_holiday.svg',
    ],
    'interface' => [
        'showRecordFieldList' => 'title, day, month',
    ],
    'columns' => [
        'title' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:events2/Resources/Private/Language/locallang_db.xlf:tx_events2_domain_model_holiday.title',
            'config' => [
                'type' => 'input',
                'size' => 30,
            ],
        ],
        'day' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:events2/Resources/Private/Language/locallang_db.xlf:tx_events2_domain_model_holiday.day',
            'config' => [
                'type' => 'input',
                'size' => 2,
                'eval' => 'int,required'
            ],
        ],
        'month' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:events2/Resources/Private/Language/locallang_db.xlf:tx_events2_domain_model_holiday.month',
            'config' => [
                'type' => 'input',
                'size' => 2,
                'eval' => 'int,required'
            ],
        ],
    ],
    'types' => [
        '1' => ['showitem' => 'title, day, month'],
    ],
    'palettes' => [
        '1' => ['showitem' => ''],
    ],
];
