<?php
namespace common\payment;

use Yii;
class Beikepay extends Base{
    
    public function pay($config)
    {
       $arr  = unserialize($config['more_str']);
       $notify_url = $config['notify_url'];
       $param = [
           'account_id'    => $config['merchant_no'],
           'type'          => $arr['type'],
           'out_trade_no'  => $config['order_sn'],
           'amount'        => $config['amount'],
           'callback_url'  => $notify_url,
           'success_url'   => $notify_url,
           'error_url'     => $notify_url,
       ];
      
       $sign = $this->sign($config['private_key'],$param);
       $param['sign'] = $sign;
       //$data = $this->Post($config['gateway'], $param);
       $data = $this->return_data($config['gateway'],'request','POST',$param);
       return $data;
    }
    
    public function notify($config,$data)
    {
        $this->no = $data['out_trade_no'];
        $this->return_amount = $data['amount'] * 100;
        
        if($data['status']!='4'){
            $this -> backError();
            exit;
        }
        $sign = $data['sign'];    //md5密钥（KEY）
        unset($data['sign']);
        //订单号
        $check_sign = $this->sign($config['private_key'],$data);
        if ($sign == $check_sign){
            return $this->back(true);
        }else{
            $this->backError();
            exit;
        }
    }
    
    function sign ($key_id, $array)
    {
        $data = md5('amount:'.number_format($array['amount'],2) . 'out_trade_no:'.$array['out_trade_no'].
            'callback_url:'.$array['callback_url']);
        $key[] ="";
        $box[] ="";
        $pwd_length = strlen($key_id);
        $data_length = strlen($data);
        for ($i = 0; $i < 256; $i++)
        {
            $key[$i] = ord($key_id[$i % $pwd_length]);
            $box[$i] = $i;
        }
        for ($j = $i = 0; $i < 256; $i++)
        {
            $j = ($j + $box[$i] + $key[$i]) % 256;
            $tmp = $box[$i];
            $box[$i] = $box[$j];
            $box[$j] = $tmp;
        }
        $cipher ='';
        for ($a = $j = $i = 0; $i < $data_length; $i++)
        {
            $a = ($a + 1) % 256;
            $j = ($j + $box[$a]) % 256;

            $tmp = $box[$a];
            $box[$a] = $box[$j];
            $box[$j] = $tmp;

            $k = $box[(($box[$a] + $box[$j]) % 256)];
            $cipher .= chr(ord($data[$i]) ^ $k);
        }
        return md5($cipher);
    }
}