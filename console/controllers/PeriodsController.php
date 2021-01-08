<?php
namespace console\controllers;

use Yii;
use yii\console\Controller;
use common\models\Lottery;
use common\models\LotteryNumber;

/**
 * 定时生成彩期脚本
 * @author stenfan
 *  php yii periods 100
 */
class PeriodsController extends Controller
{
    /**
     * 私彩生成彩期
     * @param array $args
     * @do php yii periods 100
     */
    public function actionIndex(array $args=[]) {
        ini_set('date.timezone','Asia/Shanghai');
        echo "=====开始生成彩期======\n";
        $pid = intval($args[0]);
        $row = Lottery::findOne($pid);
        $date = array_key_exists(1, $args) ? $args[1] : date('Y-m-d H:i:59');
        $start_time = strtotime($date);
        $t0 = $start_time - strtotime(date('Y-m-d'));
        if(empty($row)){
            echo "===彩票不存在====\n";
        }else{
            $row = $row->toArray();
            $period_time = $row['period_time'];
            $totoal =  (86400 -$t0)  / $period_time;
            $totoal = floor($totoal);
            $envelop_time = $row['envelop_time'];
            $n1 = (string) date('ymd',$start_time);
            $number = "{$n1}00{$pid}";
            for($i=0;$i<$totoal;$i++){
                $n =(string)  str_pad($i,4,"0",STR_PAD_LEFT); 
                $st = date('Y-m-d H:i:s',$start_time + $period_time * $i);
                $lotteyNumber = new LotteryNumber();
                $lotteyNumber->pid = $pid;
                $lotteyNumber->lottery_code = $row['code'];
                $lotteyNumber->lottery_name = $row['name'];
                $lotteyNumber->lottery_number = "{$number}{$n}";
                $lotteyNumber->type = $row['type'];
                $lotteyNumber->start_time = date('Y-m-d H:i:s',$start_time + $period_time * $i);
                $lotteyNumber->end_time = date('Y-m-d H:i:s',$start_time + $period_time * ($i+1));
                $lotteyNumber->envelop_time = date('Y-m-d H:i:s',$start_time + $period_time * ($i+1)-$envelop_time);
                $lotteyNumber->period_code = '';
                $lotteyNumber->state = 1;
                $lotteyNumber->status = 1;
                $lotteyNumber->save();
            }
        }
        echo "=====结束生成彩期======\n";
    }
}