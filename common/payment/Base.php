<?php
namespace common\payment;

use Yii;

class Base{
    
    public $no;
    
    public $return_amount;
    
    protected function Post($url,$params,$headers=false)
    {
        $ch = curl_init ();
        curl_setopt ( $ch, CURLOPT_URL, $url );
        curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt ( $ch, CURLOPT_CUSTOMREQUEST, 'POST' );
        curl_setopt ( $ch, CURLOPT_POSTFIELDS, $params );
        if($headers){
            curl_setopt ( $ch, CURLOPT_HTTPHEADER, $headers );
        }
        curl_setopt ( $ch, CURLOPT_TIMEOUT, 60 );
        $result = curl_exec ( $ch );
        curl_close ( $ch );
        return $result;
    }
    
    /**
     * type:
     * request:跳转
     * qrcode:二维码展示
     */
    protected function return_data($url,$type='request',$method='GET',$data=[])
    {
        $data = [
            'type'    =>  $type,
            'method'  =>  $method,
            'url'     =>  $url,
            'data'    =>  $data,
        ];
        return $data;
    }
    
    public function backSuccess()
    {
        echo 'SUCCESS';
    }
    
    protected function back($result,$msg='SUCCESS',$data=array()){
        $back = array(
            'trade_no' => $this->no,
            'amount'   => $this->return_amount,
            'result'   => $result,
            'msg'      => $msg,
        );
       
        return $back;
    }
    
    public function backError($msg = '')
    {
        echo 'fail';
    }
    
}