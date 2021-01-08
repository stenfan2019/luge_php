<?php

use yii\db\Migration;

/**
 * Class m200904_065003_anchor_banks
 */
class m200904_065003_anchor_banks extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%anchor_banks}}', [
            'id' => 'int(11) unsigned NOT NULL AUTO_INCREMENT',
            'anchor_id' => 'int(11) unsigned NOT NULL DEFAULT \'0\' COMMENT \'主播ID\'',
            'bank_code' => 'varchar(10) DEFAULT \'\' COMMENT \'银行编号\'',
            'bank_name' => 'varchar(64) DEFAULT \'\' COMMENT \'银行名称\'',
            'bank_account' => 'varchar(16) DEFAULT \'\' COMMENT \'开户人\'',
            'bank_number' => 'varchar(32) DEFAULT \'\' COMMENT \'银行卡号\'',
            'bank_address' => 'varchar(64) DEFAULT \'\' COMMENT \'开户行\'',
            'status' => 'tinyint(3) unsigned NOT NULL DEFAULT \'1\' COMMENT \'是否删除 0为删除，1反之\'',
            'create_time' => 'datetime(0) DEFAULT CURRENT_TIMESTAMP(0) COMMENT \'创建时间\'',
            'update_time' => 'datetime(0) NOT NULL DEFAULT CURRENT_TIMESTAMP(0) ON UPDATE CURRENT_TIMESTAMP(0) COMMENT \'更新时间\'',
            'PRIMARY KEY (`id`)'
        ], "ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='主播银行卡'");
        $this->execute('SET foreign_key_checks = 1;');
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        echo "m200904_065003_anchor_banks cannot be reverted.\n";
        $this->dropTable('{{%anchor_banks}}');
        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200904_065003_anchor_banks cannot be reverted.\n";

        return false;
    }
    */
}
