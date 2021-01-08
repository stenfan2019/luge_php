<?php
namespace api\controllers;

use api\controllers\Base;
use common\models\Payment;
use common\models\Bank;
use common\models\BankAccount;
use common\models\BankOrder;
use common\models\PaymentChannel;
use common\models\Order;
use Yii;

class PayController extends Base
{
    
    public function actionIndex()
    {
        $data = Payment::find()
               ->where("is_show=1")
               ->select('id,title,icon,type,money_str,cate')
               ->orderBy('sort asc')
               ->asArray()->all();
        $oss_url = Yii::$app->params['oss_url'];
        foreach ($data as &$item){
            $item['icon'] =  $oss_url . $item['icon'];
        }
        $this->success($data);
    }
    
    public function actionChannel()
    {
        $pid = Yii::$app->request->get('pid');
        $data = PaymentChannel::find()
              ->where("is_show=1 and pid=$pid")
              ->select('id,title,type,money_str,min_money,max_money')
              ->orderBy('sort asc')
              ->limit(1)
              ->asArray()->all();
        
        foreach ($data as &$item){
            if(2 == $item['type']){
                $arr = explode('|', $item['money_str']);
                $item['money_str'] = $arr;
            }
            if(3 == $item['type']){
                $arr = explode('|', $item['money_str']);
                $item['money_str'] = '';
            }
            
        }
        $this->success($data);
    }
    
    public function actionOrder()
    {
       
        $data = Yii::$app->request->post();
        $channel_id = isset($data['channel_id']) ? intval($data['channel_id']):0;
        $amount = isset($data['amount']) ? intval($data['amount']):0;
        if(empty($channel_id) || empty($amount) || $amount < 1){
            return $this->error('参数错误');
        }
        $one = PaymentChannel::findOne($channel_id);
        if(empty($one)){
           return $this->error('支付渠道不存在');
        }
        $code = $one->code;
        $CL = "\common\payment\\$code";
        $one->toArray();
        $order_sn = date('ymdHis').mt_rand(1000, 9999);
        
        //创建订单
        $user_id = $this->userInfo['uid'];
        $order_model = new Order();
        $order_model->order_sn = $order_sn;
        $order_model->uid = $user_id;
        $order_model->username = $this->userInfo['username'];
        $order_model->pay_channel_id = $channel_id;
        $order_model->pay_channel_name = $one->title;
        $order_model->amount = $amount * 100;
        $order_model->return_amount = 0;
        $order_model->ip = $this->clientIP();
        $order_model->num = 1;
        $order_model->pay_status = 0;
        $order_model->create_time = date('Y-m-d H:i:s');
        $order_model->insert();
        $order_id = $order_model->order_id;
        $api_url = Yii::$app->params['api_url'];
        $notify_url = $api_url . 'notify/'.$order_id;
        $params = [
            'order_sn'     => $order_sn,
            'amount'       => $amount,
            'gateway'      => $one->gateway,
            'public_key'   => $one->public_key,
            'private_key'  => $one->private_key,
            'merchant_no'  => $one->merchant_no,
            'more_str'     => $one->more_str,
            'notify_url'   => $notify_url,
        ];
       
        $class = new $CL();
        $data = $class->pay($params);
        $this->success($data);
    }
    
    /**
     * 获取可以充值的银行卡账号
     */
    public function actionGetbank()
    {
        $bank_account = BankAccount::find()
                        ->where("is_show=1 and today < limit_day_max")
                        ->select('id,name,card,address,bank_id,memo')
                        ->orderBy('sort asc')
                        ->asArray()->all();
        
        if($bank_account){
            $key = array_rand($bank_account,1);
            $data = $bank_account[$key];
            $bank_model = Bank::findOne($data['bank_id']);
            $data['card'] = BankAccount::RSADecrypt($data['card']);
            $data['bank_name'] = $bank_model->name;
            $this->success($data);
        }
    }
    
    /**
     * 银行卡存款
     */
    public function actionBankorder()
    {
        $user_id = $this->userInfo['uid'];
        $data = Yii::$app->request->post();
        $aid  = isset($data['account_id']) ? $data['account_id'] : 0;
        $amount = isset($data['amount']) ? intval($data['amount']) * 100:0;
        $pay_name  = isset($data['pay_name']) ? $data['pay_name'] : '';
        $pay_memo  = isset($data['pay_memo']) ? $data['pay_memo'] : '';
        if(empty($aid) || empty($amount) || empty($pay_name) ){
            return $this->error('缺少必要参数');
        }
        //检测账号是否存在
        $bank_account_model = BankAccount::findOne($aid);
        if(empty($bank_account_model)){
            return $this->error('无效的银行卡账号');
        }
        
        //TODO 检测重复提交申请
        if(BankOrder::find()
                   ->where("aid = $aid && user_id=$user_id and type=1 and amount=$amount")
                   ->one()){
            return $this->error('请勿重复申请');
        }
        
        
        //银行信息
        $bank_model = Bank::findOne($bank_account_model->bank_id);
        if(empty($bank_model)){
            return $this->error('无效的银行信息');
        }
        
        $bank_order_model = new BankOrder();
        $bank_order_model->aid = $aid;
        $bank_order_model->bank_name = $bank_model->name;
        $bank_order_model->bank_account = $bank_account_model->name;
        $bank_order_model->bank_card = BankAccount::RSADecrypt($bank_account_model->card);
        $bank_order_model->bank_address = $bank_account_model->address;
        $bank_order_model->amount = $amount;
        $bank_order_model->user_id = $user_id;
        $bank_order_model->type = 1;
        $bank_order_model->pay_name = $pay_name;
        $bank_order_model->pay_memo = $pay_memo;
        $bank_order_model->create_date = date('Y-m-d H:i:s');
        if($bank_order_model->save()){
            return $this->success($data,'success');
        }else{
            return $this->error('申请失败');
        }
    }
}