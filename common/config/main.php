<?php
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'language'=>'ru',
    'sourceLanguage'=>'en',
    'bootstrap' => ['log'],
    'name' => 'support.sitmaster.kz',
    'components' => [
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'setting' => [
            'class' => 'funson86\setting\Setting',
        ],
    ],
];
