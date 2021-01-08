<?php
namespace api\controllers;
use Yii;
use common\models\HbaoRoom;
use api\controllers\Base;
use common\models\User;
use common\models\HbaoPacket;
use common\models\HbaoPacketSub;
use common\models\UserFundsDeal;
use yii\data\Pagination;
use GatewayClient\Gateway;
use GatewayClient;

//Gateway::$registerAddress = '18.166.30.188:1236';

class HbaoController extends Base
{
   
    /**
     * 获取红包房间列表
     * 
     */
    public function actionGetroom()
    {
        $data = HbaoRoom::find()
              ->select('id,name,start_money,end_money,limited_money,sort,life_time')
              ->where("type=1")->asArray()->all();
        $this->success($data);
    }
    
    /**
     * 发红包
     */
    public function actionSend()
    {
        $data = Yii::$app->request->post();
        if(!isset($data['room_id']) || !isset($data['amount']) || !isset($data['num']) || !isset($data['mine'])){
            return $this->error('缺少必要参数');
        }
       
        $amount = intval($data['amount']) * 100;
        $num    = $data['num'];
        $mine   = $data['mine'];
        $mine   = strlen($mine) == 1 ? [$mine] : explode(',', $mine);
        if(count($mine) == 1 && !in_array($num, [7,9])){
            return $this->error('设置错误');
        }
        
        if(count($mine) > 1 && $num != 9){
            return $this->error('设置错误');
        }
        
        $room_model = HbaoRoom::findOne($data['room_id']);
        if(empty($room_model)){
            return $this->error('房间不存在');
        }
        
        $start_money = $room_model->start_money * 100;
        
        $end_money   = $room_model->end_money * 100;
     
        if($amount < $start_money || $end_money < $amount){
            return $this->error('红包金额超出范围');
        }
      
       
        //判断金额
        $uid = $this->userInfo['uid'];
        $balance = User::balance($uid);
        if($balance < $amount){
            return $this->error('钱包余额不足');
        }
        
        $hbaoPacket = new HbaoPacket();
        
        //开始发红包
        $ip = $this->clientIP();
        $hbao_id = $hbaoPacket->sendPacket($room_model, $this->userInfo, $amount, $num,$mine,$ip);
        if($hbao_id){
            $data = $this->userInfo;
            $balance = User::balance($uid);
            $data['amount'] = sprintf("%.2f",$balance / 100);
            $data['hbao_id'] = $hbao_id;
            $time = time();
            $data['hbao_date'] = date('Y-m-d H:i:s',$time);
            $data['hbao_life_date'] = date('Y-m-d H:i:s',time() + $room_model->life_time);
            return $this->success($data);
        }
        return $this->error('发红包失败');
    }
    
    /**
     * 抢红包
     */
    public function actionRob($id)
    {
        $packet_model = HbaoPacket::findOne($id);
        if(empty($packet_model)){
            return $this->error('红包不在');
        }
        $time = time();
        $invalid_date = strtotime($packet_model->invalid_date);
        if($invalid_date < $time){
            return $this->error('红包过期了');
        }
        //检测红包是否抢完
        if(3 == $packet_model->type){
            return $this->error('红包抢完了');
        }
        //检测自己是否抢过红包
        $uid = $this->userInfo['uid'];
        $draw_user_ids = explode(',',$packet_model->draw_user_ids);
        if(in_array($uid, $draw_user_ids)){
            return $this->error('你已经抢过此红包了');
        }
        //余额是否足够赔率
        $balance = User::balance($uid);
        $earnest_money = floor($packet_model->money * $packet_model->odds / 100);
        if($balance < $earnest_money){
            return $this->error('保证金不足');
        }
        
        //取一条红包数据
        $packet_sub_model = HbaoPacketSub::find()
                          ->where("hbao_id=$id and user_id = 0")
                          ->orderBy('id asc')
                          ->limit(1)->one();
        $packet_sub_model->user_id = $uid;
        $packet_sub_model->user_name = $this->userInfo['username'];
        $packet_sub_model->draw_date = date('Y-m-d H:i:s',$time);
        $packet_sub_model->ip = $this->clientIP();
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
        $data = $this->userInfo;
        $balance = User::balance($uid);
        $data['amount'] = sprintf("%.2f",$balance / 100);
        $data['hbao_money'] = sprintf("%.2f",$return_money / 100);
        return $this->success($data);
    }
    
