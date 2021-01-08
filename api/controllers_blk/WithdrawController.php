<?php
namespace api\controllers;

use api\controllers\Base;
use Yii;
use common\models\UserWithdraw;
use common\models\User;
use common\models\UserBanks;
use common\models\UserFundsDeal;
use common\models\Setting;

use yii\data\Pagination;



class WithdrawController extends Base
{
    
    /**
     * 用户提现申请
     * @author stenfan
     */
    public function actionApply()
    {
        $userinfo = $this->userInfo;
        $uid = $this->userInfo['uid'];
        $one = User::findOne($uid);
        $amount   = Yii::$app->request->get('amount',0);
        //$amount   = $amount * 100;
        $bank_id  = Yii::$app->request->get('bank_id');
        $conf  = Setting::findOne(Setting::USER_ID);
        if(empty($conf)){
            $this->error('配置异常请联系客户');
        }
        $data = $conf->data;
        $conf = unserialize($data);
        $user_min_money = $conf['user_min_money'];
        $user_max_money = $conf['user_max_money'];
        $user_day_times = $conf['user_day_times'];
        if($amount < $user_min_money){
            $this->error("最低提现金额为{$user_min_money}元");
        }
        if($amount > $user_max_money){
            $this->error("单笔提现金额不得大于{$user_max_money}");
        }
        if(UserWithdraw::find()
                  ->where("user_id=$uid and state=1")->count()){
            $this->error('有未审核的提现申请,请联系客服');
        }
        //今日提现次数
        $today = date('Y-m-d 00:00:00',time());
        $times = UserWithdraw::find()
                  ->where("user_id=$uid and create_time >='{$today}'")->count();
        if($times > $user_day_times){
            $this->error('今日提现次数已经到达上限');
        }
        if($one->amount < $amount * 100){
            $this->error('您账号余额不足');
        }
        $bank = UserBanks::findOne($bank_id);
        if(empty($bank)){
            $this->error('您还为绑定银行卡');
        }
        $model = new UserWithdraw();
        $fee = $model->getFee($amount,$times) * 100;
        $model->user_id      = $uid;
        $model->bank_name    = $bank->bank_name;
        $model->bank_code    = $bank->bank_code;
        $model->bank_number  = $bank->bank_number;
        $model->account      = $bank->bank_account;
        $model->bank_address = $bank->bank_address;
        $model->amount       = $amount * 100;
        $model->state        = 1;
        $model->create_time  = date('Y-m-d H:i:s');
        $model->fee          = $fee;    
        if($model->save()){
           $id = $model->id;
           $memo = "提现扣除『{$id}』"; 
           User::balance($uid,$amount * 100,UserFundsDeal::O_WITHDRAW,$memo);
        }
        
        $this->success([]);
    }
    
   
    
    /**
     * 计算体现手续费
     * @author stenfan
     */
    public function actionFee()
    {      
        $userinfo = $this->userInfo;
        $uid = $this->userInfo['uid'];
        
        $amount   = Yii::$app->request->get('amount',0);
        $model = new UserWithdraw();
        //今日提现次数
        $today = date('Y-m-d 00:00:00',time());
        $times = UserWithdraw::find()->where("user_id=$uid and create_time >='{$today}'")->count();
        $fee = $model->getFee($amount,$times);
        $this->success(['fee' => $fee,'amount' => $amount]);
    }
    
    /**
     * 主播提现记录
     * @author stenfan
     */
    public function actionRecord()
    {
        $page = Yii::$app->request->get('page',1);
        $limit = Yii::$app->request->get('limit',20);
        $state = Yii::$app->request->get('state',0);
        $userinfo = $this->userInfo;
        $uid = $this->userInfo['uid'];
        $query = UserWithdraw::find()
        ->where("user_id=$uid");
        if($state){
            $query->where("state=$state");
        }
        $countQuery = clone $query;
        $count = $countQuery->count();
        $page_num = ceil($count / $limit);
        $pages = new Pagination(['totalCount' => $count,'defaultPageSize'=>$limit,'page'=>$page-1]);
        $models = $query->offset($pages->offset)
                ->orderBy('create_time desc')
                ->limit($limit)
                ->asArray()->all();
        foreach ($models as &$item){
            $item['amount'] = sprintf("%.2f",$item['amount'] / 100);
            $item['fee']    = sprintf("%.2f",$item['fee'] / 100);
        }
        $models = UserWithdraw::fetchTitle($models, UserWithdraw::$field_title,2);
    
        $data = $this->_apiPage($models, $pages, $limit, $page);
        $this->success($data);
    }
    
}