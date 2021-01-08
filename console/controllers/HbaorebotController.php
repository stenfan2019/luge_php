<?php
namespace console\controllers;

use Yii;
use yii\console\Controller;
use common\models\HbaoRoom;
use common\models\HbaoPacket;
use common\models\HbaoPacketSub;
use common\models\User;
use common\models\UserFundsDeal;
use GuzzleHttp\Client;
use yii\base\Exception;

/**
 * 机器人脚本
 * @author stenfan
 *  php yii hbaorebot
 */
class HbaorebotController extends Controller
{
    
   
    /**
     * 机器人发红包
     * @param array $args
     */
    public function actionSend(array $args=[]) {
        ini_set('date.timezone','Asia/Shanghai');
        echo "=====机器人发红包======\n";
        $room_id = intval($args[0]);
        $room_model = HbaoRoom::findOne($room_id);
        $oss_url = Yii::$app->params['oss_url'];
        
        if($room_model->robet_ids){
            while (true){
                $robet_ids = explode(',',$room_model->robet_ids);
                $robet_num = mt_rand(1, count($robet_ids));
                $key = array_rand($robet_ids,1);
                $uid = $robet_ids[$key];
                $ip = '127.0.0.1';
                $amount = mt_rand($room_model->start_money, $room_model->end_money);
                $amount = $amount * 100;
                $mine   = $this->createMine();
                $mine   = is_array($mine) ? $mine : [$mine];
                $n    = count($mine);
                $num    = 9;
                if($n == 1){
                    $a = [7,9];
                    $k = array_rand($a,1);
                    $num = $a[$k];
                }
                
                //判断房间是否对机器人设置机器人发红包杀率
                if($room_model->robet_send_odds){
                    $room_model->odds = $room_model->robet_send_odds;
                }
                $user_info = User::findOne($uid)->toArray();
              
                $hbaoPacket = new HbaoPacket();
                $hbao_id = $hbaoPacket->sendPacket($room_model, $user_info, $amount, $num,$mine,$ip);
                $this->sendHb($room_id, $user_info, $hbao_id, $room_model->life_time);
                //
                $seconds = mt_rand(10, 40);
                sleep($seconds);
            }
        }
        echo "=====机器人发红包end======\n";
        
    }
    
