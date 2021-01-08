<?php

use yii\db\Migration;

/**
 * Class m201109_085051_update_table1
 */
class m201109_085051_update_table1 extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%user}}','level',\yii\db\Schema::TYPE_TINYINT . '(3) DEFAULT "1" COMMENT "会员等级"');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m201109_085051_update_table1 cannot be reverted.\n";
        $this->dropColumn('{{%user}}','level');
        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m201109_085051_update_table1 cannot be reverted.\n";

        return false;
    }
    */
}
