<?php
namespace api\controllers;

use api\controllers\Base;
use Yii;
use api\models\UserBanksModel;

class BankController extends Base
{
    /**
     * 
     * 获取配置的银行列表
     * 
     * @author stenfan
     */
    public function actionList()
    {
        $banks = Yii::$app->params['bank_list'];
        return $this->success($banks);
    }
    
    public function actionMy()
    {
        $userinfo = $this->userInfo;
        $anchorBanks = new UserBanksModel();
        $all_bank_list = $anchorBanks->getBankList($userinfo['uid']);
        $data['max_number'] = Yii::$app->params['bank_max_bind'];
        $data['list'] = $all_bank_list;
        return $this->success($data);
    }
    
    public function actionAdd()
    {
        $userinfo = $this->userInfo;
        $arr = Yii::$app->request->post();
        $bank_code = array_key_exists('bank_code', $arr) ? $arr['bank_code'] : '';
        $bank_number = array_key_exists('bank_number', $arr) ? $arr['bank_number'] : '';
        $bank_address = array_key_exists('bank_address', $arr) ? $arr['bank_address'] : '';
        $bank_account = array_key_exists('bank_account', $arr) ? $arr['bank_account'] : '';
        if(empty($bank_code) || empty($bank_number) 
            || empty($bank_address) || empty($bank_account)){
            return $this->error('缺少必要参数');
        }
        if(strlen($bank_number) < 16 || strlen($bank_number) > 19)
        {
            return $this->error('卡号不是16-19位');
        }
        $anchorBanks = new UserBanksModel();
        if($anchorBanks->checkNumberIsExist($bank_number)){
            return $this->error('银行卡已经存在');
        }
        $banks = Yii::$app->params['bank_list'];
        if(!array_key_exists($bank_code, $banks)){
            return $this->error('银行编号错误');
        }
        $bank_max_bind = Yii::$app->params['bank_max_bind'];
        //判断绑定的卡号是否超过限制
        $all_bank_list = $anchorBanks->getBankList($userinfo['uid']);
        if(count($all_bank_list) >= $bank_max_bind){
            return $this->error("最多只能绑定{$bank_max_bind}张银行卡");
        }
      
        $data = $arr;
        $data['bank_name'] = $banks[$bank_code];
        $data['uid'] =   $userinfo['uid'];
        $data['status'] =   1;
        if($anchorBanks->addBank($data)){
            return $this->success($data);
        }else{
            return $this->error('银行添加失败');
        }
        
    }
    
    public function actionDel()
    {
        $userinfo = $this->userInfo;
        $anchorBanks = new UserBanksModel();
        $arr = Yii::$app->request->post();
        $id = $arr['id'];
        if($anchorBanks->delBank($userinfo['uid'], $id)){
            return $this->success([],'删除成功');
        }else{
            return $this->error('银行卡删除失败');
        }
    }
}