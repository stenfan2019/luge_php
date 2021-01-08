<?php
namespace common\models;
use common\helpers\ArrayHelper;
use common\helpers\FuncHelper;
use services\Helper\Helper;
use services\LotteryOrder;
use Yii;
use yii\data\Pagination;

class UserFundsDeal extends Base
{
    //主播打赏
    const O_ANCHOR_GIVE = 101;
    
    //彩票投注
    const O_LOTTERY_BET = 100;

    //提现
   // const TYPE_WITHDRAW = 102;
    
    //发红包
    const O_HBAO_SEND = 103;
    
    //红包中雷
    const O_HBAO_HIT = 104;
    
    //系统扣除
    const O_SYSTEM = 105;
    
    //提现扣除
    const O_WITHDRAW = 106;
    
    //充值
    const I_ORDER_PAYMENT = 200;

    //活动
    const TYPE_ACTIVE   = 201;
    
    //派彩中奖
    const I_LOTTERY_WIN = 202;
    
    //抢红包
    const I_HBAO_ROB = 205;
    
    //红包派奖
    const I_HBAO_WIN = 206;
    
    //系统派发
    const I_SYSTEM = 207;
    
    //红包退回
    const I_HBAO_RECYCLE = 208;
    
    //提现退回
    const I_WITHDRAW = 209;
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'live_funds_deal';
    }
    
   

    public static $type = [
        //支出
        '100'   =>  '开房扣除',
        //'101'   =>  '打赏主播',
       // '102'   =>  '提现',
        //'103'   =>  '发红包',
        //'104'   =>  '红包中雷',
        '105'   =>  '系统扣除',
        //'106'   =>  '提现扣除',
        //收入
        //'200'   => '充值',
        '201'   => '活动赠送',
        //'202'   => '中彩派奖',
        //'203'   => '购彩退还',
        //'204'   => '追号退还',
        //'205'   => '抢红包',
        //'206'   => '红包中奖',
        '207'   => '系统奖励',
       // '208'   => '红包退回',
        //'209'   => '提现退回'
    ];
    
    static $field_title = [
        'deal_category'   => ['1' => '收入', '2' => '支出']
       
    ];

    //获取用户礼物记录
    public function getDealList($where,$select="*",$page=1,$page_size=20)
    {
        $query = self::find()
                ->where($where)
                ->select($select);
        $countQuery = clone $query;
        $count = $countQuery->count();
        $pages = new Pagination(['totalCount' => $count,'defaultPageSize'=>$page_size,'page'=>$page]);
        $models = $query->offset($pages->offset)
                ->orderBy('create_time desc')
                ->limit($pages->limit)
                ->asArray()->all();
        return ['data'=>$models,'pagination' => $pages];
    }


    /**
     * 交易记录
     * @param $uid
     * @param $deal_type
     * @param $deal_money
     * @param string $memo
     * @author mike
     * @date 2020-12-02
     */
    public static function addData($uid,$deal_money,$deal_type,$memo="")
    {

        $model = new self();
        $model->uid = $uid;
        $model->deal_type = $deal_type;
        $model->deal_money = $deal_money;
        $model->deal_number = FuncHelper::createRandNum();
        $model->deal_category = ($deal_money>0)?1:2;
        $model->balance = User::balance($uid);
        $model->memo = $memo;
        $model->create_time = date('Y-m-d H:i:s');
        return $model->insert();

        return $model->errors;
    }
}