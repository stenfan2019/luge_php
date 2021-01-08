<?php
namespace common\models;

use common\helpers\FuncHelper;
use Yii;
use yii\data\Pagination;
class SendPrize extends Base
{

    //等待开奖
    const STATE_PENDING = 'pending';
    //赢
    const STATE_WIN = 'win';
    //输
    const STATE_LOSE    = 'lose';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'live_send_prize';
    }
    
    public function getBetLog($where,$select="*",$page=1,$page_size=20)
    {
        $query = self::find()->alias('S')
               ->where($where)
               ->select($select)
               ->innerJoin('{{%lottery}} L','L.id=S.lottery_id')
               ->innerJoin('{{%lottery_odds}} O','O.id=S.odds_id');
        $countQuery = clone $query;
        $count = $countQuery->count();
        $pages = new Pagination(['totalCount' => $count,'defaultPageSize'=>$page_size,'page'=>$page]);
        $models = $query->offset($pages->offset)
                ->orderBy('S.created desc')
                ->limit($pages->limit)
                ->asArray()->all();
        return ['data'=>$models,'pagination' => $pages];
    }


    /**
     * 获取彩期下的订单
     * @param $lottery_number
     * @return bool
     * @author mike
     * @date 2020-12-03
     */
    public static function getLotteryNumberOrder($lottery_id,$lottery_number)
    {
        $where = [
            'lottery_id'        => $lottery_id,
            'lottery_number'    => $lottery_number,
            'state'             => 'pending'
        ];
        $orderModel =
            self::find()
                ->where($where)
                ->all();
        if(!$orderModel)
            return false; //彩期没有订单 不存在
        return $orderModel;
    }



    /**
     * 根据彩期 派奖
     * @param $pid 彩种ID
     * @param $lottery_number 彩期
     * @author mike
     * @date 2020-12-03
     */
    public static function sendPrize($pid,$lottery_number)
    {
        try {

            //获取彩期开奖结果
            $resultModel = LotteryNumber::getPreLotteryNumber($pid,$lottery_number);
            //获取彩期下的订单
            $orderModel = self::getLotteryNumberOrder($pid,$lottery_number);
            if(!$orderModel){
                $resultModel->state = 3;
                $resultModel->save();
                return '彩期没有未开奖的订单'.PHP_EOL;
            }



            if(!$resultModel) return '彩期不存在或未開獎'.PHP_EOL;
            echo "订单数：".count($orderModel);
            foreach ($orderModel as $order)
            {
                $r = FuncHelper::generateLotteryResult($resultModel->period_code);
                //判定是否中奖
                $bool = LotteryOdds::checkResult($r,$order->odds_id);

                if($bool) //中獎
                {
                    $balance = User::balance($order->user_id,$order->earn_money,UserFundsDeal::I_LOTTERY_WIN,"投注订单号：".$order->order_number);
                    if($balance)
                    {
                        $order->state = 'win';
                        $order->save();
                    }
                }else{//未中奖
                    $order->state = 'lose';
                    $order->save();
                }
            }
            $resultModel->state = 3;
            $resultModel->save();
            exit("派彩完成");
        }catch (\Exception $e)
        {
            exit("错误信息：".$e->getLine().'---'.$e->getMessage());
        }
    }


    public static function getWhereList(array $where,int $page)
    {
        $select = "id,lottery_number,order_number,pay_money,state,created";
        return self::find()
            ->where($where)
            ->select($select)
            ->orderBy('id desc')
            ->limit(self::PAGE_SIZE)
            ->offset(($page-1)*self::PAGE_SIZE)
            ->asArray()
            ->all();
    }


    /**
     * 订单状态
     * @param string $state
     * @return array|bool
     * @author mike
     * @date 2020-12-12
     */
    public static function getState($state="")
    {
        $stateArr = [
            self::STATE_PENDING =>'等待开奖',
            self::STATE_LOSE    => '输',
            self::STATE_WIN     => '赢',
        ];
        if(strlen($state))
            return isset($stateArr[$state])?$stateArr[$state]:'未知';
        return $stateArr;
    }
}