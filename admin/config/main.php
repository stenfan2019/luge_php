<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/routes.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id'   => 'admin',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'admin\controllers',
    
    'bootstrap' => ['log'],
    'modules' => [],
    'defaultRoute' => 'index',
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-api',
        ],
        
//        'session' => [
//            // this is the name of the session cookie used for login on the backend
//            'name' => 'advanced-backend',
//        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        //redis组建
        'redis' => [
            'class'    => 'yii\redis\Connection',
            'hostname' => env('REDIS_HOST'),
            'port'     => env('REDIS_PORT'),
            'password' => env('REDIS_PASSWORD'),
            'database' => 3,
        ],
        //session 采用redis替代
        'session' => [
            'name'  => 'authToken1',
            'class' => 'yii\redis\Session',
            'keyPrefix' => 'zb:Admin:login_info:',
            'redis' => [
                'hostname'  => env('REDIS_HOST'),
                'port'      => env('REDIS_PORT'),
                'password'  => env('REDIS_PASSWORD'),
                'database'  => 3,
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        
        'urlManager' => [
            'enablePrettyUrl'     => true,
            'showScriptName'      => false,
            'enableStrictParsing' => false,
            'rules' => include __DIR__.'/routes.php',
        ],
        'user' => [
            'identityClass' => 'admin\models\Admin', // User must implement the IdentityInterface
            'enableAutoLogin' => true,
            // 'loginUrl' => ['user/login'],
            // ...
        ],
    ],
    'params' => $params,
];

