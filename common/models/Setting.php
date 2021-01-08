<?php
namespace common\models;

use Yii;

class Setting extends Base
{
    
    const USER_ID = 10000;
    
    const ANCHOR_ID = 20000;
    /**
     * {@inheritdoc}
    */
    public static function tableName()
    {
        return '{{%set}}';
    }

     
}
