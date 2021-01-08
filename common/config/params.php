<?php
return [
    'adminEmail' => 'admin@example.com',
    'supportEmail' => 'support@example.com',
    'user.passwordResetTokenExpire' => 3600,

    /* 上传的图片路径是否加密，配合 \common\helpers\Html::src()使用 */
    'storage_encrypt' => false,


    
    /* redis key 前缀 */
    'redisKey' => 'school_cache_',
    /* redis key 标识 */
    'redisKeyPre' => [
        'school'      => 'school',          //哈希类型 以school_id为键值，存储一个学校的所有信息
        'member'      => 'member',          //哈希类型 以uid为键值，一个用户信息
        'rank_school' => 'rank_school',     //哈希类型 以school_id为键值，所有学校贡献排名
        'rank_user'   => 'rank_user',       //哈希类型 以school_id为键值，一学校的用户贡献排名
        'renk_user_top1' => 'renk_user_top1'//哈希类型 以school_id为键值，一学校贡献第一名的用户
    ],
    /* redis key 生存时间 600秒 */
    'redisExpires' => 7200,

  

  

    
    
];
