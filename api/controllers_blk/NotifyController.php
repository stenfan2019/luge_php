<?php
namespace api\controllers;

use api\controllers\Base;

use common\models\PaymentChannel;
use common\models\Order;
use common\models\User;
use common\models\UserFundsDeal;
use common\models\PaymentLog;
use Yii;

class NotifyController extends Base
{
    //屏蔽登录
    public function init(){
         
        $this->openLoginCheck = false;
    }
    
    
    /**
     * 三方支付异步通知
     * @param int $o_id
     */
    public function actionIndex($oid)
    {
        $data = Yii::$app->request->post();
        if(empty($data)){
            $data = Yii::$app->request->get();
        }
        $a = $data;
        unset($a['oid']);
        if(empty($a)){
           exit('进入个人中心查看支付状态');
           
        }
        /*$str = 'a:11:{s:12:"callback_url";s:35:"http://user.zb123.tech/notify/70016";s:13:"callback_time";s:13:"1609236717876";s:6:"amount";s:5:"120.0";s:4:"fees";s:3:"2.4";s:12:"out_trade_no";s:16:"2012291809536590";s:12:"account_name";s:7:"bk10297";s:4:"sign";s:32:"50dd54074e003da36c9fc7551138ae25";s:8:"trade_no";s:19:"R202012291809547133";s:4:"type";s:1:"6";s:8:"pay_time";s:21:"2020-12-29 18:11:54.0";s:6:"status";s:1:"4";}';
        $data = unserialize($str);
        echo '<pre>';
        print_r($arr);
        exit;*/
        //日志记录
        $payment_log = new PaymentLog();
        $payment_log->order_id = $oid;
        $payment_log->data = serialize($data);
        $payment_log->create_date = date('Y-m-d H:i:s');
        $payment_log->save();
        
        
        $order = Order::findOne($oid);
        if(empty($order)){
            exit('订单不存在');
        }
        $order_sn = $order->order_sn;

        $channel_id = $order->pay_channel_id;
        $one = PaymentChannel::findOne($channel_id);
        $code = $one->code;
        $params = [
            'order_sn'     => $order_sn,
            'amount'       => $order->amount,
            'gateway'      => $one->gateway,
            'public_key'   => $one->public_key,
            'private_key'  => $one->private_key,
            'merchant_no'  => $one->merchant_no,
            'more_str'     => $one->more_str
        ];
        $CL = "\common\payment\\$code";
        $class = new $CL();
        $res = $class->notify($params,$data);
        if($res['result'] ){
            if($order->pay_status == '0'){
                $return_amount = intval($res['amount']);
                $order->pay_status  = 1;
                $order->notify_ip   = $this->clientIP();
                $order->notify_time = date('Y-m-d H:i:s');
                $order->update();
                //
                $uid = $order->uid;
                $memo = "充值『{$order_sn}』";
                User::balance($uid,$return_amount,UserFundsDeal::I_ORDER_PAYMENT,$memo);
            }
            echo $res['msg'];
            exit;
        }
        echo 'FAILE';
        exit;
    }
}