    /**
     * 机器人抢红包
     * @param array $args
     */
    public function actionRob(array $args=[])
    {
        ini_set('date.timezone','Asia/Shanghai');
        echo "=====机器人抢红包======\n";
        while (true){
            $room_id = intval($args[0]);
            $room_model = HbaoRoom::findOne($room_id);
            $oss_url = Yii::$app->params['oss_url'];
            if($room_model->robet_ids){
                $robet_ids = explode(',',$room_model->robet_ids);
                $robet_num = mt_rand(1, count($robet_ids));
                $key = array_rand($robet_ids,1);
                $uid = $robet_ids[$key];
                $limit = mt_rand(1, 5);
                //取出可抢的红包
                $time = time();
                $date = date('Y-m-d H:i:s',$time);
                $list = HbaoPacket::find()//
                      ->where("room_id=$room_id  and type=1 and invalid_date > '{$date}'
                               and !FIND_IN_SET($uid,draw_user_ids)")
                      ->orderBy('id asc')
                      ->limit($limit)
                      ->asArray()->all();
                foreach ($list as $item){
                    $id = $item['id'];
                    $packet_model = HbaoPacket::findOne($id);
                    //continue;
                    if($packet_model){
                        echo "=====红包{$id}=====\n";
                        $draw_user_ids = explode(',',$packet_model->draw_user_ids);
                        $user_info = User::findOne($uid)->toArray();
                        try {
                            //取一条红包数据
                            $packet_sub_model = HbaoPacketSub::find()
                                              ->where("hbao_id=$id and user_id = 0")
                                              ->orderBy('id asc')
                                              ->limit(1)->one();
                            if(empty($packet_sub_model)){
                                echo "=====红包为空跳出循环=====\n";
                                continue;
                            }
                            //检测有雷的红包是否丢弃
                            if($packet_sub_model->is_mine == 1){
                                $robet_rob_odds = $room_model->robet_rob_odds;
                                if($robet_rob_odds > 0){
                                    $i = mt_rand(0, 100);
                                    if($i <= $robet_rob_odds){
                                        echo "=====丢去红包{$id}=====\n";
                                        continue;
                                    }
                                }
                            }
                            $packet_sub_model->user_id = $uid;
                            $packet_sub_model->user_name = $user_info['username'];
                            //抢包时间不能太接近
                            $packet_sub_model->draw_date = date('Y-m-d H:i:s',$time-mt_rand(1, 10));
                            $packet_sub_model->ip = '127.0.0.1';
                            $packet_sub_model->update();
                            
                            //入账抢红包
                            $amount = $packet_sub_model->amount;
                            $return_money = $amount;
                            $memo = "抢红包『{$id}』";
                            $lose_money = $packet_model->lose_money + $amount;
                            $packet_model->lose_money = $lose_money;
                            User::balance($uid,$amount,UserFundsDeal::I_HBAO_ROB,$memo);
                            
                            //是否中雷
                            if($packet_sub_model->is_mine == 1){
                                $amount = $amount * ($packet_sub_model->odds / 100);
                                $amount = floor($amount);
                                $earn_money = $packet_model->earn_money + $amount;
                                $packet_model->earn_money = $earn_money;
                                $memo = "抢红包中雷『{$id}』";
                                //抢红包的人扣钱
                                User::balance($uid,-$amount,UserFundsDeal::O_HBAO_HIT,$memo);
                                //发红包的人加钱
                                $user_id = $packet_model->user_id;
                                $memo = "红包中雷派奖『{$id}』";
                                User::balance($user_id,$amount,UserFundsDeal::I_HBAO_WIN,$memo);
                            }
                            
                            $num = $packet_model->number;
                            $draw_num = $packet_model->draw_num + 1;
                            $packet_model->draw_num = $draw_num;
                            array_push($draw_user_ids, $uid);
                            $packet_model->draw_user_ids = join(',', $draw_user_ids);
                            if($num == $draw_num){
                                $packet_model->type = 3;
                            }
                            $packet_model->update();
                            //推送消息
                            if('127.0.0.1' != $item['ip']){
                                $this->robHb($room_id, $user_info, $item['user_id'], $id);
                            }
                        }catch (Exception $e) {
                            $error = $e->getMessage();
                            echo "=====系统错误$error=====\n";
                        }
                    }
                }
            }
            $seconds = mt_rand(1, 5);
            sleep($seconds);
        }
        echo "=====机器人抢红包end======\n";
    }
    
    public function actionTest()
    {
        $num = 9;
        $money = mt_rand(10, 30) * 100;
        $mine = $this->createMine();
        $mine = is_array($mine) ? $mine : [$mine];
        $hbao_list = $this->getHbaoEveryMoney($num, $money,false,$mine);
        echo array_sum($hbao_list) . PHP_EOL;
        print_r($hbao_list);
        $hbao_list = $this->getHbaoEveryMoney($num, $money,true,$mine);
        echo array_sum($hbao_list) . PHP_EOL;
        print_r($hbao_list);
    }
    
    protected function intoRoom($room_id,$uid,$username,$image)
    {
        $data = [
            'roomId'  => $room_id,
            'userId'  => $uid,
            'type'    => '2001',
            'content' => [
                'userid'    => $uid,
                'username'  => $username,
                'image'     => $image
            ]
        ];  
        $message = json_encode($data,true);
        $this->pushMessage(['message' => $message]);
    }
    
    /**
     * 抢红包发消息
     */
    protected function robHb($room_id,$user_info,$touid,$hbao_id)
    {
        $uid = $user_info['uid'];
        $username = $user_info['username'];
        $image = $user_info['image'];
        $data = [
            'roomId'  => $room_id,
            'userId'  => $uid,
            'type'    => '2003',
            'content' => [
                'userid'    => $touid,
                'username'  => $username,
                'image'     => $image,
                'hbao_id'   => $hbao_id
            ]
        ];
        $message = json_encode($data,true);
        $this->pushMessage(['message' => $message]);
    }
    
    protected function sendHb($room_id,$user_info,$hbao_id,$life_time)
    {
        $oss_url = Yii::$app->params['oss_url'];
        $image = $oss_url . $user_info['image'];
        $hbao_model = HbaoPacket::findOne($hbao_id);
        $hbao_life_date = date('Y-m-d H:i:s',time() + $life_time);
        $data  = [
            'roomId'  => $room_id,
            'userId'  => $user_info['uid'],
            'type'    => '2002',
            'content' => [
                'hbao_date'      => $hbao_model->created,
                'username'       => $user_info['username'],
                'image'          => $image,
                'mobile'         => $user_info['mobile'],
                'hbao_id'        => $hbao_id,
                'hbao_life_date' => $hbao_life_date,
                'mine'           => $hbao_model->mine_str,
                'num'            => $hbao_model->number,
                'amount'         => sprintf("%.2f",$user_info['amount'] / 100),
                'money'          => sprintf($hbao_model->money / 100)
            ],
            'user_info' => [
                'image'    => $image,
                'userid'   => $user_info['uid'],
                'username' => $user_info['username']
            ]
        ];
        $message = json_encode($data,true);
        $this->pushMessage(['message' => $message]);
    }
    
    protected function createMine()
    {
        $res = ['0','1','2','3','4','5','6','7','8','9'];
        $mine_num = mt_rand(1, 5);
        return array_rand($res,$mine_num);
    }
    
    protected function pushMessage($params)
    {
        $gatewayclient = Yii::$app->params['gatewayclient'];
        $client = new Client();
        $url = $gatewayclient . '/hbao.php';
        $ch = curl_init ();
        curl_setopt ( $ch, CURLOPT_URL, $url );
        curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt ( $ch, CURLOPT_CUSTOMREQUEST, 'POST' );
        curl_setopt ( $ch, CURLOPT_POSTFIELDS, $params );
        curl_setopt ( $ch, CURLOPT_TIMEOUT, 60 );
        $result = curl_exec ( $ch );
        curl_close ( $ch );
        return $result;
    } 
    
    //通过大红包生成小红包
    protected function getHbaoEveryMoney($num,$money,$hit=false,$mine=[])
    {
        $min = 1;
        $max = $money - $num * $min;
        $avg = ceil($money / $num);
        if(false == $hit){
            $return  = [];
            for($i=1;$i<$num;$i++){
                $hit1     = mt_rand($avg-20,$avg+20) / 1000;
                $n        = ceil($max * $hit1);
                $m        = $this->creatMoney($min,$n);
                $return[] = $m;
                $max      = $max - $m;
            }
            $return[] = $money - array_sum($return);
            return $return;
        }else{
            $return  = [];
            for($i=1;$i<$num;$i++){
                $hit1      = mt_rand($avg-10,$avg+10) / 1000;
                $n        = ceil($max * $hit1);
                $m        = $this->creatMoney($min,$n);
                if($mine){
                    $j = array_pop($mine);
                    if(strlen($m) == 1){
                        $m = $j;
                    }else{
                        $m = substr($m,0,-1) * 10 + $j;
                    }
                }
                $return[] = $m;
                $max      = $max - $m;
            }
            $return[] = $money - array_sum($return);
            return $return;
        }
    
    }
    
   
    
    //生成一个小红包金额
    protected function creatMoney($min,$money)
    {
        return mt_rand($min,$money);
    }
    
   
}