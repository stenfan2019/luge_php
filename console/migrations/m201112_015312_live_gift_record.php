<?php

use yii\db\Migration;

/**
 * Class m201112_015312_live_gift_record
 */
class m201112_015312_live_gift_record extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%gift_record}}', [
            'id' => 'int(10) NOT NULL AUTO_INCREMENT',
            'gift_id'    => 'int(10) NULL  COMMENT \'礼物id\'',
            'gift_title' => 'varchar(32) NULL COMMENT \'礼物名称\'',
            'number'     => 'int(10) NULL  COMMENT \'送出数量\'',
            'gift_total' => 'int(10) NOT NULL COMMENT \'礼物金额\'',
            'room_id'    => 'int(10) NOT NULL COMMENT \'直播间ID\'',
            'anchor_id'  => 'int(10) NOT NULL COMMENT \'主播ID\'',
            'rate'       => 'decimal(10,2) NOT NULL COMMENT \'提成比例\'',
            'anchor_total' => 'int(10) NOT NULL COMMENT \'主播提成金额\'',
            'user_id'    => 'int(10) NULL  COMMENT \'uid\'',
            'user_total' => 'int(10) NOT NULL COMMENT \'用户消费金额\'',
            'create_time' => 'datetime(0) NOT NULL  COMMENT \'创建时间\'',
            'status' => 'tinyint(1) NOT NULL DEFAULT \'1\' COMMENT \'状态\'',
            'PRIMARY KEY (`id`)'
        ], "ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='礼物记录表'");
        
        $this->execute('SET foreign_key_checks = 1;');
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        echo "m201112_015312_live_gift_record cannot be reverted.\n";
        $this->dropTable('{{%gift_record}}');
        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m201112_015312_live_gift_record cannot be reverted.\n";

        return false;
    }
    */
}
