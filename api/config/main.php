<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

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
            'enableStrictParsing' => true,
            'showScriptName' => false,
            'rules' => [
                'v1/login' => 'v1/login',
                'v1/login/key' => 'v1/login/key',
                'v1/login/token' => 'v1/login/token',
                'v1/login/logout' => 'v1/login/logout',
                'v1/login/create' => 'v1/login/create',
                'v1/test' => 'v1/test',
                'v1/test/test' => 'v1/test/test',
                'v1/test/create' => 'v1/test/create',
                //['class' => 'yii\rest\UrlRule', 'controller' => 'v1/Test'],
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