    /**
     * 单个红包详细
     * @param int $id
     */
    public function actionGetone($id)
    {
        $packet_model = HbaoPacket::findOne($id);
        if(empty($packet_model)){
            return $this->error('红包不在');
        }
        $amount = $packet_model->money ;//
       
        //
        $time = time();
        $data['list'] = HbaoPacketSub::find()
                      ->where("hbao_id=$id")
                      ->orderBy('id asc')
                      ->asArray()->all();
        $oss_url = Yii::$app->params['oss_url'];
        $draw_num = 0;
        foreach ($data['list'] as $key=>&$hbao){
            $invalid_date = strtotime($hbao['invalid_date']);
            $sub_amount = $hbao['amount'];
            unset($hbao['odds'],$hbao['fee'],$hbao['is_hit'],$hbao['is_die'],$hbao['ip']);
            $hbao['amount'] = sprintf("%.2f",$hbao['amount'] / 100);
            if($invalid_date > $time && $hbao['user_id'] < 1){
                unset($data['list'][$key]);
            }else{
                $amount = $amount-$sub_amount;
                if($hbao['user_id']){
                    $user_info  = User::findOne($hbao['user_id']);
                    $hbao['image'] = $oss_url .$user_info->image; 
                    $draw_num ++;
                }else{
                    $hbao['image'] = $oss_url .'avatar/B001.jpg';
                }
                
            }
            //红包未抢完、不展示手气最佳
            if($packet_model->draw_num != $packet_model->number){
                $hbao['is_good'] = 0;
            }
        }
        $info['amount'] = sprintf("%.2f",$amount / 100);;
        $info['number'] = $packet_model->number;
        $info['mine_str'] = $packet_model->mine_str;
        $info['user_id'] = $packet_model->user_id;
        $info['user_name'] = $packet_model->user_name;
        $user_info  = User::findOne($info['user_id']);
        $info['image'] = $oss_url .$user_info->image;
        $info['draw_num'] = $draw_num;
        $data['info'] = $info;
        
        return $this->success($data);
    }
    
    /**
     * 我发出去的红包
     * @author stenfan
     */
    public function actionMysend()
    {
        $uid = $this->userInfo['uid'];
        $data = Yii::$app->request->get('data');
        $page = Yii::$app->request->get('page',1);
        $limit = Yii::$app->request->get('limit',20);
        $query = HbaoPacket::find()
               ->where("user_id=$uid")
               ->select('odds,earn_money,return_money,money,mine_num,mine_str,created,id,number');
        $countQuery = clone $query;
        $count = $countQuery->count();
        $page_num = ceil($count / $limit);
        $pages = new Pagination(['totalCount' => $count,'defaultPageSize'=>$limit,'page'=>$page-1]);
        $models = $query->offset($pages->offset)
                ->orderBy('id desc')
                ->limit($limit)
                ->asArray()->all();
        foreach ($models as &$item){
            $item['earn_money'] = sprintf("%.2f",$item['earn_money'] / 100);
            $item['return_money'] = sprintf("%.2f",$item['return_money'] / 100);
            $item['odds'] = sprintf("%.2f",$item['odds'] / 100);
            $item['money'] = sprintf("%.2f",$item['money'] / 100);
        }
        $data = [
                'data'  => $models,
                'page'  => $page,
                'count' => $count,
                'limit' => $limit
        ];
       $this->success($data);
        
    }
    
