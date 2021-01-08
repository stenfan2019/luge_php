<?php

use yii\db\Migration;

/**
 * Class m200904_021657_anchor_withdraw
 */
class m200904_021657_anchor_withdraw extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
   
        /* 创建表 */
        $this->createTable('{{%anchor_withdraw}}', [
            'id'          => 'int(11) unsigned NOT NULL AUTO_INCREMENT',
            'anchor_id'   => 'int(11) unsigned NOT NULL  COMMENT \'主播ID\'',
            'bank_name'   => 'varchar(32) NOT NULL COMMENT \'银行名称\'',
            'bank_code'   => 'varchar(32) NOT NULL COMMENT \'银行编号\'',
            'bank_number' => 'varchar(32) NOT NULL COMMENT \'银行卡号\'',
            'account'     => 'varchar(32) NOT NULL COMMENT \'收款人\'',
            'bank_address'=> 'varchar(32) NOT NULL COMMENT \'分行地址\'',
            'amount'      => 'varchar(32) NOT NULL COMMENT \'提现金额\'',
            'state'       => 'tinyint(3) unsigned NOT NULL DEFAULT \'1\' COMMENT \'1为申请中,2为拒绝,3为提款完成\'',
            'status'      => 'tinyint(3) unsigned NOT NULL DEFAULT \'1\' COMMENT \'是否删除 0为删除，1反之\'',
            'create_time' => 'datetime(0) DEFAULT CURRENT_TIMESTAMP(0) COMMENT \'创建时间\'',
            'update_time' => 'datetime(0) NOT NULL DEFAULT CURRENT_TIMESTAMP(0) ON UPDATE CURRENT_TIMESTAMP(0) COMMENT \'更新时间\'',
            'PRIMARY KEY (`id`)'
        ], "ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='主播提款表'");
        $this->execute('SET foreign_key_checks = 1;');
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        echo "m200904_021657_anchor_withdraw cannot be reverted.\n";
        $this->dropTable('{{%anchor_withdraw}}');
        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200904_021657_anchor_withdraw cannot be reverted.\n";

        return false;
    }
    */
}
