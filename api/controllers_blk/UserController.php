<?php
namespace api\controllers;

use api\controllers\Base;
use Yii;
use api\models\AnchorModel;
use common\models\UserFollow;
use common\models\UserFundsDeal;
use common\models\User;
use common\models\Anchor;
use common\models\SendPrize;


class UserController extends Base
{
    
    /**
     * 获取用户信息
     */
    public function actionInfo()
    {
        $uid = $this->uid;
        $one = User::findOne($uid);
        $oss_url = Yii::$app->params['oss_url'];
        $r = "/http[s]?:\/\/[\w.]+[\w\/]*[\w.]*\??[\w=&\+\%]*/is";
        if(!preg_match($r,$userinfo['image'])){
          
           $userinfo['image'] = $oss_url . $userinfo['image'];
        }
        
        $userinfo['amount']   = sprintf("%.2f",$one->amount / 100);
        $userinfo['give_gift']   = sprintf("%.2f",$one->give_gift / 100);
        $userinfo['give_game']   = sprintf("%.2f",$one->give_game / 100);
        $userinfo['withdraw']   = sprintf("%.2f",$one->withdraw / 100);
        $userinfo['username']   = $one->username;
        $userinfo['image']      = $oss_url . $one->image;
        
        return $this->success($userinfo);
    }
    
    public function actionBanks()
    {
        
    }
    
    public function actionWallet()
    {
        $userinfo = $this->userInfo;
        $uid = $userinfo['uid'];
        $one = User::findOne($uid);
        $data = [
            'amount'        => sprintf("%.2f",$one->amount / 100),
            'give_gift'     => sprintf("%.2f",$one->give_gift / 100),
            'give_game'     => sprintf("%.2f",$one->give_game / 100),
            'withdraw'      => sprintf("%.2f",$one->withdraw / 100),
        ];
        return $this->success($data);
    }
    /**
     * 关注主播
     * @param int $id
     */
    public function actionFollow($id)
    {
        $userinfo = $this->userInfo;
        $uid = $userinfo['uid'];
        $anthor_model = Anchor::findOne($id);
        if(empty($anthor_model)){
            return $this->error('主播不存在');
        }
        $user_follow_model = UserFollow::find()->where("user_id=$uid and anchor_id=$id")->one();
        if(empty($user_follow_model)){
            $time = time();
            $date = date('Y-m-d H:i:s',$time);
            $userFollow = new UserFollow();
            $userFollow->anchor_id = $id;
            $userFollow->user_id = $uid;
            $userFollow->status = 1;
            $userFollow->create_time = $date;
            $userFollow->update_time = $date;
            if($userFollow->save()){
                //主播粉丝数量加1
                
                $anthor_model->fans ++;
                $anthor_model->update();
                //用户关注数量+1
                $user_model = User::findOne($uid);
                $user_model->follow ++;
                $user_model->update();
                return $this->success([],'success');
            }
            return $this->error('关注失败');
        }
        return $this->error('不能重复关注');
    }
    
    //是否关注
    public function actionIsfollow($id)
    {
        $userinfo = $this->userInfo;
        $uid = $userinfo['uid'];
        $anthorModel = new AnchorModel();
        $anthor = $anthorModel->getAnchorById($id);
        if($anthor){
            $follow = UserFollow::find()->where("user_id=$uid and anchor_id=$id")->one();
            if($follow){
                return $this->success([],'success');
            }else{
                return $this->error('未关注');
            }
        }else{
            return $this->error('主播不存在');
        }
    }
    
    //取消关注
    public function actionUnfollow($id)
    {
        $userinfo = $this->userInfo;
        $uid = $userinfo['uid'];
        $anthor_model = Anchor::findOne($id);
        if(empty($anthor_model)){
            return $this->error('主播不存在');
        }
        $user_follow_model = UserFollow::find()->where("user_id=$uid and anchor_id=$id")->one();
        if($user_follow_model){
            if($user_follow_model->delete()){
                //主播粉丝数量加1
                
                $anthor_model->fans --;
                $anthor_model->update();
                //用户关注数量+1
                $user_model = User::findOne($uid);
                $user_model->follow --;
                $user_model->update();
                return $this->success([],'success');
            }
            return $this->error('取消关注失败');
        }else{
            return $this->error('您没有关注此主播');
        }
        
    }
    
