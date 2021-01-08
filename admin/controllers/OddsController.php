<?php


namespace admin\controllers;


use common\models\HbaoRoom;
use common\models\LotteryOdds;

class OddsController extends Base
{

    public function actionIndex(){}

    public function actionView($id){}

    public function actionEdit($id){

        $id = \Yii::$app->request->get('id');
        $model = LotteryOdds::findOne($id);
        if(!\Yii::$app->request->isPost){

            return $this->render('edit',[
                'item'    => $model->toArray(),
            ]);
        }else{
            $post = \Yii::$app->request->post();
            if(isset($post['lottery_code']))
                $model->lottery_code = $post['lottery_code'];

            if(isset($post['cate_name']))
                $model->cate_name = $post['cate_name'];

            if(isset($post['name']))
                $model->name = $post['name'];

            if(isset($post['odds']))
                $model->odds = $post['odds'];

            if(isset($post['sort']))
                $model->sort = $post['sort'];
            if($model->save()){
                return $this->success();
            }
            return $this->fail('保存失败');
        }

    }

    public function actionDelete($id){}


    public function actionList(){
        $page = \Yii::$app->request->get('page',1);
        $is_get = \Yii::$app->request->get('is_get',false);
        if($is_get)
        {
            $model = LotteryOdds::getList($page);
            foreach ($model['list'] as $k=> $item) //
            {
                //处理前端按元展示
                $model['list'][$k]['min_bet'] = number_format(($item->min_bet/100),2);
                $model['list'][$k]['max_bet'] = number_format(($item->max_bet/100),2);
            }
            $data = [
                'data'  => $model['list'],
                'page'  => $page,
                'count' => $model['count'],
                'limit' => LotteryOdds::PAGE_SIZE
            ];
            return $this->success($data);
        }

        return $this->render('list');

    }

}