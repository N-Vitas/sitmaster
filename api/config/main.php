<?php
$params = array_merge(    
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
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
        $version => [
            'class' => 'api\modules\\'.$version.'\Module',
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
                ['pattern' => '','route' => $version.'/test'],
                ['pattern' => $version.'/<controller>/<action>/<id:\d+>','route' => $version.'/<controller>/<action>'],
                ['class' => 'yii\rest\UrlRule', 'controller' => $version.'/post'], 
                ['class' => 'yii\rest\UrlRule', 'controller' => $version.'/followers'],  
                ['class' => 'yii\rest\UrlRule', 'controller' => $version.'/user'],    
                ['class' => 'yii\rest\UrlRule', 'controller' => $version.'/car'],   
                ['class' => 'yii\rest\UrlRule', 'controller' => $version.'/colors'],    
                ['class' => 'yii\rest\UrlRule', 'controller' => $version.'/searchcar'], 
                ['class' => 'yii\rest\UrlRule', 'controller' => $version.'/profile'], 
                ['class' => 'yii\rest\UrlRule', 'controller' => $version.'/countries'], 
                //['class' => 'yii\rest\UrlRule', 'controller' => 'v1/regions'], 
                //['class' => 'yii\rest\UrlRule', 'controller' => 'v1/cities'], 
                //['class' => 'yii\rest\UrlRule', 'controller' => 'v1/comment'],Regions
                //'v1/comment/update/<id:\d+>' => 'v1/comment/update/<id:\d+>',             
                //['class' => 'yii\rest\UrlRule', 'controller' => 'v1/Test'],*/
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