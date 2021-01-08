<?php
namespace api\controllers;

use api\controllers\Base;
use Yii;
use common\models\LotteryOdds;
use common\models\LotteryNumber;
use common\models\User;
use common\models\Lottery;
use common\models\UserFundsDeal;
use common\models\AnchorFundsDeal;
use common\models\Room;
use common\models\SendPrize;
use yii\base\Exception;
use common\models\Anchor;
use yii\base\BaseObject;

class GameController extends Base
{
    
    /**
     * 
     * 单个游戏玩法
     */
    public function actionGettype($id)
    {
        $data = [];
        $odds = LotteryOdds::find()
              ->where(['lottery_id' => $id,'status' => 1])
              ->orderBy('id ASC')
              ->asArray()->all();
        foreach ($odds as $key=>$item){
            $cate_id = $item['cate_id'];
            $cate_name = $item['cate_name'];
            $data[$cate_id]['cate_id'] = $cate_id;
            $data[$cate_id]['cate_name'] = $cate_name;
            unset($item['cate_id'],$item['cate_name']);
            //$item['min_bet'] = sprintf("%.2f",$item['min_bet'] / 100);
           // $item['max_bet'] = sprintf("%.2f",$item['max_bet'] / 100);
            //$item['one_bet'] = sprintf("%.2f",$item['one_bet'] / 100);
            $data[$cate_id]['odds'][] = $item;  
            
        }
        
        $this->success($data);
    }
    
    //获取开奖历史
    public function actionHistory()
    {
        $data = [];
        $lotterys = Lottery::find()
                   ->where(['status' => 1])->orderBy('sort ASC')->asArray()->all();
      
        $LN = new LotteryNumber();
        foreach ($lotterys as $lottery){
            $pid = $lottery['id'];
            $item = $LN->getLotteryHistory($pid);
            if($item){
                $data[] = $item;
            }
        }
        $this->success($data);
    }
    //获取开奖历史
    public function actionGetonehistory($pid)
    {
        $LN = new LotteryNumber();
        $data = $LN->getLotteryOneHistory($pid);
        $this->success($data);
    }
    
    //彩票投注
    public function actionLotterybet()
    {
        $data = Yii::$app->request->post();
        $lottery_id = intval($data['lottery_id']);
        $odds_id = intval($data['odds_id']);
        $times  = intval($data['times']);
        $total  = intval($data['total']);
        $room_id  = intval($data['room_id']);
        $lottery_number  = trim($data['lottery_number']);
        if(empty($lottery_id) || empty($odds_id) || empty($room_id) || 
                        empty($times) || empty($total) || empty($lottery_number)){
            return $this->error('缺少必要参数');
        }
       
        $info = $this->userInfo;
        $user_id = $info['uid'];
        
        //判断彩票是否停售
        $lottery_model = Lottery::findOne($lottery_id);
        if(empty($lottery_model)){
            return $this->error('当前彩种不存在');
        }
       
        //彩期验证
        $time = time();
       // echo date('Y-m-d H:i:s',$time);
        $lottery_number_model = LotteryNumber::findOne(['lottery_number'=>$lottery_number]);
        $envelop_time = strtotime($lottery_number_model->envelop_time);
        $end_time = strtotime($lottery_number_model->end_time);
        if($lottery_number_model->pid != $lottery_id){
            return $this->error('参数不匹配');
        }
        
        if($end_time <= $time){
            return $this->error('当前彩期已经结束,不能购买');
        }
        if($lottery_number_model->state > 2){
            return $this->error('彩期已经开奖不能购买');
        }
      
        
        if($envelop_time < $time){
            return $this->error('当前彩期已经封盘,不能下单');
        }
       // print_r($lottery_number_model->toArray());
        //exit;
        
        if($lottery_number_model->state == 1){
            $lottery_number_model->state = 2;
            $lottery_number_model->update();
        }
       
        //玩法
        $lottery_odds_model = LotteryOdds::findOne($odds_id);
        $true_total = $lottery_odds_model->one_bet * $times;
        if($true_total != $total){
            return $this->error('金额参数不匹配');
        }
        
        //查询用户余额
        $user_model = User::findOne($user_id);
        $amount = $user_model->amount;
        if($amount < $true_total){
            return $this->error('账号余额不足');
        }
        //直播间信息
        $room_model = Room::findOne($room_id);
        if(empty($room_model)){
            return $this->error('直播间不存在');
        }
        $anchor_id = $room_model->anchor_id;
        
        
        
        $anchor_allot = Yii::$app->params['anchor_allot'];
        $order_number = $this->_createOrderNumber();
        $date = date('Y-m-d H:i:s',$time);
        $earn_money = $lottery_odds_model->odds * 100 * $times;
        $rebet_money = round($true_total * $anchor_allot);
        $lose_earn = $earn_money - $true_total;
        //开启事务
        $transaction = Yii::$app->db->beginTransaction();
        try {
            //插入注单信息
            $sendPrize = new SendPrize();
            $sendPrize->user_id = $user_id;
            $sendPrize->room_id = $room_id;
            $sendPrize->lottery_id = $lottery_id;
            $sendPrize->lottery_number = $lottery_number;
            $sendPrize->order_number = $order_number;
            $sendPrize->odds_id = $odds_id;
            $sendPrize->anchor_id = $anchor_id;
            $sendPrize->pay_money = $true_total;
            $sendPrize->earn_money = $earn_money;
            $sendPrize->money = $earn_money;
            $sendPrize->rebet = $anchor_allot * 100;
            $sendPrize->rebet_money = $rebet_money;
            $sendPrize->lose_earn = $lose_earn;
            $sendPrize->state = 'pending';
            $sendPrize->status = 1;
            $sendPrize->created = $date;
            $sendPrize->updated = $date;
            $sendPrize->save();
            
            //用户扣费
            $balance = $amount-$true_total;
            $user_model->amount = $balance;
            $user_model->give_game = $user_model->give_game + $true_total;
            $user_model->update_time = time(); //金额更新时间
            $user_model->update();
            
            //生成用户扣费记录
            $lottery_title = $lottery_model->name;
            $odds_title = $lottery_odds_model->name;
            $memo = "注单『{$lottery_title}-{$odds_title} x {$times}』";
            $userFundsDeal = new UserFundsDeal();
            $userFundsDeal->uid = $user_id;
            $userFundsDeal->deal_number = $order_number;
            $userFundsDeal->deal_type = $userFundsDeal::O_LOTTERY_BET;
            $userFundsDeal->deal_money = $true_total;
            $userFundsDeal->deal_category = 2;
            $userFundsDeal->balance = $balance;
            $userFundsDeal->memo = $memo;
            $userFundsDeal->create_time = $date;
            $userFundsDeal->status = 1;
            $userFundsDeal->save();
            
            //主播提成
            if($rebet_money > 0){
                $anchor_model = Anchor::findOne($anchor_id);
                $anchor_balance = $anchor_model->amount + $rebet_money;
                $anchor_model->income_game = $anchor_model->income_game + $rebet_money;
                $anchor_model->amount = $anchor_balance;
                $anchor_model->update();
                
                //收益记录
                $anchorFundsDeal = new AnchorFundsDeal();
                $anchorFundsDeal->anchor_id = $anchor_id;
                $anchorFundsDeal->deal_number = $order_number;
                $anchorFundsDeal->deal_type = $anchorFundsDeal::I_AGENT_INCOME;
                $anchorFundsDeal->deal_money = $rebet_money;
                $anchorFundsDeal->deal_category = 1;
                $anchorFundsDeal->balance = $anchor_balance;
                $anchorFundsDeal->memo = $memo;
                $anchorFundsDeal->create_time = $date;
                $anchorFundsDeal->status = 1;
                $anchorFundsDeal->save();
                
                $transaction->commit();
                $user_info = $user_model->toArray();
                $user_info['amount'] = $balance;
                $user_info['give_game'] = $user_model->give_game + $true_total;
               
                $user_info = $this->cleanUserinfo($user_info);
              
                $this->success($user_info);
            }
            
        }catch (Exception $e) {
            $error = $e->getMessage();  //获取抛出的错误
            $transaction->rollBack();
           
            return $this->error($error);
        }
        
    }
    
