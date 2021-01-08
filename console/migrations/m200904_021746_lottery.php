<?php

use yii\db\Migration;

/**
 * Class m200904_021746_lottery
 */
class m200904_021746_lottery extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%lottery}}', [
            'id' => 'int(11) unsigned NOT NULL AUTO_INCREMENT',
            'name' => 'varchar(32) DEFAULT \'\' COMMENT \'彩种名称\'',
            'code' => 'varchar(16) DEFAULT \'\' COMMENT \'彩票编号\'',
            'icon_url' => 'varchar(128) DEFAULT \'\' COMMENT \'彩票icon\'',
            'type' => 'char(8) DEFAULT \'low\' COMMENT \'彩票频率\'',
            'sort' => 'int(10) unsigned NOT NULL DEFAULT  \'1\' COMMENT \'显示顺序\'',
            'is_private' => 'tinyint(3) unsigned NOT NULL DEFAULT \'1\' COMMENT \'是否删除 0为官彩，1反之\'',
            'is_index' => 'tinyint(3) unsigned NOT NULL DEFAULT \'0\' COMMENT \'1为首页推荐\'',
            'envelop_time' => 'int(10) unsigned NOT NULL DEFAULT  \'1\' COMMENT \'封盘提前时间\'',
            'status' => 'tinyint(3) unsigned NOT NULL DEFAULT \'1\' COMMENT \'是否删除 0为删除，1反之\'',
            'create_time' => 'datetime(0) DEFAULT CURRENT_TIMESTAMP(0) COMMENT \'创建时间\'',
            'update_time' => 'datetime(0) NOT NULL DEFAULT CURRENT_TIMESTAMP(0) ON UPDATE CURRENT_TIMESTAMP(0) COMMENT \'更新时间\'',
            'PRIMARY KEY (`id`)'
        ], "ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='彩票表'");
        $this->execute('SET foreign_key_checks = 1;');
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%lottery}}');
        $this->execute('SET foreign_key_checks = 1;');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200904_021746_lottery cannot be reverted.\n";

        return false;
    }
    */
}
