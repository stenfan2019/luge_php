<?php
namespace admin\controllers;

use yii;
use admin\controllers\Base;
use common\models\Payment;
use common\models\PaymentChannel;
use yii\data\Pagination;

class PaymentController extends Base
{
    public function actionCate()
    {
        $data = Yii::$app->request->get('data');
        if(1 == $data){
            $page = Yii::$app->request->get('page',1);
            $limit = Yii::$app->request->get('limit',20);
            $query = Payment::find();
          
             
            $countQuery = clone $query;
            $count = $countQuery->count();
            $page_num = ceil($count / $limit);
            $pages = new Pagination(['totalCount' => $count,'defaultPageSize'=>$limit,'page'=>$page-1]);
            $models = $query->offset($pages->offset)
                            ->orderBy('create_date desc')
                            ->limit($limit)
                            ->asArray()->all();
             
            $data = [
                'data'  => Payment::fetchTitle($models, Payment::$field_title,2),
                'page'  => $page,
                'count' => $count,
                'limit' => $limit
            ];
            $this->success($data);
        }else{
            return $this->render('cate');
        }
    }
    
    public function actionCateadd() 
    {
        $type = Yii::$app->request->get('type');
        if(Yii::$app->request->isPost){
            $data =  Yii::$app->request->post();
            $date = date('Y-m-d H:i:s');
            $model = new Payment();
            $model->title   = $data['title'];
            $model->icon    = $data['icon'];
            $model->type    = $data['type'];
            $model->is_show    = $data['is_show'];
            $model->money_str    = $data['money_str'];
            $model->sort    = $data['sort'];
            $model->cate    = $data['cate'];
            $model->create_date = $date;
            if($model->insert()){
                $this->success($data);
            }else{
                $this->fail();
            }
        }else{
            $up_data = $this->_http();
            return $this->render('cateadd',[
                'up_data'   => $up_data,
                'type_html' => $this->html_radio('type', Payment::$field_title['type'],1),
                'is_show_html' => $this->html_radio('is_show', Payment::$field_title['is_show'],1),
                'cate_html' => $this->html_radio('cate', Payment::$field_title['cate'],'alipay'),
            ]);
        }
    }
    
    public function actionCateedit()
    {
        $id = Yii::$app->request->get('id');
        $one = Payment::findOne($id);
        if(Yii::$app->request->isPost){
            $data =  Yii::$app->request->post();
            $date = date('Y-m-d H:i:s');
            $one->title   = $data['title'];
            $one->icon    = $data['icon'];
            $one->type    = $data['type'];
            $one->is_show   = $data['is_show'];
            $one->money_str  = $data['money_str'];
            $one->sort    = $data['sort'];
            $one->cate    = $data['cate'];
            if($one->update()){
                $this->success([]);
            }
            $this->fail();
        }else{
            $up_data = $this->_http();
            return $this->render('cateedit',[
                'item'      => $one->toArray(),
                'up_data'   => $up_data,
                'type_html' => $this->html_radio('type', Payment::$field_title['type'],$one->type),
                'is_show_html' => $this->html_radio('is_show', Payment::$field_title['is_show'],"{$one->is_show}"),
                'cate_html' => $this->html_radio('cate', Payment::$field_title['cate'],"{$one->cate}"),
            ]);
        }
    }
    
    public function actionCatedel()
    {
        $id = Yii::$app->request->get('id');
        $one = Payment::findOne($id);
        $one->delete();
        $this->success([]);
    }
    
