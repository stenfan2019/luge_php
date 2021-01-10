<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-home',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    /* 默认路由 */
    'defaultRoute' => 'index',
    /* 控制器默认命名空间 */
    'controllerNamespace' => 'frontend\controllers',
    /* 模块 */
    'modules' => [
        'user' => [
            'class' => 'frontend\modules\user\Module',
        ],
    ],
    'components' => [
        'user' => [
            'identityClass' => 'frontend\models\User',
            'enableAutoLogin' => true,
        ],
        /* 修改默认的request组件 */
        'request' => [
            'class' => 'common\core\Request',
            'baseUrl' => Yii::getAlias('@frontendUrl'),
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'public/404',
        ],

        'urlManager' => [
            'enablePrettyUrl' => env('FRONTEND_PRETTY_URL', true),
            'showScriptName' => false,
            'rules' => [
                'GET /zuijing.html'  => 'index/zjgx',
                'GET /jingxuan.html' => 'index/jingxuan',
                'GET /zwzm.html'     => 'index/zwzm',
                'GET /yzwm.html'     => 'index/yzwm',
                'GET /yzym.html'     => 'index/yzym',
                'GET /wmpj.html'     => 'index/wmpj',
                'GET /tpzp.html'     => 'index/tpzp',
                'GET /wanghong.html' => 'index/wh',
                'GET /zhubo.html'    => 'index/zhubo',
                'GET /star.html'     => 'index/star',
                'GET /sanji.html'    => 'index/sanji',
                'GET /oumei.html'    => 'index/oumei',
                'GET /dongman.html'  => 'index/dongman',
                
                'GET /prestrain.html'=> 'player/prestrain',
                'GET /dplayer.html'  => 'player/index',
            ],
        ],

    ],
    'params' => $params,
];
