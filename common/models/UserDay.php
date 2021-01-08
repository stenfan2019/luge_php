<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "live_user_day".
 *
 * @property int $id
 * @property int $uid 用户ID
 * @property string $uname 用户账号
 * @property string $date 日期
 * @property int $deposit_money 充值金额
 * @property int $deposit_num 充值次数
 * @property int $withdraw_submit_money 提现申请金额
 * @property int $withdraw_submit_num 提现申请次数
 * @property int $withdraw_success_money 提现成功金额
 * @property int $withdraw_success_num 提现成功次数
 * @property int $active_all_money 活动总金额
 * @property int $active_get_money 活动已领金额
 * @property int $bet_money 彩票投注金额
 * @property int $bet_num 彩票投注次数
 * @property int $gift_money 送礼金额
 * @property int $gift_num 送礼次数
 * @property int $get_red_money 领红包金额
 * @property int $get_red_num 领红包次数
 * @property int $send_red_money 发红包金额
 * @property int $send_red_num 发红包次数
 * @property int $back_red_money 中雷金额
 * @property int $back_red_num 中雷次数
 * @property string $updated
 * @property string $created
 */
class UserDay extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'live_user_day';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['date'], 'required'],
            [['id', 'uid', 'deposit_money', 'deposit_num', 'withdraw_submit_money', 'withdraw_submit_num', 'withdraw_success_money', 'withdraw_success_num', 'active_all_money', 'active_get_money', 'bet_money', 'bet_num', 'gift_money', 'gift_num', 'get_red_money', 'get_red_num', 'send_red_money', 'send_red_num', 'back_red_money', 'back_red_num'], 'integer'],
            [['date', 'updated', 'created'], 'safe'],
            [['uname'], 'string', 'max' => 50],
            [['uid', 'date'], 'unique', 'targetAttribute' => ['uid', 'date']],
            [['id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'uid' => 'Uid',
            'uname' => 'Uname',
            'date' => 'Date',
            'deposit_money' => 'Deposit Money',
            'deposit_num' => 'Deposit Num',
            'withdraw_submit_money' => 'Withdraw Submit Money',
            'withdraw_submit_num' => 'Withdraw Submit Num',
            'withdraw_success_money' => 'Withdraw Success Money',
            'withdraw_success_num' => 'Withdraw Success Num',
            'active_all_money' => 'Active All Money',
            'active_get_money' => 'Active Get Money',
            'bet_money' => 'Bet Money',
            'bet_num' => 'Bet Num',
            'gift_money' => 'Gift Money',
            'gift_num' => 'Gift Num',
            'get_red_money' => 'Get Red Money',
            'get_red_num' => 'Get Red Num',
            'send_red_money' => 'Send Red Money',
            'send_red_num' => 'Send Red Num',
            'back_red_money' => 'Back Red Money',
            'back_red_num' => 'Back Red Num',
            'updated' => 'Updated',
            'created' => 'Created',
        ];
    }


    /**
     * 统计用户美丽数据
     * @param string $uid
     * @param string $date
     * @return array|bool
     * @author mike
     * @date 2020-12-25
     */

    public static function computeData($uid = "", $date = "")
    {
        $date = $date ? $date : date('Y-m-d');
        $userList = User::getActiveUser($uid, $date);
        if (!$userList)
            return false;
        $select = "sum(deal_money) as money ,count(*) as num,max(deal_type) as deal_type";
        $date_start = $date . ' 00:00:00';
        $date_end = $date . ' 23:59:59';
        foreach ($userList as $user) {
            $where = [
                'and',
                ['=', 'uid', $user->uid],
                ['between', 'create_time', $date_start, $date_end],
            ];
            $res = UserFundsDeal::find()
                ->where($where)
                ->select($select)
                ->groupBy('deal_type')
                ->asArray()
                ->all();
            if (!$res) //没有数据退出
                continue;

            $userDayModel = self::findOne(['uid' => $user->uid, 'date' => $date]);
            if (!$userDayModel) {
                $userDayModel = new self();
                $userDayModel->uid = $user->uid;
                $userDayModel->date = $date;
                $userDayModel->uname = $user->mobile;
            }

            foreach ($res as $data) {
                if ($data['deal_type'] == UserFundsDeal::I_ORDER_PAYMENT) {
                    $userDayModel->deposit_num = $data['num'];
                    $userDayModel->deposit_money = $data['money'];
                } elseif ($data['deal_type'] == UserFundsDeal::TYPE_WITHDRAW) {
                    $userDayModel->withdraw_submit_num = $data['num'];
                    $userDayModel->withdraw_submit_money = $data['money'];
                } elseif ($data['deal_type'] == UserFundsDeal::TYPE_ACTIVE) {
                    $userDayModel->active_get_money = $data['money'];
                } elseif ($data['deal_type'] == UserFundsDeal::O_LOTTERY_BET) {
                    $userDayModel->bet_num = $data['num'];
                    $userDayModel->bet_money = $data['money'];
                } elseif ($data['deal_type'] == UserFundsDeal::O_ANCHOR_GIVE) {
                    $userDayModel->gift_num = $data['num'];
                    $userDayModel->gift_money = $data['money'];
                } elseif ($data['deal_type'] == UserFundsDeal::I_HBAO_ROB) {
                    $userDayModel->get_red_num = $data['num'];
                    $userDayModel->get_red_money = $data['money'];
                } elseif ($data['deal_type'] == UserFundsDeal::O_HBAO_SEND) {
                    $userDayModel->send_red_num = $data['num'];
                    $userDayModel->send_red_money = $data['money'];
                } elseif ($data['deal_type'] == UserFundsDeal::O_HBAO_HIT) {
                    $userDayModel->back_red_num = $data['num'];
                    $userDayModel->back_red_money = $data['money'];
                }
            }
            $userDayModel->save();
            $error = [];
            if ($userDayModel->errors) {
                $error[] = $userDayModel->errors;
            }
        }
        return $error;
    }


    /**
     * 用户每日数据
     * @param $where
     * @param int $page
     * @param $pageSize
     * @return mixed
     * @author mike
     * @date 2021-01-01
     */
    public static function getPageData($where,$page=1,$pageSize=self::PAGE_SIZE)
    {
        $list['count'] = self::find()->where($where)->count()??0;
        if($list['count']==0)
            return $list;
        $list['list'] = self::find()
            ->where($where)
            ->limit($pageSize)
            ->offset(($page-1)*$pageSize)
            ->orderBy('id DESC')
            ->asArray()
            ->all();
        return $list;
    }

    /**
     * 用户平台数据
     * @param $where
     * @param int $page
     * @param $pageSize
     * @return mixed
     * @author mike
     * @date 2021-01-01
     */
    public static function getSumData($where,$page=1,$pageSize=self::PAGE_SIZE)
    {
        $list['count'] = self::find()->where($where)->select('count(*)')->groupBy('date')->count()??0;
        if($list['count']==0)
            return $list;

        $select = "max(date) as date,sum(deposit_money) as deposit_money,sum(deposit_num) as deposit_num,
        sum(withdraw_success_money) as withdraw_success_money,sum(withdraw_success_num) as withdraw_success_num,
        sum(active_all_money) as active_all_money,sum(active_get_money) as active_get_money,sum(bet_money) as bet_money,
        sum(bet_num) as bet_num,sum(gift_money) as gift_money,sum(gift_num) as gift_num,sum(get_red_money) as get_red_money,
        sum(get_red_num) as get_red_num,sum(send_red_money) as send_red_money,sum(send_red_num) as send_red_num,
        sum(back_red_money) as back_red_money,sum(back_red_num) as back_red_num";
        $list['list'] = self::find()
            ->select($select)
            ->where($where)
            ->limit($pageSize)
            ->offset(($page-1)*$pageSize)
            ->groupBy('date')
            ->orderBy('date DESC')
            ->asArray()
            ->all();
        return $list;
    }


}
