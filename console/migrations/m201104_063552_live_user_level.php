<?php

use yii\db\Migration;

/**
 * Class m201104_063552_live_user_level
 */
class m201104_063552_live_user_level extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
       $this->execute('SET foreign_key_checks = 0');
        /* 创建表 */
        $this->createTable('{{%user_level}}', [
            'id'    => 'int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT \'等级ID\'',
            'score' => 'int(10) unsigned NOT NULL DEFAULT \'0\' COMMENT \'金额\'',
            'status' => 'tinyint(3) unsigned NOT NULL DEFAULT \'1\' COMMENT \'是否删除 0为删除，1反之\'',
            'PRIMARY KEY (`id`)'
        ], "ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='用户等级表'");
         
        /* 表数据 */
        $this->insert('{{%user_level}}',['id'=>'1','score'=>'0','status'=>1]);
        $this->insert('{{%user_level}}',['id'=>'2','score'=>'5000','status'=>1]);
        $this->insert('{{%user_level}}',['id'=>'3','score'=>'10000','status'=>1]);
        $this->insert('{{%user_level}}',['id'=>'4','score'=>'15000','status'=>1]);
        $this->insert('{{%user_level}}',['id'=>'5','score'=>'20000','status'=>1]);
        $this->insert('{{%user_level}}',['id'=>'6','score'=>'30000','status'=>1]);
        $this->insert('{{%user_level}}',['id'=>'7','score'=>'40000','status'=>1]);
        $this->insert('{{%user_level}}',['id'=>'8','score'=>'50000','status'=>1]);
        $this->insert('{{%user_level}}',['id'=>'9','score'=>'60000','status'=>1]);
        $this->insert('{{%user_level}}',['id'=>'10','score'=>'160000','status'=>1]);
        $this->insert('{{%user_level}}',['id'=>'11','score'=>'260000','status'=>1]);
        $this->insert('{{%user_level}}',['id'=>'12','score'=>'360000','status'=>1]);
        $this->insert('{{%user_level}}',['id'=>'13','score'=>'460000','status'=>1]);
        $this->insert('{{%user_level}}',['id'=>'14','score'=>'560000','status'=>1]);
        $this->insert('{{%user_level}}',['id'=>'15','score'=>'660000','status'=>1]);
        $this->insert('{{%user_level}}',['id'=>'16','score'=>'1160000','status'=>1]);
        $this->insert('{{%user_level}}',['id'=>'17','score'=>'1660000','status'=>1]);
        $this->insert('{{%user_level}}',['id'=>'18','score'=>'2160000','status'=>1]);
        $this->insert('{{%user_level}}',['id'=>'19','score'=>'2660000','status'=>1]);
        $this->insert('{{%user_level}}',['id'=>'20','score'=>'3160000','status'=>1]);
        $this->insert('{{%user_level}}',['id'=>'21','score'=>'8160000','status'=>1]);
        $this->insert('{{%user_level}}',['id'=>'22','score'=>'13160000','status'=>1]);
        $this->insert('{{%user_level}}',['id'=>'23','score'=>'18160000','status'=>1]);
        $this->insert('{{%user_level}}',['id'=>'24','score'=>'23160000','status'=>1]);
        $this->insert('{{%user_level}}',['id'=>'25','score'=>'28160000','status'=>1]);
        $this->insert('{{%user_level}}',['id'=>'26','score'=>'48160000','status'=>1]);
        $this->insert('{{%user_level}}',['id'=>'27','score'=>'88160000','status'=>1]);
        $this->insert('{{%user_level}}',['id'=>'28','score'=>'148160000','status'=>1]);
        $this->insert('{{%user_level}}',['id'=>'29','score'=>'228160000','status'=>1]);
        $this->insert('{{%user_level}}',['id'=>'30','score'=>'300000000','status'=>1]);
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%user_level}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
   
}