    public function actionList()
    {
        $data = Yii::$app->request->get('data');
        if(1 == $data){
            $page = Yii::$app->request->get('page',1);
            $limit = Yii::$app->request->get('limit',20);
            $query = PaymentChannel::find();
        
            $countQuery = clone $query;
            $count = $countQuery->count();
            $page_num = ceil($count / $limit);
            $pages = new Pagination(['totalCount' => $count,'defaultPageSize'=>$limit,'page'=>$page-1]);
            $models = $query->offset($pages->offset)
                            ->orderBy('create_date desc')
                            ->limit($limit)
                            ->asArray()->all();
            
            //所有分类
            $cates = Payment::find()
                    ->where("is_show=1 and !find_in_set('unionpay',cate)")
                    ->select('id,title')
                    ->orderBy('sort asc')
                    ->asArray()->all();
            $cates = $this->_filterArray($cates, 'id', 'title');
            
            $field_title = PaymentChannel::$field_title;
            $field_title['pid'] = $cates;
          
            $data = [
                'data'  => PaymentChannel::fetchTitle($models, $field_title,2),
                'page'  => $page,
                'count' => $count,
                'limit' => $limit
            ];
            $this->success($data);
        }else{
            return $this->render('list');
        }
    }
    
    public function actionAdd()
    {
        $type = Yii::$app->request->get('type');
        if(Yii::$app->request->isPost){
            $data  =  Yii::$app->request->post();
            $date  = date('Y-m-d H:i:s');
            $model = new PaymentChannel();
            $model->title        = $data['title'];
            $model->code         = $data['code'];
            $model->merchant     = $data['merchant'];
            $model->type         = $data['type'];
            $model->is_show      = $data['is_show'];
            $model->money_str    = $data['money_str'];
            $model->sort         = $data['sort'];
            $model->pid          = $data['pid'];
            $model->min_money    = $data['min_money'];
            $model->max_money    = $data['max_money'];
            $model->gateway      = $data['gateway'];
            $model->merchant_no  = $data['merchant_no'];
            $model->private_key  = $data['private_key'];
            $model->public_key   = $data['public_key'];
            $model->more_str     = $data['more_str'];
            
            $model->create_date  = $date;
            if($model->insert()){
                $this->success($data);
            }else{
                $this->fail();
            }
        }else{
            //所有分类
            $cates = Payment::find()
                   ->where("is_show=1 and !find_in_set('unionpay',cate)")
                   ->select('id,title')
                   ->orderBy('sort asc')
                   ->asArray()->all();
            $cates = $this->_filterArray($cates, 'id', 'title');
            return $this->render('add',[
                'type_html'    => $this->html_radio('type', PaymentChannel::$field_title['type'],1),
                'is_show_html' => $this->html_radio('is_show', PaymentChannel::$field_title['is_show'],1),
                'cate_html'    => $this->html_radio('pid', $cates,'0'),
            ]);
        }
    }
    
    public function actionEdit()
    {
        $id = Yii::$app->request->get('id');
        $one = PaymentChannel::findOne($id);
        if(Yii::$app->request->isPost){
            $data =  Yii::$app->request->post();
            $date = date('Y-m-d H:i:s');
            $one->title        = $data['title'];
            $one->code         = $data['code'];
            $one->merchant     = $data['merchant'];
            $one->type         = $data['type'];
            $one->is_show      = $data['is_show'];
            $one->money_str    = $data['money_str'];
            $one->sort         = $data['sort'];
            $one->pid          = $data['pid'];
            $one->min_money    = $data['min_money'];
            $one->max_money    = $data['max_money'];
            $one->gateway      = $data['gateway'];
            $one->merchant_no  = $data['merchant_no'];
            $one->private_key  = $data['private_key'];
            $one->public_key   = $data['public_key'];
            $one->more_str     = $data['more_str'];
            if($one->update()){
                $this->success([]);
            }
            $this->fail();
        }else{
           
          //所有分类
            $cates = Payment::find()
                   ->where("is_show=1 and !find_in_set('unionpay',cate)")
                   ->select('id,title')
                   ->orderBy('sort asc')
                   ->asArray()->all();
            $cates = $this->_filterArray($cates, 'id', 'title');
            return $this->render('edit',[
                'item'         => $one->toArray(),
                'type_html'    => $this->html_radio('type', 
                                       PaymentChannel::$field_title['type'],"{$one->type}"),
                'is_show_html' => $this->html_radio('is_show', 
                                       PaymentChannel::$field_title['is_show'],"{$one->is_show}"),
                'cate_html'    => $this->html_radio('pid', $cates,"{$one->pid}"),
            ]);
        }
    }
}