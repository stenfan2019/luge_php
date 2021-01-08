<?php
namespace admin\controllers;

use admin\models\Admin;
use common\models\Active;
use common\models\ActiveType;
use common\models\UserDay;
use yii;
use common\models\Banner;
use yii\data\Pagination;
use admin\controllers\Base;

class DataController extends Base
{



    public function actionUserDay()
    {
        $data = Yii::$app->request->get('data');
        if(1 == $data){
            $page = Yii::$app->request->get('page',1);
            $limit = Yii::$app->request->get('limit','');
            $uname = Yii::$app->request->get('uname','');
            $date = Yii::$app->request->get('date','');
            $where = ['and'];

            if($uname)
            {
                $where[]= ['=','uname',$uname];
            }
            if($date)
            {
                $dates = explode('~',$date);
                $where[]= ['between','date',$dates[0],$dates[1]];
            }
            $list = UserDay::getPageData($where,$page,$limit);

            $data = [
                'data'  => $list['list']??[],
                'page'  => $page,
                'count' => $list['count'],
                'limit' => $limit
            ];
            $this->success($data);
        }else{

            return $this->render('user-day');
        }
    }


    public function actionPlatformDay()
    {
        $data = Yii::$app->request->get('data');
        if(1 == $data){
            $page = Yii::$app->request->get('page',1);
            $limit = Yii::$app->request->get('limit','');
            $date = Yii::$app->request->get('date','');
            $where = ['and'];
            if($date)
            {
                $dates = explode('~',$date);
                $where[]= ['between','date',$dates[0],$dates[1]];
            }
            $list = UserDay::getSumData($where,$page,$limit);

            $data = [
                'data'  => $list['list']??[],
                'page'  => $page,
                'count' => $list['count'],
                'limit' => $limit
            ];
            $this->success($data);
        }else{

            return $this->render('platform-day');
        }
    }



    
    //添加公告
    public function actionAdd()
    {
        $type = Yii::$app->request->get('type');
        if(Yii::$app->request->isPost){
            $data =  Yii::$app->request->post();
//            echo "<pre>";print_r($data);exit;
            unset($data['file']);
            $data['condition']  = json_encode($data['condition'],JSON_UNESCAPED_UNICODE);
            $data['bonus']  = json_encode($data['bonus'],JSON_UNESCAPED_UNICODE);
            $data['updated_uid'] = Admin::getUid();
            $data['created_uid'] = Admin::getUid();
            if(Active::saveData($data)){
                $this->success($data);
            }else{
                $this->fail();
            }
        }else{
            $type_names = Yii::$app->request->get('type_names');
            $up_data = $this->_http();
            $select = self::getParams();

            return $this->render('add',[
                'select_condition'    =>$select['condition'],
                'select_bonus'       => $select['bonus'],
                'select_type_name'       => self::selectTypeName(),
                'allCondition'    => ActiveType::getTypes($type_names),
                'get_type'      => self::select_get_type(),
                'get_status'    => self::select_get_status(),
                'type_names'    => $type_names,
            ]);
        }
    }
    
    //编辑会员账号
    public function actionEdit()
    {
        $id = Yii::$app->request->get('id');
        $one = Active::findOne($id);
        if(Yii::$app->request->isPost){
            $data =  Yii::$app->request->post();
            unset($data['file']);
            $data['condition']  = json_encode($data['condition'],JSON_UNESCAPED_UNICODE);
            $data['bonus']  = json_encode($data['bonus'],JSON_UNESCAPED_UNICODE);
            $data['updated_uid'] = Admin::getUid();
            $data['created_uid'] = Admin::getUid();
            if(Active::saveData($data,$id)){
                $this->success($data);
            }else{
                $this->fail();
            }
        }else{
            $up_data = $this->_http();
            $select = self::getParams();
            $item =  $one->toArray();
//            echo "<pre>";
//            print_r(json_decode($item['bonus'],true));exit;
            return $this->render('edit',[
                'item'          => $item,
                'select_condition'    =>$select['condition'],
                'select_bonus'       => $select['bonus'],
                'select_type_name'       => self::selectTypeName(),
                'condition' => json_decode($item['condition'],true),
                'bonus' => json_decode($item['bonus'],true),
                'get_type'      => self::select_get_type(),
                'get_status'    => self::select_get_status(),
                'allCondition'  => ActiveType::getTypes($item['type']),

            ]);
        }
    }


    /**
     * 过去活动所需条件
     * @param string $type
     * @return string
     * @author mike
     * @date 2020-12-22
     */
    public static function getParams($type =ActiveType::DEPOSIT)
    {
        $condition = ActiveType::getTypes($type);
        $select['condition'] = "";
        $select['bonus'] = "";
        foreach ($condition['condition'] as $item => $val)
        {
            $select['condition'] .= "<option value='".$item."'>".$val['name']."</option>";
        }
        foreach ($condition['bonus'] as $item => $val)
        {
            $select['bonus'] .= "<option value='".$item."'>".$val['name']."</option>";
        }
        return $select;
    }


    public static function selectTypeName()
    {
        $type_name = "<option value=''>请选择</option>";
        foreach (ActiveType::getTypeName() as $item => $val)
        {
            $type_name .= "<option value='".$item."'>".$val."</option>";
        }
        return $type_name;
    }


    public static function select_get_type()
    {
        $type_name = "";
        foreach (Active::get_type() as $item => $val)
        {
            $type_name .= "<option value='".$item."'>".$val."</option>";
        }
        return $type_name;
    }



    public static function select_get_status()
    {
        $type_name = "";
        foreach (Active::getStatus() as $item => $val)
        {
            $type_name .= "<option value='".$item."'>".$val."</option>";
        }
        return $type_name;
    }
}