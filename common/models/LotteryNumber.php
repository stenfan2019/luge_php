<?php
namespace common\models;

use Yii;

/**
 * This is the model class for table "live_lottery_number".
 * 彩票彩种表
 *
 * @property string $id
 * @property string $lottery_number 期号
 * @property string $lottery_code  彩票代码
 * @property string $lottery_name  彩票名称
 * @property int $pid 彩票id
 * @property int $type 彩票频率
 * @property string $start_time 开始时间
 * @property string $end_time 开奖时间
 * @property string $envelop_time 封盘时间
 * @property string $period_code 开奖号码
 * @property int $n1 开奖号码1
 * @property int $n2 开奖号码2
 * @property int $n3 开奖号码3
 * @property int $n4 开奖号码4
 * @property int $n5 开奖号码5
 * @property int $n6 开奖号码6
 * @property int $n7 开奖号码7
 * @property int $n8 开奖号码8
 * @property int $n9 开奖号码9
 * @property int $n10 开奖号码10
 * @property int $state 1为等待开奖，2为等待派奖,3为已经派奖,4为派奖失败
 * @property int $status 是否删除 0为删除，1反之
 * @property string $create_time 创建时间
 * @property string $update_time 更新时间
 *
 */
class LotteryNumber extends Base
{
    static $field_title = [
        'type' => ['low' => '低频彩', 'high' => '高频彩'],
        'state' => ['1' => '待开奖', '2' =>'待派奖','3' => '已派奖','4' => '派奖失败'],
        'status' => ['0' => '删除', '1' =>'正常'],
    ];

