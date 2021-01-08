<?php

use yii\db\Migration;

/**
 * Class m200904_020450_anchor
 */
class m200904_020450_anchor extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        return $this->addColumn('{{%anchor}}','fans',\yii\db\Schema::TYPE_INTEGER.' DEFAULT 0 COMMENT "粉丝数量" AFTER follower');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        return $this->dropColumn('{{%anchor}}','fans');
    }

    
}
