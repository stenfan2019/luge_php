<?php
use yii\db\Migration;
/**
 * Class m200915_072900_lottery_number_up
 */
class m200915_072900_lottery_number_up extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%lottery_number}}','end_time',\yii\db\Schema::TYPE_DATETIME.'  COMMENT "结束时间" AFTER start_time');
        $this->addColumn('{{%lottery_number}}','period_code',\yii\db\Schema::TYPE_STRING.'  COMMENT "开奖号码" AFTER envelop_time');
        $this->addColumn('{{%lottery_number}}','n1',\yii\db\Schema::TYPE_SMALLINT.'  COMMENT "开奖号码1" AFTER period_code');
        $this->addColumn('{{%lottery_number}}','n2',\yii\db\Schema::TYPE_SMALLINT.'  COMMENT "开奖号码2" AFTER n1');
        $this->addColumn('{{%lottery_number}}','n3',\yii\db\Schema::TYPE_SMALLINT.'  COMMENT "开奖号码3" AFTER n2');
        $this->addColumn('{{%lottery_number}}','n4',\yii\db\Schema::TYPE_SMALLINT.'  COMMENT "开奖号码4" AFTER n3');
        $this->addColumn('{{%lottery_number}}','n5',\yii\db\Schema::TYPE_SMALLINT.'  COMMENT "开奖号码5" AFTER n4');
        $this->addColumn('{{%lottery_number}}','n6',\yii\db\Schema::TYPE_SMALLINT.'  COMMENT "开奖号码6" AFTER n5');
        $this->addColumn('{{%lottery_number}}','n7',\yii\db\Schema::TYPE_SMALLINT.'  COMMENT "开奖号码7" AFTER n6');
        $this->addColumn('{{%lottery_number}}','n8',\yii\db\Schema::TYPE_SMALLINT.'  COMMENT "开奖号码8" AFTER n7');
        $this->addColumn('{{%lottery_number}}','n9',\yii\db\Schema::TYPE_SMALLINT.'  COMMENT "开奖号码9" AFTER n8');
        $this->addColumn('{{%lottery_number}}','n10',\yii\db\Schema::TYPE_SMALLINT.'  COMMENT "开奖号码10" AFTER n9');
        $this->addColumn('{{%lottery_number}}','state',\yii\db\Schema::TYPE_SMALLINT.'  COMMENT "彩期状态" AFTER n10');
        
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200915_072900_lottery_number_up cannot be reverted.\n";
        $this->dropColumn('{{%lottery_number}}','end_time');
        $this->dropColumn('{{%lottery_number}}','period_code');
        $this->dropColumn('{{%lottery_number}}','n1');
        $this->dropColumn('{{%lottery_number}}','n2');
        $this->dropColumn('{{%lottery_number}}','n3');
        $this->dropColumn('{{%lottery_number}}','n4');
        $this->dropColumn('{{%lottery_number}}','n5');
        $this->dropColumn('{{%lottery_number}}','n6');
        $this->dropColumn('{{%lottery_number}}','n7');
        $this->dropColumn('{{%lottery_number}}','n8');
        $this->dropColumn('{{%lottery_number}}','n9');
        $this->dropColumn('{{%lottery_number}}','n10');
        $this->dropColumn('{{%lottery_number}}','state');
        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200915_072900_lottery_number_up cannot be reverted.\n";

        return false;
    }
    */
}
