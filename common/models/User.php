<?php

namespace common\models;

use common\models\core\FundsDealLog;
use Yii;
use yii\db\Exception;

/**
 * This is the model class for table "live_user".
 * 用户表
 *
 * @property string $uid
 * @property string $username 账号
 * @property string $mobile 手机
 * @property string $email 邮箱，预留之后
 * @property string $password 密码
 * @property string $salt 密码盐
 * @property string $image 头像路径
 * @property int $score 当前余额
 * @property int $score_all 总余额
 * @property int $amount 金额
 * @property int $reg_time 注册时间
 * @property int $reg_ip 注册IP
 * @property int $last_login_time 最后登录时间
 * @property int $last_login_ip 最后登录IP
 * @property int $update_time
 * @property int $tuid 推荐id
 * @property int $allowance
 * @property int $allowance_updated_at
 * @property int $status 是否删除 0为删除，1反之
 */
class User extends Base
{
    static $field_title = [
        'type'   => ['1' => '用户', '2' => '测试号'],
        'source'   => ['H5' => '移动H5', 'Android' => '安卓','IOS' => '苹果','SYSTEM' => '系统'],
        'is_freeze'  => ['0' => '正常', '1' => '<font color="red">冻结</font>'],
        'level'  => [
            '1'  => 'VIP1',
            '2'  => 'VIP2',
            '3'  => 'VIP3',
            '4'  => 'VIP4',
            '5'  => 'VIP5',
            '6'  => 'VIP6',
            '7'  => 'VIP7',
            '8'  => 'VIP8',
            '9'  => 'VIP9',
            '10' => 'VIP10',
            '11' => 'VIP11',
            '12' => 'VIP12'
        ]
    ];
    
    static $search = [
        'uid'      => 'UID',
        'username' => '用户昵称',
        'mobile'   => '注册手机号',
        'reg_ip'   => '注册IP'
    ];
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'live_user';
    }

    /**
     * {@inheritdoc}
     */
   /* public function rules()
    {
        return [
            [['username', 'salt'], 'required'],
            [['score', 'score_all', 'agent_id', 'follower', 'reg_time', 'reg_ip', 'last_login_time', 'last_login_ip', 'status'], 'integer'],
            [['create_time', 'update_time'], 'safe'],
            [['username', 'password'], 'string', 'max' => 64],
            [['mobile'], 'string', 'max' => 11],
            [['nickname'], 'string', 'max' => 16],
            [['email'], 'string', 'max' => 32],
            [['salt','score_all'], 'string', 'max' => 8],
            [['descript', 'image'], 'string', 'max' => 250],
            [['score'], 'string', 'max' => 16],
            [['username'],'unique'],
        ];
    }*/

    /**
     * {@inheritdoc}
     */
    /*public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => '账号',
            'nickname' => '昵称',
            'mobile' => '手机号',
            'email' => '邮箱',
            'password' => '密码',
            'salt' => '密码盐',
            'descript' => '个人简介',
            'image' => '头像路径',
            'score' => '当前余额',
            'score_all' => '总余额',
            'agent_id' => '所属代理 0为公司直属',
            'follower' => '关注人数',
            'reg_time' => '注册时间',
            'reg_ip' => '注册IP',
            'last_login_time' => '最后登录时间',
            'last_login_ip' => '最后登录IP',
            'status' => '是否删除 0为删除，1反之',
            'create_time' => '创建时间',
            'update_time' => '更新时间',
        ];
    }*/

    /**
     * 设置加密后的密码
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * 设置密码干扰码
     */
    public function generateAuthKey()
    {
        $this->salt = Yii::$app->security->generateRandomString();
    }


    /**
     * 用户金额操作
     * @param $uid
     * @param int $money
     * @author mike
     * @date 2020-12-02
     */
    public static function balance($uid,$money=0,$deal_type="",$memo="")
    {
        $model = self::findOne($uid);
        if($money == 0)
        {
            return $model->amount;
        }else{

            $transaction = Yii::$app->db->beginTransaction();
            try {
                $model->amount += $money;
                $model->update_time = time(); //更新为当前时间
                $model->save();
                //UserFundsDeal::addData($uid,$deal_type,$money,$memo);
                UserFundsDeal::addData($uid,$money,$deal_type,$memo);//update stenfan
                $transaction->commit();
                return true;
                
            }catch (\Exception $e)
            {
                $transaction->rollBack();
                return false;
                
            }
        }
    }
    
    public static function getAvatar($gender=1)
    {
        $avatar = 'B017.jpg';
        if($gender == 1){
            $n = mt_rand(1,43);
            $n = str_pad($n,3,"0",STR_PAD_LEFT);
            $avatar = "B$n.jpg";
        }else{
            $n = mt_rand(1,26);
            $n = str_pad($n,3,"0",STR_PAD_LEFT);
            $avatar = "G$n.jpg";
        }
        return "avatar/$avatar";
    }


    /**
     * 获取七天内活跃的用户
     * @author mike
     * @date 2020-12-11
     */
    public static function getTodayActiveUser()
    {
        $where = [
            'and',
            ['>','update_time',strtotime('-7 days')]
        ];

        $select ="*";
        return self::find()
            ->where($where)
            ->select($select)
            ->all();
    }


    /**
     * 根据UID获取账号
     * @param $uid
     * @return string
     * @author mike
     * @date 2020-12-25
     */
    public static function getIdName($uid)
    {
        $model = self::findOne(['uid'=>$uid]);
        if(!$model)
            return '';
        return $model->mobile;

    }


    /**
     * 获取某一天之后有活跃的用户
     * @param string $uid 指定的uid
     * @param string $date 指定日期
     * @author mike
     * @date 2020-12-25
     */
    public static function getActiveUser($uid="",$date="")
    {
        $userWhere = [
            'and',
            ['>','updated',$date]
        ];
        if($uid)
        {
            $userWhere[] = ['=','uid',$uid];
        }
        return User::find()
            ->where($userWhere)
            ->all();
    }

}
