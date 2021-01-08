<?php
namespace common\models;
use Yii;
class PaymentChannel extends Base
{
    static $field_title = [
        'type' => ['1' => '任意金额', '2' => '固定金额','3' => '范围金额'],
        'is_show' => ['1' => '显示', '0' => '隐藏']
    ];

    /**
     * {@inheritdoc}
    */
    public static function tableName()
    {
        return 'live_payment_channel';
    }
     
    
}