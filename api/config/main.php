<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php')
    // require(__DIR__ . '/params-local.php')
);
$version = 'v1';
return [
    'id' => 'app-api',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'api\controllers',
    'sourceLanguage'=>'ru',
    'language'=>'ru',
    'modules' => [
        'v1' => [
            'class' => 'api\modules\v1\Module',
        ],
        'user' => [
            'class' => 'dektrium\user\Module',
            'admins' => ['Admin'],
            'enableRegistration'=>false,
            'controllerMap' => [
                'security' => 'backend\controllers\SecurityController',
            ]
        ],
    ],
    'components' => [
       'urlManager' => [
            'enablePrettyUrl' => true,
            // 'enableStrictParsing' => true,
            'showScriptName' => false,
            'rules' => [            
                ['pattern' => '','route' => 'v1/test'],
                ['pattern' => 'v1/<controller>/<action>/<id:\d+>','route' => 'v1/<controller>/<action>'],
            ],
       ],
        'request' => [
            'enableCookieValidation'=>false,
            'enableCsrfValidation'=>false,
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ]
        ],
        'response' => [
            'format' => yii\web\Response::FORMAT_JSON,
            'charset' => 'UTF-8',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableSession' => false,
            'loginUrl' => null,
        ],              
    ],
    'params' => $params,
];