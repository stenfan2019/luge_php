<?php

use yii\db\Migration;

/**
 * Class m201023_101334_user_follow
 */
class m201023_101334_user_follow extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%user_follow}}', [
            'id' => 'int(11) unsigned NOT NULL AUTO_INCREMENT',
            'anchor_id' => 'int(11) unsigned NOT NULL DEFAULT \'0\' COMMENT \'主播ID\'',
            'user_id'   => 'int(11) unsigned NOT NULL DEFAULT \'0\' COMMENT \'用户ID\'',
            'status' => 'tinyint(3) unsigned NOT NULL DEFAULT \'1\' COMMENT \'是否删除 0为删除，1反之\'',
            'create_time' => 'datetime(0) DEFAULT CURRENT_TIMESTAMP(0) COMMENT \'创建时间\'',
            'update_time' => 'datetime(0) NOT NULL DEFAULT CURRENT_TIMESTAMP(0) ON UPDATE CURRENT_TIMESTAMP(0) COMMENT \'更新时间\'',
            'PRIMARY KEY (`id`)'
        ], "ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='用户关注列表'");
        $this->execute('SET foreign_key_checks = 1;');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m201023_101334_user_follow cannot be reverted.\n";
        $this->dropTable('{{%user_follow}}');
        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m201023_101334_user_follow cannot be reverted.\n";

        return false;
    }
    */
}
