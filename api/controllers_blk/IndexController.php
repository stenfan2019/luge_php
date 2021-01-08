<?php
namespace api\controllers;

use common\models\Active;
use common\models\ActiveLog;
use common\models\ActiveType;
use common\models\User;
use common\models\UserFundsDeal;
use yii;
use api\controllers\Base;
use api\models\RoomModel;
use common\models\Notice;
use common\models\Banner;

class IndexController extends Base
{
   
    /**
     * (non-PHPdoc)
     * @see \api\controllers\Base::init()
     */
    public function init(){
       
        $this->openLoginCheck = false;
    }
    
    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
       echo 'hello api';
    }
    
    public function actionRoom()
    {
      
        $roomModel = new RoomModel();
        $data = $roomModel->getIndexRoom();
        $oss_url = Yii::$app->params['oss_url'];

        foreach ($data as $key=>$item){
            $data[$key]['show_pic'] = $oss_url . $data[$key]['show_pic'];
            $data[$key]['avatar'] = $oss_url . $data[$key]['avatar'];
            $data[$key]['category_title'] = '娱乐直播';
            $data[$key]['hot'] = mt_rand(100, 2000);
        }
        $this->success($data);
    }
    
    /**
     * 首页推荐游戏
     * @stenfan
     */
    public function actionGame()
    {
        $data = \common\models\Game::find()
              ->where(['status' => 1])->orderBy('sort ASC')->asArray()->all();
        $oss_url = Yii::$app->params['oss_url'];
        foreach ($data as $key=>$item){
            $data[$key]['icon_url'] = $oss_url . $data[$key]['icon'];
            $data[$key]['name'] =  $data[$key]['game_title'];
            unset($data[$key]['icon'],$data[$key]['game_title']);
            
        }
        $this->success($data);
    }
    
    /**
     * 获取用户公告
     */
    public function actionNotice()
    {
        $type = Yii::$app->request->get('type');
        if(empty($type)){
            $this->error('缺少必要参数');
        }
        $where = "is_show=1 and cate=2";
        if($type){
            $where = $where . " and type=$type";
        }
        $query = Notice::find()
               ->where($where);
       
        $models = $query->orderBy('create_date desc')
                ->limit(1)
                ->one();
        if($models){
            return $this->success($models->toArray());
        }else{
            $this->error('暂无公告');
        }
    }
    
    /**
     * 获取用户公告
     */
    public function actionBanner()
    {
        $site  = Yii::$app->request->get('site',1);
        $query = Banner::find()
                ->where("is_show=1 and cate=2 and site=$site");
        $models = $query->orderBy('create_date desc')
                ->select('title,image,url,type')
                ->orderby('sort')
                ->asArray()->all();
        $oss_url = Yii::$app->params['oss_url'];
        foreach ($models as &$item){
            $item['image'] = $oss_url . $item['image'];
        }
        return $this->success($models);
    }


    /**
     * 获取活动列表
     * @author mike
     * @date 2020-12-30
     */
    public function actionActiveList()
    {
        $page = Yii::$app->request->get('page',1);
        $where = [
            'and',
            ['=','status','1'],
            //添加搜寻条件
        ];
        $data = Active::getPageData($where,$page);
        if($data['count']<=0)
            return $this->error('暂无活动数据');
        $pic_url = Yii::$app->params['oss_url'];
        foreach ($data['list'] as $k => $val)
        {
            $data['list'][$k]['web_pic'] = $pic_url.$val['web_pic'];
            $data['list'][$k]['pc_pic'] = $pic_url.$val['pc_pic'];
            $data['list'][$k]['get_type_name'] = Active::get_type($val['get_type']);
            $data['list'][$k]['type_name'] = ActiveType::getTypeName($val['type']);
            $data['list'][$k]['state_name'] = (strtotime($val['end_time'])>=time())?'正在进行':'已结束';
            unset($data['list'][$k]['condition'],$data['list'][$k]['bonus'],$data['list'][$k]['updated_uid'],
                $data['list'][$k]['status'],$data['list'][$k]['created_uid'],$data['list'][$k]['updated']);
        }

        return $this->success($data);
    }


    /**
     * 活动详情
     * @author mike
     * @date 2020-12-30
     */
    public function actionActiveDetail()
    {
        $id = Yii::$app->request->get('id');
        $detail = Active::findOne($id);
        if(empty($detail))
            return $this->error(Yii::t('index','数据不存在'));

        $data = $detail->toArray();
        unset($data['condition'],$data['bonus'],$data['created_uid'],$data['updated_uid'],$data['updated'],$data['status']);
        $pic_url = Yii::$app->params['oss_url'];
        $data['web_pic'] = $pic_url.$data['web_pic'];
        $data['pc_pic'] = $pic_url.$data['pc_pic'];
        $data['type_name'] = ActiveType::getTypeName($data['type']);
        $data['get_type_name'] = Active::get_type($data['get_type']);
        $data['state_name'] = (strtotime($data['end_time'])>=time())?Active::STATE_VALID:Active::STATE_INVALID;
        return $this->success($data);
    }


    /**
     * 领取奖金
     * @author mike
     * @date 2020-12-30
     */
    public function actionGetBonus()
    {
        $this->checkLogin();
        $uid = $this->userInfo['uid'];
        $id = Yii::$app->request->get('id');
        if (!$id)
            return $this->error('请传递参数');
        $list = ActiveLog::getBonus($uid, $id);
        if (!$list)
            return $this->success(['amount'=>User::balance($uid)],'奖金已全部领取');
        $money = 0;
        $ids = "";
        $idn = 0;
        foreach ($list as $activeLog) {
            $money += $activeLog->money;
            $ids .= $activeLog->id . ",";
            $idn++;
            $activeLog->is_get = ActiveLog::IS_GET_YES;
            $activeLog->last_get_time = date('Y-m-d H:i:s');
            $activeLog->save();
        }
        $memo = "活动ID：".$ids.'已领取';
        if(User::balance($uid,$money,UserFundsDeal::TYPE_ACTIVE,$memo))
            return $this->success(['amount'=>User::balance($uid)],'已成功领取'.$idn.'笔活动奖金');
        return $this->error('领取失败');

    }




}