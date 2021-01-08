<?php
namespace common\models;

use Yii;

class Gift extends Base
{
    static $field_title = [
        'show_on' => ['0' => '不显示', '1' => '显示']
    ];
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%gift}}';
    }

   
}
