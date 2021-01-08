<?php

use yii\db\Migration;

/**
 * Class m200729_061051_anchor_add
 */
class m200729_061051_anchor_add extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%anchor}}','nickname',\yii\db\Schema::TYPE_STRING . '(50)');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%anchor}}','nickname');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200729_061051_anchor_add cannot be reverted.\n";

        return false;
    }
    */
}
