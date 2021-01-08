<?php
namespace common\models;
use Yii;
class Bank extends Base
{
   
    /**
     * {@inheritdoc}
    */
    public static function tableName()
    {
        return 'live_bank';
    }
     
}