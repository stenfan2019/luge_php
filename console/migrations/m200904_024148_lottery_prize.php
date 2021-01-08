<?php

use yii\db\Migration;

/**
 * Class m200904_024148_lottery_prize
 */
class m200904_024148_lottery_prize extends Migration
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
        echo "m200904_024148_lottery_prize cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200904_024148_lottery_prize cannot be reverted.\n";

        return false;
    }
    */
}