    //开奖结果返回数组
    const RESULT_ARRAY   ='array';
    //开奖结果但会字符串
    const RESULT_STRING  = 'string';
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'live_lottery_number';
    }
    
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['lottery_number', 'lottery_code','lottery_name','type','pid'], 'required'],
            [['pid', 'status'], 'integer']
        ];
    }
    
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'             => 'ID',
            'lottery_number' => '彩票期号',
            'lottery_code'   => '彩票编号',
            'lottery_name'   => '彩票名称',
            'pid'            => '彩种id',
            'type'           => '彩票频率',
            'sort'           => '排序',
            'is_private'     => '私彩',
            'start_time'     => '开售时间',
            'end_time'       => '结束时间',
            'envelop_time'   => '封盘时间',
            'period_code'    => '开奖号码',
            'state'          => '彩期状态',
            'status'         => '是否删除 0为删除，1反之',
            'create_time'    => '创建时间',
            'update_time'    => '更新时间',
        ];
    }
    
    /**
     * 获取游戏开奖历史
     * 按照游戏分类
     */
    public function getLotteryHistory($pid)
    {
        $data = self::find()
              ->select('lottery_number,lottery_name,pid,lottery_code,period_code,state,n1,n2,n3,n4,n5,n6,n7,n8,n9,n10')
              ->where(['pid' => $pid,'state' => [3,4]])
              ->orderBy('update_time ASC')
              ->asArray()->one();
        return $data;
    }
    
    /**
     * 获取游戏开奖历史
     * 按照游戏分类
     */
    public function getLotteryOneHistory($pid)
    {
        $data = self::find()
                ->select('lottery_number,lottery_name,pid,lottery_code,period_code,state,n1,n2,n3,n4,n5,n6,n7,n8,n9,n10')
                ->where(['pid' => $pid,'state' => [3,4]])
                ->orderBy('lottery_number DESC')
                ->limit(20)
                ->asArray()->all();
        return $data;
    }
    
    /**
     * 获取游戏开奖历史
     * 按照游戏分类
     */
    public function getLotteryNumber($pid)
    {
        $date  = date('Y-m-d H:i:s',time());
        $where = "pid=$pid and state=1 and envelop_time >= '{$date}'";
        $data = self::find()
                ->select('lottery_number,lottery_name,pid,lottery_code,state,start_time,end_time,envelop_time')
                ->where($where)
                ->orderBy('lottery_number ASC')
                ->limit(20)
                ->asArray()->all();
        return $data;
    }
    
    /**
     * 获取近10期出售的彩期
     * @author stenfan
     */
    public function getSellLotteryNumber($pid)
    {
        $date  = date('Y-m-d H:i:s',time());
        $where = "pid=$pid  and envelop_time >= '{$date}'";
        $data = self::find()
                ->select('lottery_number,lottery_name,pid,lottery_code,state,start_time,end_time,envelop_time')
                ->where($where)
                ->orderBy('lottery_number ASC')
                ->limit(20)
                ->asArray()->all();
        return $data;
    }


    /**
     * @name 获取当前彩期
     * @param $pid 彩票ID
     * @param string $lottery_number (可选) 传递要验证的彩期是否是当前彩期
     * @return array|\yii\db\ActiveRecord|null
     * @author mike
     * @date 2020-12-02
     */
    public static function getNowLotteryNumber($pid,$lottery_number="")
    {
        $now = date('Y-m-d H:i:s');
        $where = [
            'and',
            ['=','pid',$pid],
            ['>','end_time',$now],
            ['<','start_time',$now],
        ];
        $select = "*";
        $res = self::find()
            ->where($where)
            ->select($select)
            ->one();
        if($lottery_number)
        {
            if(isset($res->lottery_number) && $lottery_number==$res->lottery_number)
            {
                return  true; //改彩期未正在进行
            }
            return false;//改彩期未开始或已结束
        }
        return $res;
    }


    /**
     * 获取最新一期开奖的彩期结果
     * @param $pid 彩种ID
     * @param $lottery_number （可选）指定的彩期
     * @author mike
     * @date 2020-12-03
     */
    public static function getPreLotteryNumber($pid,$lottery_number="")
    {
        $where = [
            'and',
//            ['=','state',2],
            ['=','pid',$pid]
        ];
        if($lottery_number)
        {
            $where[] = ['=','lottery_number',$lottery_number];
        }
        $select = "*"; //预留，上线之后修改为所需字段
        return self::find()
            ->where($where)
            ->select($select)
            ->orderBy('id DESC')
            ->one();
    }

    /**
     * @param string $type string 返回字符串 ，array 返回数组
     * @author mike
     * @date 2020-12-07
     */
    public static function generateKSResult($type=self::RESULT_ARRAY)
    {
        $result = [];
        for($i=0;$i<3;$i++)
        {
            $result[] = rand(1,6);
        }
        if($type == self::RESULT_STRING)
        {
            $string ="";
            foreach ($result as $res )
            {
                $string .= $res;
            }
            return $string;
        }
        return $result;
    }




    /**
     * 获取最近的开奖结果
     * @param string $lottery_id
     * @param string $lottery_number
     * @author mike
     * @date 2020-12-07
     */
    public static function getBeforeLotteryNumber($pid="",$limit= 2)
    {
        $now_time = date('Y-m-d H:i:s');
        $select = "*";
        $where = [
            'and',
            ['<','end_time',$now_time],
        ];
        if($pid)
            $where[] = ['=','pid',$pid];
        return self::find()
            ->where($where)
            ->select($select)
            ->orderBy('end_time DESC')
            ->limit($limit) //最多往前处理limit期
            ->all();
    }


    /**
     * @param string $pid 彩种ID
     * @param string $limit 期数
     * @return array
     * @author mike
     * @date 2020-12-07
     */
    public static function open($pid="",$limit="")
    {

            $res = self::getBeforeLotteryNumber($pid ,$limit);
            $list = [];
            foreach ($res as $lotteryNumber) {
                /*if($lotteryNumber->state !=1)//暂时注销 state=1表示没有注单等待开奖，2，表示有注单等待开奖
                    continue;*/
                $period = self::generateKSResult();
                $lotteryNumber->state = 2;
                $lotteryNumber->period_code = self::generateKSResult(self::RESULT_STRING);
                for ($i = 0; $i < count($period); $i++) {
                    $ni = 'n' . ($i + 1);
                    $lotteryNumber->$ni = $period[$i];
                }
                $lotteryNumber->n4 = 88;
                $lotteryNumber->save();
                $list[]=[
                    'pid' => $lotteryNumber->pid,
                    'lottery_number'=>$lotteryNumber->lottery_number
                ];
                echo $lotteryNumber->pid .'-'. $lotteryNumber->lottery_number.'开奖完成' . PHP_EOL;
            }
            return $res;
    }


}