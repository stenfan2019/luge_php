<?php
namespace admin\models;

use common\core\redis\AdminRedis;
use Yii;
use yii\base\NotSupportedException;
use yii\data\Pagination;
use yii\web\IdentityInterface;

class Admin extends Base implements IdentityInterface
{
    const STATUS_DELETED = 0;
    const STATUS_ACTIVE  = 1;


    public $salt;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'live_admin';
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
     * 根据UID获取账号信息
     */
    public static function findIdentity($uid)
    {
        return static::findOne(['id' => $uid]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * 根据用户名获取账号信息
     *
     * @param string $username
     * @return \backend\models\Admin|null
     */
    public static function findByUsername($username)
    {

        return self::find()->where(['username' => $username])->one();

    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return boolean
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public static function getName($uid="")
    {
        $info = self::getAdminInfo($uid);
        if($info)
            return $info['username'];
        return '';
    }


    /**
     * 获取UID
     * @return mixed
     * @author mike
     * @date 2020-12-18
     */
    public static function getUid()
    {
        return Yii::$app->session->get('__id');
    }

    /**
     * 管理员信息
     * @return array|bool|mixed|\yii\db\ActiveRecord|null
     * @author mike
     * @date 2020-12-18
     */
    public static function getAdminInfo($uid="")
    {
        if(!$uid)
            $uid = self::getUid();
        $key = \common\models\Admin::$pre_key.$uid;
        $info = AdminRedis::get($key);
        if(!$info)
        {
            $info = \common\models\Admin::find()->where(['id'=>$uid])->asArray()->one();
            if($info)
                AdminRedis::set($key,$info, 7200);
        }
        return $info;

    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->salt;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * 验证密码
     *
     * @param string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password);
    }

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
        $this->salt = '';
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password = null;
    }
}
