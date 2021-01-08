<?php

use yii\db\Migration;

/**
 * Class m201009_030217_update_room_is_index
 */
class m201009_030217_update_room_is_index extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%room}}','is_index',\yii\db\Schema::TYPE_TINYINT . '(3) ');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m201009_030217_update_room_is_index cannot be reverted.\n";
        $this->dropColumn('{{%room}}','is_index');
        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m201009_030217_update_room_is_index cannot be reverted.\n";

        return false;
    }
    */
}
