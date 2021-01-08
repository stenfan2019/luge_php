<?php
namespace console\controllers;

use Yii;
use yii\console\Controller;
use common\models\Lottery;
use common\models\LotteryNumber;
use common\models\SendPrize;
use common\models\UserFundsDeal;
use common\models\User;
use common\models\lottery\Lwfks;
use common\models\lottery\Lyfks;
use common\models\lottery\Lsfks;
use yii\base\Exception;

/**
 * 开奖派彩脚本
 * @author stenfan
 * @do php yii sendprize 100 
 */
class SendprizeController extends Controller
{
    public function actionIndex()
    {
        $list = LotteryNumber::open("",5); //开奖
        if($list)
            foreach ($list as $l)
                echo SendPrize::sendPrize($l['pid'],$l['lottery_number']); //派彩

        die;



        ini_set('date.timezone','Asia/Shanghai');
        echo "=====开始派彩======\n";
        $pid = intval($args[0]);
        $lottery_model = Lottery::findOne($pid);
        $lottery_title = $lottery_model->name;
        if(empty($lottery_model)){
            echo "===彩票不存在====\n";
        }else{
            $lottery_num =  array_key_exists(1, $args) ? $args[1] : '';
            $date  = date('Y-m-d H:i:s');
            
            $where = ['pid' => $pid,'state' => [1,2]];
            if($lottery_num){
                $where['lottery_number'] = $lottery_num;
            }
           
            //获取一条可以开奖的记录
            $items = LotteryNumber::find()
                   ->where($where)
                   ->andWhere(['and',"end_time<='{$date}'"])
                   ->orderBy('end_time DESC')
                   ->limit(1)->one();
           
            if($items){
                $lottery_code = strtolower($items->lottery_code);
                $lottery_number = $items->lottery_number;
                echo "=====开奖彩期{$lottery_number}====\n";
                //生成一组开奖号码
                $fn = "C$lottery_code";
                $lfn = "L$lottery_code";
                
                $period_code = $this->$fn();
                echo "=====开奖号码为{$period_code}=====\n";
                //进行派奖操作
               
                $where = "lottery_number=$lottery_number and lottery_id=$pid";
                $send_prize = SendPrize::find()->where($where)->asArray()->all();
                $transaction = Yii::$app->db->beginTransaction();
                try {
                    if($send_prize){
                       foreach ($send_prize as $item){
                           $odds_id = $item['odds_id'];
                           if($this->$lfn($period_code,$odds_id)){
                               $state = 'win';
                               //
                               $user_model = User::findOne($item['user_id']);
                               $amount = $user_model->amount;
                               //中奖了,生成中奖记录
                               $balance = $amount + $item['earn_money'];
                              
                               $memo = "派彩『{$lottery_title}-{$lottery_number}』";
                               $userFundsDeal = new UserFundsDeal();
                               $userFundsDeal->uid = $item['user_id'];
                               $userFundsDeal->deal_number = $item['order_number'];
                               $userFundsDeal->deal_type = $userFundsDeal::I_LOTTERY_WIN;
                               $userFundsDeal->deal_money = $item['earn_money'];
                               $userFundsDeal->deal_category = 1;
                               $userFundsDeal->balance = $balance;
                               $userFundsDeal->memo = $memo;
                               $userFundsDeal->create_time = $date;
                               $userFundsDeal->status = 1;
                               $userFundsDeal->save();
                               
                               //修改用户金额
                               $user_model->amount = $balance;
                               //$user_model->give_game = $user_model->give_game + $true_total;
                               $user_model->update();
                           }else{
                               $state = 'lose';
                              
                           }
                           //修改派奖记录
                           $one = SendPrize::findOne($item['id']);
                           $one->state = $state;
                           $one->updated = $date;
                           $one->update();
                           echo "====$state===\n";
                       }
                    }
                    //修改当前彩期
                    $items->period_code = $period_code;
                    $items->state=3;
                    $items->n1 = substr($period_code, 0,1);
                    $items->n2 = substr($period_code, 1,1);
                    $items->n3 = substr($period_code, 2,1);
                    $items->n4 = substr($period_code, 3,1);
                    $items->n5 = substr($period_code, 4,1);
                    $items->n6 = substr($period_code, 5,1);
                    $items->n7 = substr($period_code, 6,1);
                    $items->n8 = substr($period_code, 7,1);
                    $items->n9 = substr($period_code, 8,1);
                    $items->n10 = substr($period_code, 9,1);
                    $items->update();
                    $transaction->commit();
                }catch (Exception $e) {
                    $error = $e->getMessage();
                    $transaction->rollBack();
                    $items->period_code = $period_code;
                    $items->state=4;
                    $items->n1 = substr($period_code, 0,1);
                    $items->n2 = substr($period_code, 1,1);
                    $items->n3 = substr($period_code, 2,1);
                    $items->n4 = substr($period_code, 3,1);
                    $items->n5 = substr($period_code, 4,1);
                    $items->n6 = substr($period_code, 5,1);
                    $items->n7 = substr($period_code, 6,1);
                    $items->n8 = substr($period_code, 7,1);
                    $items->n9 = substr($period_code, 8,1);
                    $items->n10 = substr($period_code, 9,1);
                    $items->update();
                    echo "=====系统错误$error=====\n";
                }
                
            }else{
                echo "=====暂无开奖彩期=====\n";
            }
        }
        echo "=====结束派彩======\n";
       
    }
    
    //一分快三开奖号
    protected function Cyfks()
    {
        return $this->_getKuai3Number();
    }
    
    //五分快三开奖号
    protected function Cwfks()
    {
        return $this->_getKuai3Number();
    }
    
    //三分快三开奖号
    protected function Csfks()
    {
        return $this->_getKuai3Number();
    }
    
    //
    protected function Lyfks($period_code,$odds_id){
        $odds_base = new Lyfks($period_code, $odds_id);
        return $odds_base->is_win;
    }
    
    protected function Lwfks($period_code,$odds_id){
        $odds_base = new Lwfks($period_code, $odds_id);
        return $odds_base->is_win;
    }
    
    protected function Lsfks($period_code,$odds_id){
        $odds_base = new Lsfks($period_code, $odds_id);
        return $odds_base->is_win;
    }
    
    //开出一组快三开奖号
    protected function _getKuai3Number()
    {
        $n1 = mt_rand(1, 6);
        $n2 = mt_rand(1, 6);
        $n3 = mt_rand(1, 6);
        return "{$n1}{$n2}{$n3}";
    }
    
    
}