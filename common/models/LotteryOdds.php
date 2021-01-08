<?php
namespace common\models;

use Yii;
class LotteryOdds extends Base
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'live_lottery_odds';
    }


    /**
     * 檢查开奖结果是否中奖
     * @param array $r 开奖结果
     * @param int $odds_id 投注ID
     * @author mike
     * @date 2020-12-03
     */
    public static function checkResult(array $r,$odds_id)
    {
        $oddsModel = LotteryOdds::findOne($odds_id);
        if(!$oddsModel) return false;
        return eval($oddsModel->function);
    }


    public static function getList($page=1,$where=[])
    {
        $select = "*";
        $count = self::find()->where($where)->count();
        $list = self::find()
            ->where($where)
            ->select($select)
            ->limit(self::PAGE_SIZE)
            ->offset(($page-1)*self::PAGE_SIZE)
            ->all();
        return [
            'count' => $count,
            'list' => $list,
        ];
    }
}