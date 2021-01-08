<?php

use yii\db\Migration;

/**
 * Class m200721_031844_live_room
 * 直播房间
 */
class m200721_031844_live_room extends Migration
{

    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');

            /* 创建表 */
        $this->createTable('{{%room}}', [
        'id' => 'int(11) unsigned NOT NULL AUTO_INCREMENT',
        'title' => 'varchar(60) NOT NULL COMMENT \'房间名\'',
        'discript' => 'varchar(250) DEFAULT \'\' COMMENT \'房间介绍\'',
        'url' => 'varchar(250) DEFAULT \'\' COMMENT \'直播地址URL\'',
        'state' => 'tinyint(3) unsigned NOT NULL DEFAULT \'0\' COMMENT \'直播状态\'',
        'category' => 'int(11) unsigned NOT NULL DEFAULT \'0\' COMMENT \'所属栏目\'',
        'anchor_id' => 'int(11) unsigned NOT NULL DEFAULT \'0\' COMMENT \'主播ID\'',
        'chat_id' => 'int(11) unsigned NOT NULL DEFAULT \'0\' COMMENT \'所关联聊天室ID\'',
        'online_num' => 'int(11) unsigned NOT NULL DEFAULT \'0\' COMMENT \'观看人数\'',
        'show_pic' => 'varchar(60) NOT NULL DEFAULT \'\' COMMENT \'展示图\'',
        'keywords' => 'varchar(60) NOT NULL DEFAULT \'\' COMMENT \'标签/关键字\'',
        'status' => 'tinyint(3) unsigned NOT NULL DEFAULT \'1\' COMMENT \'是否删除 0为删除，1反之\'',
        'create_time' => 'datetime(0) DEFAULT CURRENT_TIMESTAMP(0) COMMENT \'创建时间\'',
        'update_time' => 'datetime(0) NOT NULL DEFAULT CURRENT_TIMESTAMP(0) ON UPDATE CURRENT_TIMESTAMP(0) COMMENT \'更新时间\'',
        'PRIMARY KEY (`id`)'
        ], "ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='直播房间表'");
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        echo "m200721_031844_live_room is deleted.\n";
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%room}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}
