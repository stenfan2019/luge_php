<?php
namespace api\controllers;

use api\controllers\Base;
use common\models\Gift;
use Yii;
use common\models\Room;
use common\models\GiftRecord;
use common\models\Anchor;
use common\models\User;
use common\models\UserFundsDeal;
use common\models\AnchorFundsDeal;
use yii\base\Exception;

class GiftController extends Base
{
    //礼物列表
    public function actionList()
    {
       $list = Gift::find()->where("show_on=1 and status=1")->asArray()->all();
       $tmp = [];
       $oss_url = Yii::$app->params['oss_url'];
       foreach ($list as $item){
           $arr = array(
               'id'          => $item['id'],
               'title'       => $item['title'],
               'image_mall'  => $oss_url . $item['image_mall'],
               'image_big'   => $oss_url . $item['image_big'],
               'price'       => sprintf("%.2f",$item['price'] / 100),
           );
           $tmp[] = $arr;
       }
       $this->success($tmp);
    }
    
    //赠送礼物
    public function actionSendout()
    {
        $data = Yii::$app->request->post();
        $room_id = intval($data['room_id']);
        $gift_id = intval($data['gift_id']);
        $number  = intval($data['number']);
        $info = $this->userInfo;
       
        $user_id = $info['uid'];
        $number  = abs($number);
        if(empty($room_id) || empty($gift_id) || empty($number)){
            return $this->error('缺少必要参数');
        }
        //检测直播间信息
        $room_info = Room::findOne($room_id);
        if(empty($room_info)){
            return $this->error('直播间不存在');
        }
        $room_info = $room_info->toArray();
      
        //检测礼物信息
        $gift_info = Gift::findOne($gift_id);
        if(empty($gift_info)){
            return $this->error('礼物不存在');
        }
        $gift_info = $gift_info->toArray();
        $gift_title = $gift_info['title'];
        
        //主播信息
        $anchor_id = $room_info['anchor_id'];
        $anchor_model = Anchor::findOne($anchor_id);
        if(empty($anchor_model)){
            return $this->error('主播不存在');
        }
        $anchor_info = $anchor_model->toArray();
        
        $gift_total = $gift_info['price'] * $number;
        $rate = (1 - $gift_info['platform_harvest'] / 100);
        $user_total = $gift_info['price'] * $number;
        $anchor_total = floor($gift_total * $rate);
        $date = date('Y-m-d H:i:s');
        
        //查询用户余额
        $user_model = User::findOne($user_id);
        $amount = $user_model->amount;
        if($amount < $user_total){
            return $this->error('账号余额不足');
        }
        
        $user_info = $this->cleanUserinfo($user_model->toArray());
       
        //开启事务
        $transaction = Yii::$app->db->beginTransaction();
        try {
            //用户扣费
            $balance = $amount-$user_total;
            $user_model->amount = $balance;
            $user_model->give_gift = $user_model->give_gift + $gift_total;
            $user_model->update_time = time(); //金额更新时间
            $user_model->update();
            
            //扣费记录
            $memo = "打赏『{$gift_title} x {$number}』";
            $deal_number   = date('YmdHis');
            $userFundsDeal = new UserFundsDeal();
            $userFundsDeal->uid = $user_id;
            $userFundsDeal->deal_number = $deal_number;
            $userFundsDeal->deal_type = $userFundsDeal::O_ANCHOR_GIVE;
            $userFundsDeal->deal_money = $user_total;
            $userFundsDeal->deal_category = 2;
            $userFundsDeal->balance = $balance;
            $userFundsDeal->memo = $memo;
            $userFundsDeal->create_time = $date;
            $userFundsDeal->status = 1;
            $userFundsDeal->save();
            
            //主播加收益
            $anchor_balance = $anchor_model->amount + $anchor_total;
            $anchor_model->income_gift = $anchor_model->income_gift + $anchor_total;
            $anchor_model->amount = $anchor_balance;
            $anchor_model->update();
            
            //收益记录
            $anchorFundsDeal = new AnchorFundsDeal();
            $anchorFundsDeal->anchor_id = $anchor_id;
            $anchorFundsDeal->deal_number = $deal_number;
            $anchorFundsDeal->deal_type = $anchorFundsDeal::I_GIFT_GIVE;
            $anchorFundsDeal->deal_money = $anchor_total;
            $anchorFundsDeal->deal_category = 1;
            $anchorFundsDeal->balance = $anchor_balance;
            $anchorFundsDeal->memo = $memo;
            $anchorFundsDeal->create_time = $date;
            $anchorFundsDeal->status = 1;
            $anchorFundsDeal->save();
            
            //加入礼物列表
            $giftModel = new GiftRecord();
            $giftModel->gift_id = $gift_id;
            $giftModel->gift_title = $gift_info['title'];
            $giftModel->number = $number;
            $giftModel->gift_total = $gift_total;
            $giftModel->room_id = $room_id;
            $giftModel->anchor_id = $anchor_id;
            $giftModel->rate = $rate;
            $giftModel->anchor_total = $anchor_total;
            $giftModel->user_id = $user_id;
            $giftModel->user_total = $user_total;
            $giftModel->create_time = $date;
            $giftModel->status = 1;
            $giftModel->save();
            
            //
            $transaction->commit();
            $user_info['amount'] = $balance;
            $user_info['give_gift'] = $user_model->give_gift + $gift_total;
            $user_info = $this->cleanUserinfo($user_info);
            $this->success($user_info);
        }catch (Exception $e) {
            $error = $e->getMessage();  //获取抛出的错误
            $transaction->rollBack();
            return $this->error($error);
        }
        
        //触发升级
        
        return $this->success([]);
    }
    
    //用户礼物送出记录
    public function actionRecord()
    {
        $page = Yii::$app->request->get('page',1);
        $page = $page - 1 ? $page - 1 : 0;
        $limit = Yii::$app->request->get('limit',20);
        $userinfo = $this->userInfo;
        $uid = $userinfo['uid'];
       
        $giftModel = new GiftRecord();
        $select = ['R.gift_title','R.gift_id','R.number','R.create_time','G.image_mall'];
        $res = $giftModel->getUserGiftList($uid,$select,$page,$limit);
        $data = $this->_apiPage($res['data'], $res['pagination'],$limit,$page);
        $oss_url = Yii::$app->params['oss_url'];
        foreach ($data['list'] as $key=>$item){
            $data['list'][$key]['image_mall'] = $oss_url . $data['list'][$key]['image_mall'];
        }
        return $this->success($data);
    }
}