    public function actionGetfollow()
    {
        $userinfo = $this->userInfo;
        $uid = $userinfo['uid'];
        $anthorModel = new AnchorModel();
        $data = $anthorModel->getFollowList($uid);
        $oss_url = Yii::$app->params['oss_url'];
        
        foreach ($data as $key=>$item){
            $data[$key]['avatar'] = $oss_url . $data[$key]['avatar'];
        }
        return $this->success($data);
    }
    
    public function actionStstoken()
    {
        $this->_http();
    }
    
    /**
     * 获取交易类型
     */
    public function actionGetdealtype()
    {
        $types = UserFundsDeal::$type;
        $data = [];
        foreach ($types as $k=>$v){
            if($k < 200){
                $data['in'][$k] = $v;
            }else{
                $data['out'][$k] = $v;
            }
        }
        return $this->success($data);
    }
    
    public function actionPwd()
    {
        $uid = $this->userInfo['uid'];
        if(Yii::$app->request->isPost){
            $data = Yii::$app->request->post();
            $model = User::findOne($uid);
            $old_passwd = isset($data['old_passwd']) ? $data['old_passwd'] : '';
            $passwd = isset($data['passwd']) ? $data['passwd'] : '';
            $re_passwd = isset($data['re_passwd']) ? $data['re_passwd'] : '';
            if(empty($old_passwd) || empty($passwd) || empty($re_passwd)){
                return $this->error('缺少必要参数');
            }
            if($passwd != $re_passwd){
                return $this->error('两次密码不一致');
            }
            
            if(!Yii::$app->security->validatePassword($old_passwd, $model->password)){
                return $this->error('密码错误');
            }
            $passwd = Yii::$app->security->generatePasswordHash($passwd);
            $model->password = $passwd;
            $model->update_time = time();
            $model->update();
            return $this->success('success');
        }else{
            return $this->error('请求方式错误');
        }
    }
    
    //修改用户信息
    public function actionUpinfo()
    {
        $uid = $this->userInfo['uid'];
        if(Yii::$app->request->isPost){
            $data = Yii::$app->request->post();
            $model = User::findOne($uid);
            $nickname = isset($data['nickname']) ? $data['nickname'] : '';
            if($nickname){
                $model->username = $nickname;
            }
            $image = isset($data['image']) ? $data['image'] : '';
            if($image){
                $model->image = $image;
            }
            $model->update_time = time();
            $model->update();
            return $this->success('success');
        }else{
            return $this->error('请求方式错误');
        }
    }
    
    public function actionGamebbiao()
    {
        $uid = $this->userInfo['uid'];
        $type  = Yii::$app->request->get('type');
        $page  = Yii::$app->request->get('page',1);
        $where = '';
        $time = time();
        switch ($type){
            case 'day':
                $date = date('Y-m-d 00:00:00',$time);
                $where = "'{$date}' <= created";
                break;
            case 'yesterday':
                $date = date('Y-m-d 00:00:00',$time-86400);
                $edate = date('Y-m-d 00:00:00',$time);
                $where = "'{$date}' <=  created and created <= '{$edate}'";
                break;
            case 'week':
                $date = date('Y-m-01 00:00:00',$time-86400 * 7);
                $where = "'{$date}' <= created";
                break;
            default:
                $this->error('参数错误');
                break;
        }
        $condition = [
            'and',
            ['=','user_id',$uid],
            ['>','created',$date],
        ];
        $list = SendPrize::getWhereList($condition,$page);//详情
        foreach ($list as $key => $sendprize)
        {
            $data['list'][$key] = $sendprize;
            $data['list'][$key]['pay_money'] = number_format($sendprize['pay_money']/100,2);
            $data['list'][$key]['state_name'] = SendPrize::getState($sendprize['state']);

        }
        $models = SendPrize::find()
                    ->where($where . " and user_id=$uid")
                    ->select('sum(pay_money) as taotal,user_id')
                    ->asArray()->one();
        $data['bet_amount'] = sprintf("%.2f",$models['taotal'] / 100);
        $models = SendPrize::find()
                    ->where($where . " and user_id=$uid and state='win'")
                    ->select('sum(money) as taotal,user_id')
                    ->asArray()->one();
        $data['win_amount'] = sprintf("%.2f",$models['taotal'] / 100);
        return $this->success($data);
    }
   
    
}