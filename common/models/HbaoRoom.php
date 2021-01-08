<?php
namespace common\models;
use Yii;
class HbaoRoom extends Base
{
    static $field_title = [
        'type' => ['0' => '不显示', '1' => '显示']
    ];
    /**
     * {@inheritdoc}
    */
    public static function tableName()
    {
        return 'hbao_room';
    }
     
}
