<?php
namespace common\models;

use common\models\HbaoPacketSub;
use common\models\User;
use common\models\UserFundsDeal;
use Yii;
use yii\db\Exception;

class HbaoPacket extends Base
{
    static $field_title = [
        'type' => ['1' => '等待', '2' => '过期','3' => '抢完'],
        'is_hit_mine' => ['0' => '未命中','1'=>'命中'],
        'is_mine' => ['0' => '无','1'=>'有']
    ];
    
    static $search = [
        'user_id'  => 'UID',
        'id'  => '红包ID',
        'room_id'  => '房间ID',
        'ip'       => 'IP'
    ];
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hbao_packet';
    }
    
    public function sendPacket($room_model,$user_info,$amount,$num,$mine,$ip='127.0.0.1')
    {
        $is_hit = $this->checkHit($room_model->odds);
        $hbao_list = $this->getHbaoEveryMoney($num, $amount,$is_hit,$mine);
        $is_mine = $is_hit;
        shuffle($hbao_list);
        $time = time();
        //大红包数据入库
        $created      = date("Y-m-d H:i:s",$time);
        $invalid_date = date("Y-m-d H:i:s",$time + $room_model->life_time);
        $mine_num = count($mine);
        $odds = HbaoSet::getOdds($num, $mine_num) * 100;
        $this->room_id      = $room_model->id;
        $this->room_name    = $room_model->name;
        $this->user_id      = $user_info['uid'];
        $this->user_name    = $user_info['username'];
        $this->number       = $num;
        $this->money        = $amount;
        $this->mine_num     = $mine_num;
        $this->mine_str     = join(',',$mine);
        $this->life_time    = $room_model->life_time;
        $this->created      = $created;
        $this->invalid_date = $invalid_date;
        $this->earn_money   = 0;
        $this->lose_money   = 0;
        $this->return_money = 0;
        $this->status       = 1;
        $this->type         = 1;
        $this->is_hit_mine  = $is_hit ? 1 : 0;
        $this->draw_user_ids= '';
        $this->draw_num     = 0;
        $this->odds         = $odds;
        $this->ip           = $ip;
        
        sort($mine);
        $max = max($hbao_list);
        //检测 开包是否中雷
        $res = $this->checkedIsHitMine($mine,$hbao_list);
        
        if(false == $is_mine){
            if($res['check_mine']){
               $is_mine     = 1;
            }
           
        }
        
        $this->is_mine      = $is_mine;
        $this->save();
        $hbao_id = false;
        $transaction = Yii::$app->db->beginTransaction();
        try {
            $this->save();
            //加入小红包
            $hbao_id = $this->id;
            $hbao_list = $res['hbao_list'];
            foreach ($hbao_list as $key => $value) {
                $is_good = 0;
                if($value['money'] == $max){
                    $is_good = 1;
                }
                $sub_is_mine = $value['is_win'] ? 0 : 1;
                if($sub_is_mine == 1 && !$is_mine){
                    $sub_is_mine = 0;
                }
                $sub_model = new HbaoPacketSub();
                $sub_model->room_id       = $room_model->id;
                $sub_model->hbao_id       = $hbao_id;
                $sub_model->amount        = $value['money'];
                $sub_model->odds          = $odds;
                $sub_model->created       = $created;
                $sub_model->invalid_date  = $invalid_date;
                $sub_model->is_mine       = $sub_is_mine;
                $sub_model->user_id       = 0;
                $sub_model->user_name     = '';
                $sub_model->fee           = 0;
                $sub_model->draw_date     = '';
                $sub_model->ip            = '';
                $sub_model->is_hit        = 0;
                $sub_model->is_die        = 0;
                $sub_model->is_good       = $is_good;
                $sub_model->insert();
               
            }
            $memo = "发红包『{$hbao_id}』";
            
            $transaction->commit();
            
       }catch (Exception $e){
            $transaction->rollBack();
            return false;
       }
       if(User::balance($user_info['uid'],-$amount,UserFundsDeal::O_HBAO_SEND,$memo)){
           return $hbao_id;
       }
       return false;
       
    }
    
    //通过大红包生成小红包
    protected function getHbaoEveryMoney($num,$money,$hit=false,$mine=[])
    {
        $mine = is_array($mine) ? $mine : [$mine];
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
                $hit1      = mt_rand($avg-20,$avg+20) / 1000;
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
    
    //生成一个红包id
    protected function getHbaoId($room_id)
    {
        return  $room_id . date('ymdHis',time()) . mt_rand(1,99999);
    }
    
    //生成一个小红包金额
    protected function creatMoney($min,$money)
    {
        return mt_rand($min,$money);
    }
    
    //是否命中
    protected function checkHit($odds)
    {
        if($odds > 0){
            $n = mt_rand(1, 100);
            return $n <= $odds ? true : false;
        }
        return false;
    }
    
    //检测红包是否中雷
    protected function  checkedIsHitMine($mine_list,$hbao_list)
    {
        $tmp = [];
        $win_mine_list  = [];
        foreach ($hbao_list as $key => $v) {
            $arr = [
                'money'    => $v,
                'user_id'  => 0,
                'is_win'   => 1
            ];
            $n = substr($v, -1);
            if(in_array($n,$mine_list)){
                $arr['is_win'] = 0;
                $win_mine_list[] = $n;
            }
            $tmp[$key] = $arr;
        }
        $win_mine_list = array_unique($win_mine_list);
        sort($win_mine_list);
        $data['hbao_list'] = $tmp;
        $data['check_mine'] = $mine_list == $win_mine_list ? true : false;
        return $data;
    }
    
     
}
