<?php
namespace admin\controllers;

use yii;
use common\models\BankAccount;
use common\models\Bank;
use yii\data\Pagination;
use admin\controllers\Base;

class CollectController extends Base
{
    public function actionList()
    {
        $data = Yii::$app->request->get('data');
        if(1 == $data){
            $page = Yii::$app->request->get('page',1);
            $limit = Yii::$app->request->get('limit',20);
            $query = BankAccount::find();
            $countQuery = clone $query;
            $count = $countQuery->count();
            $page_num = ceil($count / $limit);
            $pages = new Pagination(['totalCount' => $count,'defaultPageSize'=>$limit,'page'=>$page-1]);
            $models = $query->offset($pages->offset)
                    ->orderBy('created desc')
                    ->limit($limit)
                    ->asArray()->all();
            foreach ($models as &$item){
                $item['card'] = BankAccount::RSADecrypt($item['card']);
            }
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
            $card = BankAccount::RSAEncrypt($data['card']);
            $model = new BankAccount();
            $model->name      = $data['name'];
            $model->card      = $card;
            $model->bank_id   = $data['bank_id'];
            $model->address   = $data['address'];
            $model->limit_max = $data['limit_max'];
            $model->limit_day_max  = $data['limit_day_max'];
            $model->limit_once_min = $data['limit_once_min'];
            $model->limit_once_max = $data['limit_once_max'];
            $model->memo      = $data['memo'];
            $model->sort    = $data['sort'];
            $model->created = $date;
            $model->updated = $date;
            if($model->insert()){
                $this->success($data);
            }else{
                $this->fail();
            }
        }else{
            $query = Bank::find();
            $models = $query->select('id,name')
                      ->orderBy('sort asc')->asArray()->all();
            $arr    = $this->_filterArray($models, 'id', 'name');
            $up_data = $this->_http();
            return $this->render('add',[
                'bank_html'   => $this->html_select('bank_id', $arr,''),
                'up_data'   => $up_data
            ]);
        }
    }
    
    //编辑会员账号
    public function actionEdit()
    {
        $id = Yii::$app->request->get('id');
        $one = BankAccount::findOne($id);
        if(Yii::$app->request->isPost){
            $data =  Yii::$app->request->post();
            $date = date('Y-m-d H:i:s');
            $card = BankAccount::RSAEncrypt($data['card']);
            $one->name      = $data['name'];
            $one->card      = $card;
            $one->bank_id   = $data['bank_id'];
            $one->address   = $data['address'];
            $one->limit_max = $data['limit_max'];
            $one->limit_day_max  = $data['limit_day_max'];
            $one->limit_once_min = $data['limit_once_min'];
            $one->limit_once_max = $data['limit_once_max'];
            $one->memo      = $data['memo'];
            $one->sort    = $data['sort'];
            $one->created = $date;
            $one->updated = $date;
            if($one->update()){
                $this->success([]);
            }
            $this->fail();
        }else{
            $query = Bank::find();
            $models = $query->select('id,name')
                            ->orderBy('sort asc')->asArray()->all();
            $arr    = $this->_filterArray($models, 'id', 'name');
            $up_data = $this->_http();
            $one->card = BankAccount::RSADecrypt($one->card);
            return $this->render('edit',[
                'bank_html'   => $this->html_select('bank_id', $arr,"$one->bank_id"),
                'item'        => $one->toArray(),
                'up_data'     => $up_data
            ]);
        }
    }
    
    public function actionDel()
    {
        $id = Yii::$app->request->get('id');
        $one = BankAccount::findOne($id);
        $one->delete();
        $this->success([]);
    }
}