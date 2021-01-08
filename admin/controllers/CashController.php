<?php
namespace admin\controllers;

use yii;
use common\models\UserFundsDeal;
use common\models\AnchorFundsDeal;
use yii\data\Pagination;
use admin\controllers\Base;

class CashController extends Base
{
    //用户现金记录
    public function actionUser()
    {
        $data = Yii::$app->request->get('data');
        $this->layuiParams();
        if(1 == $data){
            $page = Yii::$app->request->get('page',1);
            $limit = Yii::$app->request->get('limit',20);
            $uid = Yii::$app->request->get('uid');
            $deal_type = Yii::$app->request->get('deal_type');
           
            $query = UserFundsDeal::find();
            if($uid){
                $query->where("uid=$uid");
            }
            if($deal_type){
                $query->where("deal_type=$deal_type");
            }
             
            $countQuery = clone $query;
            $count = $countQuery->count();
            $page_num = ceil($count / $limit);
            $pages = new Pagination(['totalCount' => $count,'defaultPageSize'=>$limit,'page'=>$page-1]);
            $models = $query->offset($pages->offset)
                      ->orderBy('create_time desc')
                      ->limit($limit)
                      ->asArray()->all();
            $field_title = UserFundsDeal::$field_title;
            $field_title['deal_type'] = UserFundsDeal::$type;
            
          
            $data = [
                'data'  =>  UserFundsDeal::fetchTitle($models, $field_title,2),
                'page'  => $page,
                'count' => $count,
                'limit' => $limit
            ];
            $this->success($data);
        }else{
            return $this->render('user',[
                'select_html'   => $this->html_select('deal_type',['0' => '请选择']+ UserFundsDeal::$type ,'0'),
                'params'        => "uid=$this->layui_val",
                'keyword'       => $this->layui_val
            ]);
        }
    }
    
    //主播现金记录
    public function actionAnchor()
    {
        $data = Yii::$app->request->get('data');
        $this->layuiParams();
        if(1 == $data){
            $page = Yii::$app->request->get('page',1);
            $limit = Yii::$app->request->get('limit',20);
            $uid = Yii::$app->request->get('uid');
            $deal_type = Yii::$app->request->get('deal_type');
             
            $query = AnchorFundsDeal::find();
            if($uid){
                $query->where("anchor_id=$uid");
            }
            if($deal_type){
                $query->where("deal_type=$deal_type");
            }
             
            $countQuery = clone $query;
            $count = $countQuery->count();
            $page_num = ceil($count / $limit);
            $pages = new Pagination(['totalCount' => $count,'defaultPageSize'=>$limit,'page'=>$page-1]);
            $models = $query->offset($pages->offset)
                    ->orderBy('create_time desc')
                    ->limit($limit)
                    ->asArray()->all();
            $field_title = AnchorFundsDeal::$field_title;
            $field_title['deal_type'] = AnchorFundsDeal::$type;
            foreach ($models as &$item){
                $item['deal_money'] = sprintf("%.2f",$item['deal_money'] / 100);
                $item['balance'] = sprintf("%.2f",$item['balance'] / 100);
            }
            $data = [
                'data'  =>  AnchorFundsDeal::fetchTitle($models, $field_title,2),
                'page'  => $page,
                'count' => $count,
                'limit' => $limit
            ];
            $this->success($data);
        }else{
            return $this->render('anchor',[
                'select_html'   => $this->html_select('deal_type',['0' => '请选择']+ AnchorFundsDeal::$type ,'0'),
                'params'        => "uid=$this->layui_val",
                'keyword'       => $this->layui_val
            ]);
        }
    }
}