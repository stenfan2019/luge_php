<?php

use yii\db\Migration;

/**
 * Class m200904_021907_lottery_odds
 * 
 * 彩票玩法
 */
class m200904_021907_lottery_odds extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->execute('SET foreign_key_checks = 0');
        $this->createTable('{{%lottery_odds}}', [
            'id' => 'int(11) unsigned NOT NULL AUTO_INCREMENT',
            'lottery_id' => 'int(10) unsigned NOT NULL  COMMENT \'彩票ID\'',
            'lottery_code' => 'varchar(32) NOT NULL  COMMENT \'彩票编号\'',
            'name' => 'varchar(32) NOT NULL  COMMENT \'玩法名称\'',
            'cate_id' => 'int(10) NOT NULL COMMENT \'分类ids\'',
            'cate_name' => 'varchar(128) NOT NULL COMMENT \'分类名称\'',
            'odds' => 'DECIMAL(8,2)  COMMENT \'彩票赔率\'',
            'sort' => 'int(10) unsigned NOT NULL DEFAULT  \'1\' COMMENT \'显示顺序\'',
            'status' => 'tinyint(3) unsigned NOT NULL DEFAULT \'1\' COMMENT \'是否删除 0为删除，1反之\'',
            'create_time' => 'datetime(0) DEFAULT CURRENT_TIMESTAMP(0) COMMENT \'创建时间\'',
            'update_time' => 'datetime(0) DEFAULT CURRENT_TIMESTAMP(0) COMMENT \'更新时间\'',
            'PRIMARY KEY (`id`)'
        ], "ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='彩票玩法表'");
        $this->execute('SET foreign_key_checks = 0;');
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%lottery_odds}}');
        $this->execute('SET foreign_key_checks = 0;');
    }

    
}
