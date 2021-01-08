<?php
namespace console\controllers;

use Yii;
use yii\console\Controller;
use common\models\HbaoPacket;
use common\models\User;
use common\models\UserFundsDeal;

/**
 * 定时脚本，未抢红包退回脚本
 * @author stenfan
 *  php yii hbaorecycle 
 */
class HbaorecycleController extends Controller
{
    public function actionIndex(array $args=[]) 
    {
        ini_set('date.timezone','Asia/Shanghai');
        echo "=====红包过期脚本start======\n";
        $date = date('Y-m-d H:i:s');
        $list = HbaoPacket::find()
              ->where("type = 1 and invalid_date <= '{$date}'")
              ->orderBy('id asc')
              ->asArray()->all();
        foreach ($list as $item){
            if($item['draw_num'] < $item['number']){
                $money = $item['money'];
                $lose_money = $item['lose_money'];
                $return_money = $money - $lose_money;
                $uid  = $item['user_id'];
                $id   = $item['id'];
                $memo = "红包退回『{$id}』";
                User::balance($uid,$return_money,UserFundsDeal::I_HBAO_RECYCLE,$memo);
                HbaoPacket::updateAll(
                    ['return_money' => $return_money,'type' => 2],
                    ['id' => $id]);
               
            }
           
        }
        echo "=====红包过期脚本end======\n";
    }
}