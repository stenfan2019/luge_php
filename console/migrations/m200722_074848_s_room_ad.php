<?php

use yii\db\Migration;

/**
 * Class m200722_074848_s_room_ad
 * 房间直播時間记录
 */
class m200722_074848_s_room_ad extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');

        /* 创建表 */
        $this->createTable('{{%s_room_day_list}}', [
            'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT \'ID\'',
            'room_id' => 'int(10) unsigned NOT NULL COMMENT \'用户ID\'',
            'room_name' => 'varchar(32) NOT NULL COMMENT \'用户账号\'',
            'anchor_id' => 'int(10) unsigned NOT NULL COMMENT \'主播ID\'',
            'anchor_name' => 'varchar(32) NOT NULL COMMENT \'主播账号\'',
            'start_time' => 'datetime(0) DEFAULT CURRENT_TIMESTAMP(0) COMMENT \'开始时间\'',
            'end_time' => 'datetime(0) DEFAULT CURRENT_TIMESTAMP(0) COMMENT \'结束时间\'',
            'gift_num' => 'int(10) unsigned NOT NULL DEFAULT \'0\' COMMENT \'个数\'',
            'gift_price' => 'int(10) unsigned NOT NULL DEFAULT \'0\' COMMENT \'花费金额\'',
            'view_num' => 'int(10) unsigned NOT NULL DEFAULT \'0\' COMMENT \'观看人数\'',
            'state'     => 'tinyint(1) unsigned NOT NULL DEFAULT \'0\' COMMENT \'是否结算 0为未结算\'',
            'status' => 'tinyint(3) unsigned NOT NULL DEFAULT \'1\' COMMENT \'是否删除 0为删除，1反之\'',
            'create_time' => 'datetime(0) DEFAULT CURRENT_TIMESTAMP(0) COMMENT \'创建时间\'',
            'update_time' => 'datetime(0) NOT NULL DEFAULT CURRENT_TIMESTAMP(0) ON UPDATE CURRENT_TIMESTAMP(0) COMMENT \'更新时间\'',
            'PRIMARY KEY (`id`)'
        ], "ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COMMENT='房间直播记录表'");

        /* 索引设置 */

        $this->addForeignKey('fk_room_day_list_room_id', '{{%s_room_day_list}}', 'room_id', '{{%room}}', 'id', 'CASCADE');
        $this->addForeignKey('fk_room_day_list_anchor_id', '{{%s_room_day_list}}', 'anchor_id', '{{%anchor}}', 'id', 'CASCADE');
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%s_room_day_list}}');
        $this->execute('SET foreign_key_checks = 1;');

    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200722_074848_s_room_ad cannot be reverted.\n";

        return false;
    }
    */
}