    /**
     * 我抢到的红包
     * @author stenfan
     */
    public function actionMyrob()
    {
        $uid = $this->userInfo['uid'];
        $data = Yii::$app->request->get('data');
        $page = Yii::$app->request->get('page',1);
        $limit = Yii::$app->request->get('limit',20);
        $query = HbaoPacketSub::find()
                ->where("user_id=$uid")
                ->select('odds,amount,draw_date,is_mine,is_good,hbao_id,room_id,id,user_id');
        $countQuery = clone $query;
        $count = $countQuery->count();
        $page_num = ceil($count / $limit);
        $pages = new Pagination(['totalCount' => $count,'defaultPageSize'=>$limit,'page'=>$page-1]);
        $models = $query->offset($pages->offset)
                ->orderBy('id desc')
                ->limit($limit)
                ->asArray()->all();
        foreach ($models as &$item){
            $item['amount'] = sprintf("%.2f",$item['amount'] / 100);
            $item['odds'] = sprintf("%.2f",$item['odds'] / 100);
            $item['money'] = $item['amount'];
            if($item['is_mine']){
                $item['money'] = $item['amount'] * $item['odds'] * -1;
            }
        }
        $data = [
            'data'  => $models,
            'page'  => $page,
            'count' => $count,
            'limit' => $limit
        ];
        $this->success($data);
    
    }
    
    /**
     * 拉去直播间红包列表
     */
    public function actionList()
    {
        $uid = $this->userInfo['uid'];
        $room_id = Yii::$app->request->get('room_id');
        $date = date('Y-m-d H:i:s');
        $list = HbaoPacket::find()//
              ->select('created as hbao_date,mine_str as mine,
                  user_name as username,user_id as uid,odds,id as hbao_id,
                  money,invalid_date as hbao_life_date,draw_user_ids')
              ->where("room_id=$room_id and invalid_date > '{$date}'")
              ->orderBy('id asc')
              ->limit(10)
              ->asArray()->all();
        $oss_url = Yii::$app->params['oss_url'];
        foreach ($list as &$item){
            $item['odds'] = sprintf("%.2f",$item['odds'] / 100);
            $item['money'] = $item['money'] / 100;
            $user_info  = User::findOne($item['uid']);
            $avatar = '';
            if($user_info){
                $avatar = $oss_url .$user_info->image;
            }
            $item['image'] = $avatar;
            $draw_user_ids = explode(',',$item['draw_user_ids']);
            unset($item['draw_user_ids']);
            $is_draw = 'no';
            if(in_array($uid, $draw_user_ids)){
                $is_draw = 'yes';
            }
            $item['is_draw'] = $is_draw;
        }
        $this->success($list);
                    
    }
    
    /**
     * 测试发红包
     */
    /*public function actionTest()
    {
        $info = $this->userInfo;
        $uid = $info['uid'];
        $username = $info['username'];
        $image  = $info['image'];
        $data = [
               'roomId' => '1000',
               'userId' => $uid,
               'type'   => '2002',
               'content' => [
                   'room_id' => '1000',
                   'amount'  => '42434.94',
                   'mine'    => '8',
                   'num'     => '7',
                   'money'   => '11',
                   'uid'     => $uid,
                   'username' => $username,
                   'image'    => $image,
                   'hbao_id'  => '102851',
                   'hbao_date' => "2020-12-21 13:49:29",
                   'hbao_life_date' => '2020-12-21 13:54:29',
               ]
        ];
        $message = json_encode($data,true);
        Gateway::$registerAddress = '18.166.30.188:1236';
        
       
        Gateway::sendToAll($message);
       /* $client = stream_socket_client('tcp://18.166.30.188:1236');
        if(!$client)exit("can not connect");
        // 模拟超级用户，以文本协议发送数据，注意Text文本协议末尾有换行符（发送的数据中最好有能识别超级用户的字段），这样在Event.php中的onMessage方法中便能收到这个数据，然后做相应的处理即可
        $t = fwrite($client, $message);
        print_r($t);
        echo 'ddddd';*/
        
        
   // }
}