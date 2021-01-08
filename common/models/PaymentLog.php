<?php
namespace common\models;

use Yii;
class PaymentLog extends Base
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'live_payment_log';
    }
}