<?php
namespace common\models;
use Yii;
class BankOrder extends Base
{
     
    static $field_title = [
        'type' => ['1' => '审核中', '2' => '拒绝','3' => '成功'],
    
    ];
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'live_bank_order';
    }
     
}