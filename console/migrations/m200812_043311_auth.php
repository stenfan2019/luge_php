<?php

use yii\db\Migration;

/**
 * Class m200812_043311_auth
 */
class m200812_043311_auth extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("INSERT INTO `live_back`.`live_menu`(`id`, `title`, `pid`, `sort`, `url`, `hide`, `group`, `status`) VALUES (173, '直播', 0, 1, 'room/index', 0, '', 1)");
        $this->execute("INSERT INTO `live_back`.`live_menu`(`id`, `title`, `pid`, `sort`, `url`, `hide`, `group`, `status`) VALUES (174, '直播间', 173, 0, 'room/index', 0, '列表|icon-settings', 1)");
        $this->execute("INSERT INTO `live_back`.`live_menu`(`id`, `title`, `pid`, `sort`, `url`, `hide`, `group`, `status`) VALUES (175, '主播列表', 173, 0, '/anchor/index', 0, '列表|icon-settings', 1)");
        $this->execute("INSERT INTO `live_back`.`live_menu`(`id`, `title`, `pid`, `sort`, `url`, `hide`, `group`, `status`) VALUES (176, '礼物配置', 173, 0, '/gift/index', 0, '列表|icon-settings', 1)");
        $this->execute("INSERT INTO `live_back`.`live_menu`(`id`, `title`, `pid`, `sort`, `url`, `hide`, `group`, `status`) VALUES (177, '房间礼物详情', 173, 4, '/gift-list/index', 0, '列表|icon-settings', 1)");
        $this->execute("INSERT INTO `live_back`.`live_menu`(`id`, `title`, `pid`, `sort`, `url`, `hide`, `group`, `status`) VALUES (178, '修改', 174, 0, 'room/edit', 0, '列表|icon-settings', 1)");
        $this->execute("INSERT INTO `live_back`.`live_menu`(`id`, `title`, `pid`, `sort`, `url`, `hide`, `group`, `status`) VALUES (179, '房间栏目', 173, 0, 'category/index', 0, '列表|icon-settings', 1)");
        $this->execute("INSERT INTO `live_back`.`live_menu`(`id`, `title`, `pid`, `sort`, `url`, `hide`, `group`, `status`) VALUES (180, '房间详情', 173, 0, 'room-day-list/index', 0, '列表|icon-settings', 1)");
        $this->execute("INSERT INTO `live_back`.`live_menu`(`id`, `title`, `pid`, `sort`, `url`, `hide`, `group`, `status`) VALUES (181, '添加', 174, 2, '/room/create', 0, '列表|icon-settings', 1)");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->execute("Delete from `live_back`.`live_menu` where id in (173,174,175,176,177,178,179,180,181)");
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200812_043311_auth cannot be reverted.\n";

        return false;
    }
    */
}
