<?php

use yii\db\Migration;

/**
 * Class m200721_054154_anchor
 */
class m200721_054154_anchor extends Migration
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
        $this->createTable('{{%anchor}}', [
            'id' => 'int(11) unsigned NOT NULL AUTO_INCREMENT',
            'username' => 'varchar(32) NOT NULL COMMENT \'主播账号\'',
            'mobile' => 'char(15) DEFAULT \'0\' COMMENT \'主播手机\'',
            'email' => 'char(32) NOT NULL DEFAULT \'0\' COMMENT \'邮箱，预留之后\'',
            'password' => 'varchar(128) NOT NULL DEFAULT \'\' COMMENT \'密码\'',
            'salt' => 'varchar(32) NOT NULL COMMENT \'密码盐\'',
            'descript' => 'varchar(250) DEFAULT NULL COMMENT \'个人简介\'',
            'image' => 'varchar(250) DEFAULT NULL COMMENT \'头像路径\'',
            'score' => 'int(11) unsigned NOT NULL DEFAULT \'0\' COMMENT \'当前余额\'',
            'score_all' => 'int(11) unsigned NOT NULL DEFAULT \'0\' COMMENT \'总余额\'',
            'agent_id' => 'int(11) unsigned NOT NULL DEFAULT \'0\' COMMENT \'所属代理 0为公司直属\'',
            'follower' => 'int(11) unsigned NOT NULL DEFAULT \'0\' COMMENT \'关注人数\'',
            'reg_time' => 'int(11) unsigned NOT NULL DEFAULT \'0\' COMMENT \'注册时间\'',
            'reg_ip' => 'bigint(20) NOT NULL DEFAULT \'0\' COMMENT \'注册IP\'',
            'last_login_time' => 'int(10) unsigned NOT NULL DEFAULT \'0\' COMMENT \'最后登录时间\'',
            'last_login_ip' => 'bigint(20) NOT NULL DEFAULT \'0\' COMMENT \'最后登录IP\'',
            'status' => 'tinyint(3) unsigned NOT NULL DEFAULT \'1\' COMMENT \'是否删除 0为删除，1反之\'',
            'create_time' => 'datetime(0) DEFAULT CURRENT_TIMESTAMP(0) COMMENT \'创建时间\'',
            'update_time' => 'datetime(0) NOT NULL DEFAULT CURRENT_TIMESTAMP(0) ON UPDATE CURRENT_TIMESTAMP(0) COMMENT \'更新时间\'',
            'PRIMARY KEY (`id`)'
        ], "ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='主播表'");
        $this->execute('SET foreign_key_checks = 1;');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%anchor}}');
        $this->execute('SET foreign_key_checks = 1;');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200721_054154_anchor cannot be reverted.\n";

        return false;
    }
    */
}
