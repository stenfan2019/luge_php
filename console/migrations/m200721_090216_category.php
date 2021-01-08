<?php

use yii\db\Migration;

/**
 * Class m200721_090216_category
 * 栏目列表
 */
class m200721_090216_category extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');

        /* 创建表 */
        $this->createTable('{{%s_category}}', [
            'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT \'分类ID\'',
            'pid' => 'int(10) unsigned NOT NULL DEFAULT \'0\' COMMENT \'上级分类ID\'',
            'name' => 'varchar(30) NOT NULL COMMENT \'标记\'',
            'title' => 'varchar(50) NOT NULL COMMENT \'标题\'',
            'link' => 'varchar(250) NULL DEFAULT \'\' COMMENT \'外链\'',
            'extend' => 'text NULL COMMENT \'扩展\'',
            'description' => 'varchar(255) NULL DEFAULT \'\' COMMENT \'描述\'',
            'sort' => 'int(10) NOT NULL DEFAULT \'0\' COMMENT \'排序（同级有效）\'',
            'status' => 'tinyint(3) unsigned NOT NULL DEFAULT \'1\' COMMENT \'是否删除 0为删除，1反之\'',
            'create_time' => 'datetime(0) DEFAULT CURRENT_TIMESTAMP(0) COMMENT \'创建时间\'',
            'update_time' => 'datetime(0) NOT NULL DEFAULT CURRENT_TIMESTAMP(0) ON UPDATE CURRENT_TIMESTAMP(0) COMMENT \'更新时间\'',
            'PRIMARY KEY (`id`)'
        ], "ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COMMENT='栏目列表'");

        /* 索引设置 */
        $this->createIndex('name','{{%s_category}}','name',1);


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
        $this->dropTable('{{%s_category}}');
        $this->execute('SET foreign_key_checks = 1;');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200721_090216_category cannot be reverted.\n";

        return false;
    }
    */
}
