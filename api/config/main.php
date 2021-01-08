<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/routes.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id'   => 'vlogapi',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'api\controllers',
    'bootstrap' => ['log'],
    'modules' => [],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-api',
        ],
        
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'advanced-backend',
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
        //redis组建
        'redis' => [
            'class' => 'yii\redis\Connection',
            'hostname' => env('REDIS_HOST'),
            'port' => env('REDIS_PORT'),
            'password' => env('REDIS_PASSWORD'),
            'database' => 1,
        ],
        //session 采用redis替代
        'session' => [
            'name' => 'authToken',
            'class' => 'yii\redis\Session',
            'redis' => [
                'hostname' => env('REDIS_HOST'),
                'port' => env('REDIS_PORT'),
                'password' => env('REDIS_PASSWORD'),
                'database'  => 2,
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        
        'urlManager' => [
            'enablePrettyUrl'     => true,
            'showScriptName'      => false,
            'enableStrictParsing' => false,
            'rules' => [
                'POST /login'             => 'login/login',
                'POST /register'          => 'login/register',
                'POST /sendsms'           => 'send/sms',
                'POST /smslogin'          => 'login/sms',
               
                #银行卡
                'GET  /get-banks'         => 'bank/list',//银行列表
                'POST /add-bank-card'     => 'bank/add',//添加银行卡
                'GET  /get-bank-list'     => 'bank/my',//银行卡列表
                'POST /del-bank-list'     => 'bank/del',//删除银行卡
                
                #我的
                'GET  /info'              => 'user/info',//获取用户信息
                'POST /up-user-info'      => 'user/update',//修改用户信息
                'POST /up-login_pwd'      => 'user/upLoginPwd',//修改登录密码
                'POST /up-deal-pwd'       => 'user/upDealPwd',//修改交易密码
                'GET  /get-follow'        => 'user/follow',//关注列表
                'GET  /get-deal-info'     => 'deal/list',//交易明细
                'GET  /follow/<id:\d+>'   => 'user/follow',//关注主播
                'GET  /isfollow/<id:\d+>' => 'user/isfollow',//主播是否关注
                'GET  /unfollow/<id:\d+>' => 'user/unfollow',//取关主播
                'GET  /getfollow'         => 'user/getfollow',//关注列表
                'GET  /dealtype'          => 'user/getdealtype',//交易类型
                'GET  /gift-record'       => 'gift/record',//礼物送出记录
                'GET  /wallet'            => 'user/wallet',//钱包
                
                #首页
                'GET  /get-banner'        => 'index/banner',//获取轮播图
                'GET  /get-games'         => 'index/game',//获取游戏列表
                'GET  /get-rooms'         => 'index/room',//获取首页推荐直播间
                
                #直播
                'GET  /get-my-rooms'      => 'room/my',//我关注的直播间
                'GET  /get-cmd-rooms'     => 'room/recommend',//推荐的主播间
                'GET  /get-new-rooms'     => 'room/new',//最新主播
                'GET  /get-face-rooms'    => 'room/face',//颜值主播
                
                'POST /enter-room'        => 'room/enter',//进入直播间
                'POST /leave-room'        => 'room/leave',//离开直播间
                'GET  /get-gift-list'     => 'gift/list',//直播间礼物列表
                'POST /gift-out'          => 'gift/sendout',//礼物送出
                
                'GET  /get-games-type/<id:\d+>'  => 'game/gettype',//获取游戏玩法
                'POST /order'             => 'order/into',//下单
                'GET  /game-history'      => 'game/history',//开奖历史
                'GET  /history/<pid:\d+>' => 'game/getonehistory',//单个开奖历史
                'GET  /lottery-number/<pid:\d+>' => 'game/lotterynumber',//可用的10期彩期
                
                'POST /getbet'            => 'game/getbet',//直播间的投注记录
                
                #其他
                'GET  /ststoken'          => 'user/ststoken',
                
                #游戏
                "POST /lottery-bet"       => "game/lotterybet",
                "POST /bet"               => "game/lotterybet",
                
                #红包
                'GET  /hbao/getroom'      => "hbao/getroom",//红包房间
                'POST /hbao/send'         => 'hbao/send', //发红包
                'POST /rob_hbao/<id:\d+>' => 'hbao/rob',//抢红包
                'GET  /get_hbao_one/<id:\d+>' => 'hbao/getone',//获取红包明细
                'POST /hbao/mysend'       => 'hbao/mysend', //发红包
                
                #支付
                'POST,GET /notify/<oid:\d+>' => 'notify/index',

                //获取活动列表
                'active-list'           => 'index/active-list',
                //获取活动列表
                'active-detail'           => 'index/active-detail',
                //领取活动奖金
                'get-bonus'           => 'index/get-bonus',
            ],
        ]
    ],
    'params' => $params,
];

