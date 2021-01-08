<?php
namespace common\models;
use common\models\utils\Encrypt;
use Yii;
class BankAccount extends Base
{
    private static $key = '4sXwiNa89ZbTJHz5';
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'live_bank_account';
    }
    
    /**
     * 加密
     *
     * @param string $data
     * @return string
     */
    public static function  RSAEncrypt(string $data = null)
    {
        if (!strlen($data)) {
            return $data;
        }
        $mt  = new Encrypt(self::$key);
        return $mt->encrypt($data) ?? $data;
    }
    
    /**
     * 解密
     *
     * @param string $data
     * @return null|string
     */
    public static function RSADecrypt(string $data = null)
    {
        if (!strlen($data)) {
            return $data;
        }
        
        $mt  = new Encrypt(self::$key);
        // todo: 如果无法还原，返回空还是原加密字串？
        return $mt->decrypt($data) ?? '';//$data;
    }
}