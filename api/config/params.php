<?php
return [
    'adminEmail'    => 'admin@example.com',
    'api_key'   => '5rJCRvHbYQmfr2BVaAwzGlNmzoWZUxcd',
    'bank_max_bind' => 5,//最大可绑定银行卡数量
    'bank_list'     => [
        'CCB'  => '中国建设银行',
        'ABC'  => '中国农业银行卡',
        'BOC'  => '中国银行',
        'CMBC' => '民生银行',
        'CIB'  => '兴业银行',
        'PBC'  => '中国人民银行',
        'ICBC' => '中国工商银行',
        'BCM'  => '交通银行',
        'CCB'  => '中信银行',
        'CMB'  => '招商银行',
        'CEB'  => '光大银行',
        'GDB'  => '广东发展银行',
        'SDB'  => '深圳发展银行',
        'BOB'  => '北京银行',
        'CDB'  => '国家开发银行',
        'SPDB' => '浦东发展银行',
        'HSBC' => '汇丰银行',
        'HXB'  => '华夏银行'
    ],
    'oss_url' => 'http://img.ht16688.com/',
    
    'withdraw_min_money' => 100,//单笔提现最高金额,单位元
    'withdraw_max_money' => 50000,//单笔提现最高金额
    'withdraw_day_times' => 5//当日提现次数
];
