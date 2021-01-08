<?php
namespace admin\controllers;

use yii;
use admin\controllers\Base;
use common\models\User;
use common\models\UserFundsDeal;
use common\models\Order;
use yii\data\Pagination;

class OrderController extends Base
{
    public function actionList(){
        $data = Yii::$app->request->get('data');
        $this->layuiParams();
        if(1 == $data){
            $page = Yii::$app->request->get('page',1);
            $limit = Yii::$app->request->get('limit',20);
            $uid = Yii::$app->request->get('uid');
            $state = Yii::$app->request->get('state');
            $query = Order::find();
            if($uid){
                $query->where("uid=$uid");
            }
            if($state){
                $query->where("pay_status=$state");
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
                $item['return_amount'] = sprintf("%.2f",$item['return_amount'] / 100);
            }
            $data = [
                'data'  =>  Order::fetchTitle($models, Order::$field_title,2),
                'page'  => $page,
                'count' => $count,
                'limit' => $limit
            ];
            $this->success($data);
        }else{
            return $this->render('list',[
                'select_html'   => $this->html_select('state', Order::$field_title['pay_status'] ,'0')
                 
            ]);
        }
    }
    
    
    public function actionEdit()
    {
        $id = Yii::$app->request->get('id');
        $one = Order::findOne($id);
        if(Yii::$app->request->isPost){
            $data =  Yii::$app->request->post();
            $pay_status = $data['pay_status'];
            $return_amount = $data['return_amount'] * 100;
            if(($one->pay_status == '0' && $pay_status == 1)
                && (empty($return_amount) || empty($data['memo']) )
                ){
                $this->fail('必须填写到账金额和备注说明');
            }else{
                
                $one->pay_status   = 1;
                $one->return_amount   = $return_amount;
                $one->memo    = $data['memo'];
                
                if($one->update()){
                    $user_id = $one->uid;
                    $order_sn = $data['order_sn'];
                    $memo = "充值『{$order_sn}』";
                    User::balance($user_id,$return_amount,UserFundsDeal::I_ORDER_PAYMENT,$memo);
                    $this->success([]);
                }
            }
            $this->fail('并没有做出改动');
            
        }
        return $this->render('edit',
            [
                'item'        => $one->toArray(),
                'select_html' => $this->html_radio('pay_status', Order::$field_title['pay_status'],"{$one->pay_status}")
            ]);
    }
}