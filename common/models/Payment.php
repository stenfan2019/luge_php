<?php 
namespace common\models;
use Yii;
class Payment extends Base
{
    static $field_title = [
        'type' => ['1' => '任意金额', '2' => '固定金额'],
        'is_show' => ['1' => '显示', '0' => '隐藏'],
        'cate'    => [
            'unionpay'   => '银行转账',
            'alipay'     => '支付宝',
            'wxpay'      => '微信支付',
            'cloudpay'   => '云闪付',
            'bitcoin'    => '比特币',
            'alibankpay' => '宝转卡',
            'wxbnakpay'  => '微信转卡',
            'telepay'    => '固话充值',
            'cardpay'    => '充值卡'
        ], 
    ];
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'live_payment';
    }
     
}