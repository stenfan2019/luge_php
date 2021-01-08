<?php

use yii\db\Migration;

/**
 * Class m200821_082917_room
 */
class m200821_082917_room extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        return $this->addColumn('{{%room}}','recommend',\yii\db\Schema::TYPE_TINYINT.' DEFAULT 0 COMMENT "是否推荐到首页" AFTER chat_id');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
       return  $this->dropColumn('{{%room}}','recommend');

    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200821_082917_room cannot be reverted.\n";

        return false;
    }
    */
}
