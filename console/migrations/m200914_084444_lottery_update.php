<?php

use yii\db\Migration;

/**
 * Class m200914_084444_lottery_update
 */
class m200914_084444_lottery_update extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%lottery}}','period_time',\yii\db\Schema::TYPE_INTEGER . '(10)');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200914_084444_lottery_update cannot be reverted.\n";
        $this->dropColumn('{{%lottery}}','period_time');
        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200914_084444_lottery_update cannot be reverted.\n";

        return false;
    }
    */
}
