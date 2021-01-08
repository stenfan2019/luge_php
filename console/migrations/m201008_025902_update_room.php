<?php

use yii\db\Migration;

/**
 * Class m201008_025902_update_room
 */
class m201008_025902_update_room extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('{{%room}}','url');
        $this->addColumn('{{%room}}','rtmp_url',\yii\db\Schema::TYPE_CHAR . '(128)');
        $this->addColumn('{{%room}}','flv_url',\yii\db\Schema::TYPE_CHAR . '(128)');
        $this->addColumn('{{%room}}','hls_url',\yii\db\Schema::TYPE_CHAR . '(128)');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m201008_025902_update_room cannot be reverted.\n";
        $this->dropColumn('{{%room}}','rtmp_url');
        $this->dropColumn('{{%room}}','flv_url');
        $this->dropColumn('{{%room}}','hls_url');
        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m201008_025902_update_room cannot be reverted.\n";

        return false;
    }
    */
}
