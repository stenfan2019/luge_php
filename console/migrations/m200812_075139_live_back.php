<?php

use yii\db\Migration;

/**
 * Class m200812_075139_live_back
 */
class m200812_075139_live_back extends Migration
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
        echo "m200812_075139_live_back cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200812_075139_live_back cannot be reverted.\n";

        return false;
    }
    */
}
