<?php

use yii\db\Migration;

/**
 * Class m201106_065043_lottery_add_data
 */
class m201106_065043_lottery_add_data extends Migration
{
   

    
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $date = date('Y-m-d H:i:s',time());
       // $this->createIndex('id','{{%lottery}}','id',100);
        $this->insert('{{%lottery}}',['id'=>'100','name'=>'三分快三','code'=>'SFKS','icon_url'=>'/game/lottery/js_kuai3.png','type'=>'high','sort'=>'99','is_private'=>'1','envelop_time'=>'1','create_time'=>$date,'status'=>'1','update_time' => $date,'period_time'=>180]);
        $this->insert('{{%lottery}}',['id'=>'103','name'=>'五分快三','code'=>'WFKS','icon_url'=>'/game/lottery/wf_kuai3.png','type'=>'high','sort'=>'99','is_private'=>'1','envelop_time'=>'1','create_time'=>$date,'status'=>'1','update_time' => $date,'period_time'=>300]);
        $this->insert('{{%lottery}}',['id'=>'105','name'=>'一分快三','code'=>'YFKS','icon_url'=>'/game/lottery/af_kuai3.png','type'=>'high','sort'=>'99','is_private'=>'1','envelop_time'=>'1','create_time'=>$date,'status'=>'1','update_time' => $date,'period_time'=>60]);
        $this->insert('{{%lottery}}',['id'=>'107','name'=>'北京赛车','code'=>'BJSC','icon_url'=>'/game/lottery/bjsc_pk10.png','type'=>'high','sort'=>'99','is_private'=>'1','envelop_time'=>'1','create_time'=>$date,'status'=>'1','update_time' => $date,'period_time'=>300]);
       
    }

    public function down()
    {
        echo "m201106_065043_lottery_add_data cannot be reverted.\n";
        $this->dropTable('{{%lottery}}');
        return false;
    }
    
}
