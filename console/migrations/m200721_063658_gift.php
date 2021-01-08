<?php

use yii\db\Migration;

/**
 * Class m200721_063658_gift
 * 礼物配置
 */
class m200721_063658_gift extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        echo "m200721_054154_anchor is creating.\n";
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');

        /* 创建表 */
        $this->createTable('{{%gift}}', [
            'id' => 'int(11) unsigned NOT NULL AUTO_INCREMENT',
            'title' => 'varchar(20) NOT NULL DEFAULT \'\' COMMENT \'礼物名称 ，建议不超过12个字节\'',
            'descript' => 'varchar(200) DEFAULT \'\' COMMENT \'简单介绍\'',
            'image_mall' => 'char(255) NOT NULL COMMENT \'展示图片\'',
            'image_big' => 'char(255) NOT NULL COMMENT \'送出效果\'',
            'show_on' => 'tinyint(3) NOT NULL DEFAULT \'0\' COMMENT \'效果图展示 1为展示，0反之\'',
            'price' => 'int(11) NOT NULL DEFAULT \'0\' COMMENT \'价格\'',
            'platform_harvest' => 'int(11) NOT NULL DEFAULT \'0\' COMMENT \'平台抽取金额\'',
            'status' => 'tinyint(3) unsigned NOT NULL DEFAULT \'1\' COMMENT \'是否删除 0为删除，1反之\'',
            'create_time' => 'datetime(0) DEFAULT CURRENT_TIMESTAMP(0) COMMENT \'创建时间\'',
            'update_time' => 'datetime(0) NOT NULL DEFAULT CURRENT_TIMESTAMP(0) ON UPDATE CURRENT_TIMESTAMP(0) COMMENT \'更新时间\'',
            'PRIMARY KEY (`id`)'
        ], "ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='礼物配置表，配置后同步到redis等内存中'");
        $this->execute('SET foreign_key_checks = 1;');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%gift}}');
        $this->execute('SET foreign_key_checks = 1;');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200721_063658_gift cannot be reverted.\n";

        return false;
    }
    */
}
