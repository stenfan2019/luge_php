<?php

use yii\db\Migration;

/**
 * Class m201109_103513_funds_deal
 */
class m201109_103513_funds_deal extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%funds_deal}}', [
            'id' => 'int(10) NOT NULL AUTO_INCREMENT',
            'uid' => 'int(10) NULL DEFAULT \'0\' COMMENT \'用户id\'',
            'deal_number' => 'varchar(32) NULL DEFAULT \'\' COMMENT \'交易三方单号\'',
            'deal_type' => 'int(10) NULL  COMMENT \'交易类型\'',
            'deal_money' => 'int(10) NOT NULL COMMENT \'交易金额\'',
            'deal_category' => 'tinyint(3) NOT NULL COMMENT \'交易类型,1为收入2为支出\'',
            'balance' => 'int(32) NULL DEFAULT \'0\' COMMENT \'当前账号金额\'',
            'memo' => 'varchar(32)   NULL  COMMENT \'交易说明\'',
            'create_time' => 'datetime(0) DEFAULT CURRENT_TIMESTAMP(0)  COMMENT \'订单创建时间\'',
            'status' => 'tinyint(1) NOT NULL DEFAULT \'1\' COMMENT \'状态\'',
            'PRIMARY KEY (`id`)'
        ], "ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='现金资金表'");
        
        $this->execute('SET foreign_key_checks = 1;');
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        echo "m201109_103513_funds_deal cannot be reverted.\n";
        $this->dropTable('{{%funds_deal}}');
        return false;
    }

   
}
