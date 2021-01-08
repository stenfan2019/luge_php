<?php

use yii\db\Migration;

/**
 * Class m201112_082522_update_table
 */
class m201112_082522_update_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m201112_082522_update_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m201112_082522_update_table cannot be reverted.\n";

        return false;
    }
    */
}
