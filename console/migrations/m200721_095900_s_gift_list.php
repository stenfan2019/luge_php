<?php

use yii\db\Migration;

/**
 * Class m200721_095900_s_gift_list
 * 赠送礼物列表
 */
class m200721_095900_s_gift_list extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');

        /* 创建表 */
        $this->createTable('{{%s_gift_list}}', [
            'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT \'ID\'',
            'user_id' => 'int(10) unsigned NOT NULL COMMENT \'用户ID\'',
            'user_name' => 'varchar(32) NOT NULL COMMENT \'用户账号\'',
            'anchor_id' => 'int(10) unsigned NOT NULL COMMENT \'主播ID\'',
            'anchor_name' => 'varchar(32) NOT NULL COMMENT \'主播账号\'',
            'gift_id' => 'int(10) unsigned NOT NULL COMMENT \'礼物ID\'',
            'gift_name' => 'varchar(32) NOT NULL COMMENT \'礼物名\'',
            'gift_num' => 'int(10) unsigned NOT NULL DEFAULT \'0\' COMMENT \'个数\'',
            'gift_price' => 'int(10) unsigned NOT NULL DEFAULT \'0\' COMMENT \'花费金额\'',
            'state'     => 'tinyint(1) unsigned NOT NULL DEFAULT \'0\' COMMENT \'是否结算 0为未结算\'',
            'status' => 'tinyint(3) unsigned NOT NULL DEFAULT \'1\' COMMENT \'是否删除 0为删除，1反之\'',
            'create_time' => 'datetime(0) DEFAULT CURRENT_TIMESTAMP(0) COMMENT \'创建时间\'',
            'update_time' => 'datetime(0) NOT NULL DEFAULT CURRENT_TIMESTAMP(0) ON UPDATE CURRENT_TIMESTAMP(0) COMMENT \'更新时间\'',
            'PRIMARY KEY (`id`)'
        ], "ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COMMENT='收礼物列表'");

        /* 索引设置 */

        $this->createIndex('username','{{%anchor}}','username',1);


        $this->addForeignKey('fk_gift_list_user_uid', '{{%s_gift_list}}', 'user_id', '{{%user}}', 'uid', 'CASCADE');
        $this->addForeignKey('fk_gift_list_user_name', '{{%s_gift_list}}', 'user_name', '{{%user}}', 'username', 'CASCADE');
        $this->addForeignKey('fk_gift_list_anchor_id', '{{%s_gift_list}}', 'anchor_id', '{{%anchor}}', 'id', 'CASCADE');
        $this->addForeignKey('fk_gift_list_anchor_name', '{{%s_gift_list}}', 'anchor_name', '{{%anchor}}', 'username', 'CASCADE');
        $this->addForeignKey('fk_gift_list_gift_id', '{{%s_gift_list}}', 'gift_id', '{{%gift}}', 'id', 'CASCADE');
        //$this->addForeignKey('fk_gift_list_gift_name', '{{%s_gift_list}}', 'gift_name', '{{%gift}}', 'title', 'CASCADE');

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
        $this->dropTable('{{%gift_list}}');
        $this->execute('SET foreign_key_checks = 1;');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200721_095900_s_gift_list cannot be reverted.\n";

        return false;
    }
    */
}
