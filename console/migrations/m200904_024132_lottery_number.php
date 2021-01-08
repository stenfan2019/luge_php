<?php

use yii\db\Migration;

/**
 * Class m200904_024132_lottery_number
 */
class m200904_024132_lottery_number extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%lottery_number}}', [
            'id' => 'int(11) unsigned NOT NULL AUTO_INCREMENT',
            'lottery_number' => 'varchar(32) DEFAULT \'\' COMMENT \'彩种期号\'',
            'lottery_code' => 'varchar(16) DEFAULT \'\' COMMENT \'彩票编号\'',
            'lottery_name' => 'varchar(128) DEFAULT \'\' COMMENT \'彩票名称\'',
            'pid' => 'char(8)  COMMENT \'彩票频率\'',
            'type' => 'char(8) COMMENT \'彩票频率\'',
            'start_time' => 'datetime(0)  COMMENT \'开售时间\'',
            'envelop_time' => 'datetime(0)  COMMENT \'封盘时间\'',
            'status' => 'tinyint(3) unsigned NOT NULL DEFAULT \'1\' COMMENT \'是否删除 0为删除，1反之\'',
            'create_time' => 'datetime(0) DEFAULT CURRENT_TIMESTAMP(0) COMMENT \'创建时间\'',
            'update_time' => 'datetime(0) NOT NULL DEFAULT CURRENT_TIMESTAMP(0) ON UPDATE CURRENT_TIMESTAMP(0) COMMENT \'更新时间\'',
            'PRIMARY KEY (`id`)'
        ], "ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='彩期表'");
        $this->execute('SET foreign_key_checks = 1;');
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%lottery_number}}');
        $this->execute('SET foreign_key_checks = 1;');
    }

   
}
