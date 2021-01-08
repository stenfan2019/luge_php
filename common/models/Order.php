<?php
namespace common\models;
use Yii;
class Order extends Base
{
    static $field_title = [
        'pay_status' => ['0' => '未支付', '1' => '已支付'],
    ];

    /**
     * {@inheritdoc}
    */
    public static function tableName()
    {
        return 'live_order';
    }
}