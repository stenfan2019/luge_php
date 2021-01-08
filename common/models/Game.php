<?php
namespace common\models;

use Yii;

class Game extends Base
{
    static $field_title = [
        'show_on' => ['0' => '不显示', '1' => '显示'],
        'type'    => ['hbao' => '红包游戏','lottery' => '彩票游戏','third' => '三方游戏']
    ];
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%game}}';
    }

   
}
