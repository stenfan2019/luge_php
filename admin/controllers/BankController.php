<?php
namespace admin\controllers;

use yii;
use common\models\Bank;
use common\models\BankOrder;
use common\models\User;
use common\models\UserFundsDeal;
use yii\data\Pagination;
use admin\controllers\Base;

class BankController extends Base
{
    public function actionList()
    {
        $data = Yii::$app->request->get('data');
        if(1 == $data){
            $page = Yii::$app->request->get('page',1);
            $limit = Yii::$app->request->get('limit',20);
            $type = Yii::$app->request->get('type');
            $cate = Yii::$app->request->get('cate');
            $query = Bank::find();
            if($type){
                $page = 1;
                $query->where("type='$type");
            }  
            if($cate){
                $query->where("cate=$cate");
            }
            
            $countQuery = clone $query;
            $count = $countQuery->count();
            $page_num = ceil($count / $limit);
            $pages = new Pagination(['totalCount' => $count,'defaultPageSize'=>$limit,'page'=>$page-1]);
            $models = $query->offset($pages->offset)
                    ->orderBy('created desc')
                    ->limit($limit)
                    ->asArray()->all();
           
            $data = [
                'data'  => $models,
                'page'  => $page,
                'count' => $count,
                'limit' => $limit
            ];
            $this->success($data);
        }else{
            return $this->render('list');
        }
    }
    
    
    
    //添加公告
    public function actionAdd()
    {
        $type = Yii::$app->request->get('type');
        if(Yii::$app->request->isPost){
            $data =  Yii::$app->request->post();
            $date = date('Y-m-d H:i:s');
            $model = new Bank();
            $model->name   = $data['name'];
            $model->code   = $data['code'];
            $model->shortname    = $data['shortname'];
            $model->logo    = $data['logo'];
            $model->url     = $data['url'];
            $model->sort    = $data['sort'];
            $model->created = $date;
            $model->updated = $date;
            if($model->insert()){
                $this->success($data);
            }else{
                $this->fail();
            }
        }else{
            $up_data = $this->_http();
            return $this->render('add',[
                'up_data'   => $up_data
            ]);
        }
    }
    
    //编辑会员账号
    public function actionEdit()
    {
        $id = Yii::$app->request->get('id');
        $one = Bank::findOne($id);
        if(Yii::$app->request->isPost){
            $data =  Yii::$app->request->post();
            $date = date('Y-m-d H:i:s');
            $one->name   = $data['name'];
            $one->code   = $data['code'];
            $one->shortname    = $data['shortname'];
            $one->logo    = $data['logo'];
            $one->url     = $data['url'];
            $one->sort    = $data['sort'];
            $one->updated = $date;
            if($one->update()){
                $this->success([]);
            }
            $this->fail();
        }else{
            $up_data = $this->_http();
            return $this->render('edit',[
                'item'      => $one->toArray(),
                'up_data'   => $up_data
            ]);
        }
    }
    
    public function actionDel()
    {
        $id = Yii::$app->request->get('id');
        $one = Bank::findOne($id);
        $one->delete();
        $this->success([]);
    }
    
    /**
     * 银行卡订单
     */
    public function actionIncome()
    {
        $data = Yii::$app->request->get('data');
        if(1 == $data){
            $page = Yii::$app->request->get('page',1);
            $limit = Yii::$app->request->get('limit',20);
            $query = BankOrder::find()->alias('B')
                   ->select("B.bank_name,B.user_id,B.pay_name,B.bank_name,
                             B.bank_card,B.bank_account,B.amount,B.type,
                             B.create_date,U.username,B.id,true_amount")
                   ->innerJoin('live_user as U','B.user_id = U.uid');
                    
            $countQuery = clone $query;
            $count = $countQuery->count();
            $page_num = ceil($count / $limit);
            $pages = new Pagination(['totalCount' => $count,'defaultPageSize'=>$limit,'page'=>$page-1]);
            $models = $query->offset($pages->offset)
                    ->orderBy('B.create_date desc')
                    ->limit($limit)
                    ->asArray()->all();
            $models =  BankOrder::fetchTitle($models, BankOrder::$field_title,2);
            foreach ($models as &$item){
                $item['amount'] = sprintf("%.2f",$item['amount'] / 100);
                $item['true_amount'] = sprintf("%.2f",$item['true_amount'] / 100);
            }
            $data = [
                'data'  => $models,
                'page'  => $page,
                'count' => $count,
                'limit' => $limit
            ];
            $this->success($data);
        }else{
            return $this->render('income',[
                    'select_html'   => $this->html_select('type', BankOrder::$field_title['type']),
            ]);
        }
    }
    
    //
    public function actionIncomeView()
    {
        $id = Yii::$app->request->get('id');
        $one = BankOrder::findOne($id);
        if(Yii::$app->request->isPost){
            $data =  Yii::$app->request->post();
            $true_amount = $data['true_amount'] * 100;
            
            $date = date('Y-m-d H:i:s');
            $one->update_date = $date;
            
            if($one->type == 1){
                if($true_amount < 1){
                    $this->fail('实际金额必须填写');
                }
                $one->true_amount = $true_amount;
                $one->type = 3;
                $one->memo = $data['memo'];
                //
                User::balance($one->user_id,$true_amount,UserFundsDeal::I_ORDER_PAYMENT,'银行卡入款');
            }
            if($one->update()){
                $this->success([]);
            }
            $this->fail();
        }else{
            return $this->render('income-view',[
                'item'          => $one->toArray(),
                'select_html'   => $this->html_select('type', BankOrder::$field_title['type'])
            ]);
        }
    }
    
    public function actionIncomeDel()
    {
        $id = Yii::$app->request->get('id');
        $one = BankOrder::findOne($id);
        $one->type = 2;
        $one->update();
        $this->success([]);
    }
    
}