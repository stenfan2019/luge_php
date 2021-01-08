<?php
namespace admin\controllers;

use yii;
use admin\controllers\Base;
use common\models\AnchorWithdraw;
use common\models\UserWithdraw;
use common\models\UserFundsDeal;
use common\models\User;
use common\models\Setting;
use yii\data\Pagination;
use yii\base\BaseObject;

class WithdrawController extends Base
{
    public function actionAnchor()
    {
        $data = Yii::$app->request->get('data');
        $this->layuiParams();
        if(1 == $data){
            $page = Yii::$app->request->get('page',1);
            $limit = Yii::$app->request->get('limit',20);
            $aid = Yii::$app->request->get('aid');
            $state = Yii::$app->request->get('state');
            $query = AnchorWithdraw::find()->alias('W');
            if($aid){
                $query->where("anchor_id=$aid");
            }
            if($state){
                $query->where("state=$state");
            }
           
            $query->joinWith('anchor as A',false,'INNER JOIN');
            $query->select('W.*,A.username,A.mobile,A.nickname');
            
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
                $item['fee'] = sprintf("%.2f",$item['fee'] / 100);
            }
            $data = [
                'data'  =>  AnchorWithdraw::fetchTitle($models, AnchorWithdraw::$field_title,2),
                'page'  => $page,
                'count' => $count,
                'limit' => $limit
            ];
            $this->success($data);
        }else{
            return $this->render('anchor',[
                'select_html'   => $this->html_select('state',['0' => '请选择']+ AnchorWithdraw::$field_title['state'] ,'0')
               
            ]);
        }
    }
    
    //拒绝主播提现申请
    public function actionAnchorRefuse()
    {
        $id = Yii::$app->request->get('id');
        $one = AnchorWithdraw::findOne($id);
        if($one){
            $one->state = 2;
            $one->update();
            $this->success([],'success');
        }
        $this->fail('fail');
    }
    
    //通过主播提现申请
    public function actionAnchorPass()
    {
        $id = Yii::$app->request->get('id');
        $one = AnchorWithdraw::findOne($id);
        if($one){
            $one->state = 3;
            $one->update();
            $this->success([],'success');
        }
        $this->fail('fail');
    }
    
    public function actionUser()
    {
        $data = Yii::$app->request->get('data');
        if(1 == $data){
            $page = Yii::$app->request->get('page',1);
            $limit = Yii::$app->request->get('limit',20);
            $aid = Yii::$app->request->get('aid');
            $state = Yii::$app->request->get('state');
            $query = UserWithdraw::find()->alias('W');
            if($aid){
                $query->where("anchor_id=$aid");
            }
            if($state){
                $query->where("state=$state");
            }
             
            $query->joinWith('user as A',false,'INNER JOIN');
            $query->select('W.*,A.username,A.mobile');
        
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
                $item['fee'] = sprintf("%.2f",$item['fee'] / 100);
            }
            $data = [
                'data'  =>  UserWithdraw::fetchTitle($models, UserWithdraw::$field_title,2),
                'page'  => $page,
                'count' => $count,
                'limit' => $limit
            ];
            $this->success($data);
        }else{
            return $this->render('user',[
                'select_html'   => $this->html_select('state',['0' => '请选择']+ UserWithdraw::$field_title['state'] ,'0')
                 
            ]);
        }
    }
    
    //拒绝用户提现申请
    public function actionUserRefuse()
    {
        $id = Yii::$app->request->get('id');
        $one = UserWithdraw::findOne($id);
        if($one && $one->state == 1){
            $one->state = 2;
            $one->update();
            //退回账单信息
            $id = $one->id;
            $memo = "提现退回『{$id}』"; 
            User::balance($one->user_id,$one->amount,UserFundsDeal::I_WITHDRAW,$memo);
            $this->success([],'success');
        }
        $this->fail('fail');
    }
    
    //通过用户提现申请
    public function actionUserPass()
    {
        $id = Yii::$app->request->get('id');
        $one = UserWithdraw::findOne($id);
        if($one && $one->state == 1){
            $one->state = 3;
            $one->update();
            //记录用户提现金额
            $user_model = User::findOne($one->user_id);
            $withdraw_money = $user_model->withdraw + $one->amount;
            $user_model->withdraw = $withdraw_money;
            $this->success([],'success');
        }
        $this->fail('fail');
    }
    
    
    //提现手续费设置
    public function actionSetting()
    {
        $data = Yii::$app->request->get('data');
        $user_set = Setting::findOne(Setting::USER_ID);
        $anchor_set = Setting::findOne(Setting::ANCHOR_ID);
        if(1 == $data && Yii::$app->request->isPost ){
            $data =  Yii::$app->request->post();
            $setting_model = new Setting();
            $user_data = [
                'user_free_times'  => $data['user_free_times'],
                'user_min_money'   => $data['user_min_money'],
                'user_max_money'   => $data['user_max_money'],
                'user_fee'         => $data['user_fee'],
                'user_day_times'   => $data['user_day_times'],
                'user_one_fee'     => $data['user_one_fee']
                
            ];
            
            if(empty($user_set)){
                $setting_model->id = Setting::USER_ID;
                $setting_model->data = serialize($user_data);
                $setting_model->save();
            }else{
                $user_set->data = serialize($user_data);
                $user_set->update();
            }
            
            $anchor_data = [
                'anthor_free_times'  => $data['anthor_free_times'],
                'anthor_min_money'   => $data['anthor_min_money'],
                'anthor_max_money'   => $data['anthor_max_money'],
                'anthor_fee'         => $data['anthor_fee'],
                'anthor_day_times'   => $data['anthor_day_times'],
                'anthor_one_fee'     => $data['anthor_one_fee']
            ];
            
            if(empty($anchor_set)){
                $setting_model->id = Setting::ANCHOR_ID;
                $setting_model->data = serialize($anchor_data);
                $setting_model->save();
            }else{
                $anchor_set->data = serialize($anchor_data);
                $anchor_set->update();
            }
            $this->success([],'success');
        }
        return $this->render('setting',[
            'user_set'    => $user_set ? unserialize($user_set->data) : [],
            'anchor_set'  => $anchor_set ? unserialize($anchor_set->data) : [],
        ]);
    }
}