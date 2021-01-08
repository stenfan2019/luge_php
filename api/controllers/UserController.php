<?php
namespace api\controllers;

use api\controllers\Base;
use common\upload\BulletProof;
use Yii;

class UserController extends Base
{
    public function actionInfo()
    {
        $uid = $this->uid;
        $data = [
            'uid' => $this->user_info['uid'],
            'nick_name' => $this->user_info['nick_name'],
            'mobile' => $this->user_info['mobile'],
            'image' => $this->user_info['image'],
            'amount' => $this->user_info['amount'],
            'level' => $this->user_info['level'],
        ];
        $this->success($data);
        
    }
    
    //修改用户昵称
    public function actionNickname()
    {
        if(Yii::$app->request->isPost){
            $data = Yii::$app->request->post();
            $nick_name = isset($data['nick_name']) ? $data['nick_name'] :'';
            if(empty($nick_name)){
                $this->error('昵称不能为空');
            }
            $this->user_model->nick_name = $nick_name;
            $this->user_model->update_time = time();
            if($this->user_model->update()){
                $this->success([]);
            }else{
                $this->error('修改失败');
            }
        }else{
            $this->error('请求方式错误');
        }
    }
    
    //修改用户头像
    public function actionAvatar()
    {
        if(Yii::$app->request->isPost){
            $data = Yii::$app->request->post();
            $image = isset($data['image']) ? $data['image'] :'';
            if(empty($image)){
                $this->error('图片不能为空');
            }
            $this->user_model->image = $image;
            $this->user_model->update_time = time();
            if($this->user_model->update()){
                $this->success([]);
            }else{
                $this->error('修改失败');
            }
        }else{
            $this->error('请求方式错误');
        }
    }
    
    //修改密码
    public function actionUpwd()
    {
        if(Yii::$app->request->isPost){
            $data = Yii::$app->request->post();
            $old_passwd = isset($data['old_passwd']) ? $data['old_passwd'] : '';
            $passwd = isset($data['passwd']) ? $data['passwd'] : '';
            $re_passwd = isset($data['re_passwd']) ? $data['re_passwd'] : '';
            if(empty($old_passwd) || empty($passwd) || empty($re_passwd)){
                $this->error('缺少必要参数');
            }
            if($old_passwd == $passwd){
                $this->error('旧密码和新密不能一样');
            }
            if($passwd != $re_passwd){
                $this->error('两次密码不一致');
            }
        
            if(!$this->validatePassword($old_passwd, $this->user_model->password)){
                $this->error('密码错误');
            }
            $passwd = Yii::$app->security->generatePasswordHash($passwd);
            $this->user_model->password = $passwd;
            $this->user_model->update_time = time();
            $this->user_model->update();
            $this->success([]);
        }else{
            $this->error('请求方式错误');
        }
    }
    
    public function actionUpload()
    {
         $data = Yii::$app->request->post();
         $newname = Yii::$app->request->post('name');
         $bulletProof = new BulletProof();
         $bulletProof->forFile(false)
                     ->folder(UPLOAD_PATH)
                     ->fileTypes(['jpg', 'jpeg', 'gif', 'png'])
                     ->limitSize(['min' =>1024, 'max' => 10 * 1024 * 1024]);
         $newname = $newname ? [$newname] : '';
         $result = $bulletProof->uploadAll('file',$newname);
         $this->success($result);
                     
    }
}
     