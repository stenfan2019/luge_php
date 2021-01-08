<?php
namespace admin\controllers;

use yii;
use admin\controllers\Base;
use common\models\Room;
use yii\data\Pagination;
use GuzzleHttp\Client;

class RoomController extends Base
{
    public function actionList()
    {
        $data = Yii::$app->request->get('data');
        if(1 == $data){
           $page = Yii::$app->request->get('page',1);
           $limit = Yii::$app->request->get('limit',20);
           $keyword = Yii::$app->request->get('keyword');
           $search = Yii::$app->request->get('search');
           $query = Room::find();
           if($keyword){
               $query->where("$search='{$keyword}'");
           }
                   
           $countQuery = clone $query;
           $count = $countQuery->count();
           $page_num = ceil($count / $limit);
           $pages = new Pagination(['totalCount' => $count,'defaultPageSize'=>$limit,'page'=>$page-1]);
           $models = $query->offset($pages->offset)
                           ->orderBy('create_time desc')
                           ->limit($limit)
                           ->asArray()->all();
           $data = [
               'data'  => Room::fetchTitle($models, Room::$field_title,2),
               'page'  => $page,
               'count' => $count,
               'limit' => $limit
           ];
           $this->success($data);
        }else{
           return $this->render('list',[
               'search'   => $this->html_select('search', ['0' => '请选择']+Room::$search,'0')
           ]);
        }   
    }
    
    public function actionAdd()
    {
        if(Yii::$app->request->isPost){
            $data  =  Yii::$app->request->post();
            //关闭之前的所有直播间
            Room::closeAnchorAllRoom($data['anchor_id']);
            $model = new Room();
            $time  = time();
            $date  = date('Y-m-d H:i:s',$time);
            $model->title      = $data['title'];
            $model->discript   = $data['discript'];
            $model->anchor_id  = $data['anchor_id'];
            $model->state      = 1;
            $model->status     = 1;
            $model->online_num = 1;
            $model->chat_id    = $data['anchor_id'];
            $model->show_pic   = $data['show_pic'];
            $model->create_time= $date;
            $model->update_time= $date;
            $model->keywords   = $data['discript'];
            $model->is_index   = $data['is_index'];
            $model->recommend  = $data['recommend'];
            $model->category   = $data['category'];
            $model->rtmp_url   = $data['rtmp_url'];
            $model->flv_url    = $data['flv_url'];
            $model->hls_url    = $data['flv_url'];
            if($model->insert()){
                $this->success($data);
            }else{

//                print_r($model->errors);
                $this->fail();
            }
        }else{
            $up_data = $this->_http();
            return $this->render('add',[
                 'category'  => $this->html_radio('category', Room::$field_title['category'],2),
                 'recommend' => $this->html_radio('recommend', Room::$field_title['recommend'],'0'),
                 'is_index'  => $this->html_radio('is_index', Room::$field_title['is_index'],'0'),
                 'up_data'   => $up_data
            ]);
        }
    }
    
    public function actionEdit()
    {
        
    }
    
    public function actionClose()
    {
        $id = Yii::$app->request->get('id');
        $one = Room::findOne($id);
        $one->state = 0;
        $one->update();
     
        $data  = [
            'roomId'  => $id,
            'userId'  => $one->anchor_id,
            'type'    => '1090',
            'content' => "close"
        ];
        $message = json_encode($data,true);
        $this->pushMessage(['message' => $message]);
        $this->success([]);
    }
    
    protected function pushMessage($params)
    {
        $gatewayclient = Yii::$app->params['gatewayclient'];
        $client = new Client();
        $url = $gatewayclient . '/hbao.php';
        $ch = curl_init ();
        curl_setopt ( $ch, CURLOPT_URL, $url );
        curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt ( $ch, CURLOPT_CUSTOMREQUEST, 'POST' );
        curl_setopt ( $ch, CURLOPT_POSTFIELDS, $params );
        curl_setopt ( $ch, CURLOPT_TIMEOUT, 60 );
        $result = curl_exec ( $ch );
        curl_close ( $ch );
        return $result;
    }
}