    public function actionGetbet()
    {
        $room_id = Yii::$app->request->get('room_id',0);
        $lottery_id = Yii::$app->request->get('lottery_id',0);
        $state  = Yii::$app->request->get('state','all');
        $page = Yii::$app->request->get('page',1);
        $page = $page - 1 ? $page - 1 : 0;
        $limit = Yii::$app->request->get('limit',20);
        $userinfo = $this->userInfo;
        $uid = $userinfo['uid'];
       
        $where = "S.status=1 AND S.user_id=$uid";
        if($room_id){
            $where = $where . " AND S.room_id=$room_id";
        }
        
        if($lottery_id){
            $where = $where . " AND S.lottery_id=$lottery_id";
        }
        
        if('all' != $state){
            $where = $where . " AND S.state='{$state}'";
        }
       
        
        
        $select = ['S.lottery_number','S.lottery_id','S.order_number',
                   'S.pay_money','S.money','O.name as odds_name','S.odds_id',
                   'L.name as lottery_name','S.created as date','S.state'];
        $sendPrize = new SendPrize();
        $res = $sendPrize->getBetLog($where,$select,$page,$limit);
        $data = $this->_apiPage($res['data'], $res['pagination'],$limit,$page);
        foreach ($data['list'] as $key=>$item){
            $data['list'][$key]['pay_money'] =  sprintf("%.2f",$data['list'][$key]['pay_money'] / 100);
            $data['list'][$key]['money'] =  sprintf("%.2f",$data['list'][$key]['money'] / 100);
        }
        return $this->success($data);
    }
    
    //获取彩种的彩期
    public function actionLotterynumber($pid)
    {
        $LN = new LotteryNumber();
        $data = $LN->getSellLotteryNumber($pid);
        $this->success($data);
    }
    
    //游戏中心的游戏列表：
    public function actionGetlist()
    {
        $data = \common\models\Lottery::find()
             ->where(['status' => 1,'is_index'=>1])->orderBy('sort ASC')->asArray()->all();
        $oss_url = Yii::$app->params['oss_url'];
        foreach ($data as $key=>$item){
            $data[$key]['icon_url'] = $oss_url . $data[$key]['icon_url'];
        }
        $this->success($data);
        
    }
    
    
}