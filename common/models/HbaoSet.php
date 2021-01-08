<?php
namespace common\models;

use Yii;

class HbaoSet extends Base
{
     
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hbao_set';
    }
    
    public static function getOdds($num,$mine_num)
    {
        $one = self::findOne(1000);
        $odds = 0;
        if(1 == $mine_num){
            switch ($num){
                case 7:
                    $odds = $one->one7;
                    break;
                case 9:
                    $odds = $one->one9;
                    break;
                default:
                    $odds = 0;
                    break;
            }
        }else{
            switch ($mine_num){
                case 2:
                    $odds = $one->nine2;
                    break;
                case 3:
                    $odds = $one->nine3;
                    break;
                case 4:
                    $odds = $one->nine4;
                    break;
                case 5:
                    $odds = $one->nine5;
                    break;
                default:
                    $odds = 0;
                    break;
            }
        }
        return $odds;
    }
     
}