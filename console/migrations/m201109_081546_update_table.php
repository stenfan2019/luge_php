<?php

use yii\db\Migration;

/**
 * Class m201109_081546_update_table
 */
class m201109_081546_update_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%lottery}}','is_index',\yii\db\Schema::TYPE_TINYINT . '(3) DEFAULT "1" COMMENT "是否首页推荐"');
        #修改主播表
        $this->addColumn('{{%anchor}}','amount',\yii\db\Schema::TYPE_INTEGER . '(10) DEFAULT "0" COMMENT "主播账户余额"');
        $this->addColumn('{{%anchor}}','income_gift',\yii\db\Schema::TYPE_INTEGER . '(10) DEFAULT "0" COMMENT "主播礼物收益"');
        $this->addColumn('{{%anchor}}','income_game',\yii\db\Schema::TYPE_INTEGER . '(10) DEFAULT "0" COMMENT "主播游戏收益"');
        $this->addColumn('{{%anchor}}','withdraw',\yii\db\Schema::TYPE_INTEGER . '(10) DEFAULT "0" COMMENT "主播累计提现金额"');
        
        #修改用户表
        $this->addColumn('{{%user}}','amount',\yii\db\Schema::TYPE_INTEGER . '(10) DEFAULT "0" COMMENT "用户账户金额"');
        $this->addColumn('{{%user}}','give_gift',\yii\db\Schema::TYPE_INTEGER . '(10) DEFAULT "0" COMMENT "打赏礼物金额"');
        $this->addColumn('{{%user}}','give_game',\yii\db\Schema::TYPE_INTEGER . '(10) DEFAULT "0" COMMENT "游戏投注金额"');
        $this->addColumn('{{%user}}','withdraw',\yii\db\Schema::TYPE_INTEGER . '(10) DEFAULT "0" COMMENT "累计提现金额"');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m201109_081546_update_table cannot be reverted.\n";
        $this->dropColumn('{{%lottery}}','is_index');
        
        $this->dropColumn('{{%anchor}}','amount');
        $this->dropColumn('{{%anchor}}','income_gift');
        $this->dropColumn('{{%anchor}}','income_game');
        $this->dropColumn('{{%anchor}}','withdraw');
        
        $this->dropColumn('{{%user}}','amount');
        $this->dropColumn('{{%user}}','give_gift');
        $this->dropColumn('{{%user}}','give_game');
        $this->dropColumn('{{%user}}','withdraw');
        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m201109_081546_update_table cannot be reverted.\n";

        return false;
    }
    */
}
