<?php

use yii\db\Migration;

/**
 * Class m201106_101818_lottery_odds_add
 */
class m201106_101818_lottery_odds_add extends Migration
{
     public function up()
    {
        $date = date('Y-m-d H:i:s',time());
       // $this->createIndex('id','{{%lottery_odds}}','id',1000);
        //三分快三
        $this->insert('{{%lottery_odds}}',['id'=>'1000','lottery_id'=>'100','lottery_code'=>'SFKS','name'=>'大','cate_id'=>'1001','cate_name'=>'和值','sort'=>'99','odds'=>'1.80','create_time'=>$date,'status'=>'1','update_time' => $date]);
        $this->insert('{{%lottery_odds}}',['id'=>'1001','lottery_id'=>'100','lottery_code'=>'SFKS','name'=>'小','cate_id'=>'1001','cate_name'=>'和值','sort'=>'99','odds'=>'1.80','create_time'=>$date,'status'=>'1','update_time' => $date]);
        $this->insert('{{%lottery_odds}}',['id'=>'1002','lottery_id'=>'100','lottery_code'=>'SFKS','name'=>'单','cate_id'=>'1001','cate_name'=>'和值','sort'=>'99','odds'=>'1.80','create_time'=>$date,'status'=>'1','update_time' => $date]);
        $this->insert('{{%lottery_odds}}',['id'=>'1003','lottery_id'=>'100','lottery_code'=>'SFKS','name'=>'双','cate_id'=>'1001','cate_name'=>'和值','sort'=>'99','odds'=>'1.80','create_time'=>$date,'status'=>'1','update_time' => $date]);
        
        $this->insert('{{%lottery_odds}}',['id'=>'1004','lottery_id'=>'100','lottery_code'=>'SFKS','name'=>'4','cate_id'=>'1002','cate_name'=>'点数','sort'=>'99','odds'=>'44.1','create_time'=>$date,'status'=>'1','update_time' => $date]);
        $this->insert('{{%lottery_odds}}',['id'=>'1005','lottery_id'=>'100','lottery_code'=>'SFKS','name'=>'5','cate_id'=>'1002','cate_name'=>'点数','sort'=>'99','odds'=>'17.04','create_time'=>$date,'status'=>'1','update_time' => $date]);
        $this->insert('{{%lottery_odds}}',['id'=>'1006','lottery_id'=>'100','lottery_code'=>'SFKS','name'=>'6','cate_id'=>'1002','cate_name'=>'点数','sort'=>'99','odds'=>'13.22','create_time'=>$date,'status'=>'1','update_time' => $date]);
        $this->insert('{{%lottery_odds}}',['id'=>'1007','lottery_id'=>'100','lottery_code'=>'SFKS','name'=>'7','cate_id'=>'1002','cate_name'=>'点数','sort'=>'99','odds'=>'11.81','create_time'=>$date,'status'=>'1','update_time' => $date]);
        $this->insert('{{%lottery_odds}}',['id'=>'1008','lottery_id'=>'100','lottery_code'=>'SFKS','name'=>'8','cate_id'=>'1002','cate_name'=>'点数','sort'=>'99','odds'=>'8.15','create_time'=>$date,'status'=>'1','update_time' => $date]);
        $this->insert('{{%lottery_odds}}',['id'=>'1009','lottery_id'=>'100','lottery_code'=>'SFKS','name'=>'9','cate_id'=>'1002','cate_name'=>'点数','sort'=>'99','odds'=>'6.29','create_time'=>$date,'status'=>'1','update_time' => $date]);
        $this->insert('{{%lottery_odds}}',['id'=>'1010','lottery_id'=>'100','lottery_code'=>'SFKS','name'=>'10','cate_id'=>'1002','cate_name'=>'点数','sort'=>'99','odds'=>'6.35','create_time'=>$date,'status'=>'1','update_time' => $date]);
        $this->insert('{{%lottery_odds}}',['id'=>'1011','lottery_id'=>'100','lottery_code'=>'SFKS','name'=>'11','cate_id'=>'1002','cate_name'=>'点数','sort'=>'99','odds'=>'6.35','create_time'=>$date,'status'=>'1','update_time' => $date]);
        $this->insert('{{%lottery_odds}}',['id'=>'1012','lottery_id'=>'100','lottery_code'=>'SFKS','name'=>'12','cate_id'=>'1002','cate_name'=>'点数','sort'=>'99','odds'=>'6.29','create_time'=>$date,'status'=>'1','update_time' => $date]);
        $this->insert('{{%lottery_odds}}',['id'=>'1013','lottery_id'=>'100','lottery_code'=>'SFKS','name'=>'13','cate_id'=>'1002','cate_name'=>'点数','sort'=>'99','odds'=>'8.15','create_time'=>$date,'status'=>'1','update_time' => $date]);
        $this->insert('{{%lottery_odds}}',['id'=>'1014','lottery_id'=>'100','lottery_code'=>'SFKS','name'=>'14','cate_id'=>'1002','cate_name'=>'点数','sort'=>'99','odds'=>'11.81','create_time'=>$date,'status'=>'1','update_time' => $date]);
        $this->insert('{{%lottery_odds}}',['id'=>'1015','lottery_id'=>'100','lottery_code'=>'SFKS','name'=>'15','cate_id'=>'1002','cate_name'=>'点数','sort'=>'99','odds'=>'13.22','create_time'=>$date,'status'=>'1','update_time' => $date]);
        $this->insert('{{%lottery_odds}}',['id'=>'1016','lottery_id'=>'100','lottery_code'=>'SFKS','name'=>'16','cate_id'=>'1002','cate_name'=>'点数','sort'=>'99','odds'=>'17.04','create_time'=>$date,'status'=>'1','update_time' => $date]);
        $this->insert('{{%lottery_odds}}',['id'=>'1017','lottery_id'=>'100','lottery_code'=>'SFKS','name'=>'17','cate_id'=>'1002','cate_name'=>'点数','sort'=>'99','odds'=>'44.1','create_time'=>$date,'status'=>'1','update_time' => $date]);
   
        $this->insert('{{%lottery_odds}}',['id'=>'1018','lottery_id'=>'100','lottery_code'=>'SFKS','name'=>'111','cate_id'=>'1003','cate_name'=>'三军','sort'=>'99','odds'=>'162.28','create_time'=>$date,'status'=>'1','update_time' => $date]);
        $this->insert('{{%lottery_odds}}',['id'=>'1019','lottery_id'=>'100','lottery_code'=>'SFKS','name'=>'222','cate_id'=>'1003','cate_name'=>'三军','sort'=>'99','odds'=>'162.28','create_time'=>$date,'status'=>'1','update_time' => $date]);
        $this->insert('{{%lottery_odds}}',['id'=>'1020','lottery_id'=>'100','lottery_code'=>'SFKS','name'=>'333','cate_id'=>'1003','cate_name'=>'三军','sort'=>'99','odds'=>'162.28','create_time'=>$date,'status'=>'1','update_time' => $date]);
        $this->insert('{{%lottery_odds}}',['id'=>'1021','lottery_id'=>'100','lottery_code'=>'SFKS','name'=>'444','cate_id'=>'1003','cate_name'=>'三军','sort'=>'99','odds'=>'162.28','create_time'=>$date,'status'=>'1','update_time' => $date]);
        $this->insert('{{%lottery_odds}}',['id'=>'1022','lottery_id'=>'100','lottery_code'=>'SFKS','name'=>'555','cate_id'=>'1003','cate_name'=>'三军','sort'=>'99','odds'=>'162.28','create_time'=>$date,'status'=>'1','update_time' => $date]);
        $this->insert('{{%lottery_odds}}',['id'=>'1023','lottery_id'=>'100','lottery_code'=>'SFKS','name'=>'666','cate_id'=>'1003','cate_name'=>'三军','sort'=>'99','odds'=>'162.28','create_time'=>$date,'status'=>'1','update_time' => $date]);
        
        //五分快三
        $this->insert('{{%lottery_odds}}',['id'=>'1024','lottery_id'=>'103','lottery_code'=>'WFKS','name'=>'大','cate_id'=>'1031','cate_name'=>'和值','sort'=>'99','odds'=>'1.80','create_time'=>$date,'status'=>'1','update_time' => $date]);
        $this->insert('{{%lottery_odds}}',['id'=>'1025','lottery_id'=>'103','lottery_code'=>'WFKS','name'=>'小','cate_id'=>'1031','cate_name'=>'和值','sort'=>'99','odds'=>'1.80','create_time'=>$date,'status'=>'1','update_time' => $date]);
        $this->insert('{{%lottery_odds}}',['id'=>'1026','lottery_id'=>'103','lottery_code'=>'WFKS','name'=>'单','cate_id'=>'1031','cate_name'=>'和值','sort'=>'99','odds'=>'1.80','create_time'=>$date,'status'=>'1','update_time' => $date]);
        $this->insert('{{%lottery_odds}}',['id'=>'1027','lottery_id'=>'103','lottery_code'=>'WFKS','name'=>'双','cate_id'=>'1031','cate_name'=>'和值','sort'=>'99','odds'=>'1.80','create_time'=>$date,'status'=>'1','update_time' => $date]);
        
        $this->insert('{{%lottery_odds}}',['id'=>'1028','lottery_id'=>'103','lottery_code'=>'WFKS','name'=>'4','cate_id'=>'1032','cate_name'=>'点数','sort'=>'99','odds'=>'44.1','create_time'=>$date,'status'=>'1','update_time' => $date]);
        $this->insert('{{%lottery_odds}}',['id'=>'1029','lottery_id'=>'103','lottery_code'=>'WFKS','name'=>'5','cate_id'=>'1032','cate_name'=>'点数','sort'=>'99','odds'=>'17.04','create_time'=>$date,'status'=>'1','update_time' => $date]);
        $this->insert('{{%lottery_odds}}',['id'=>'1030','lottery_id'=>'103','lottery_code'=>'WFKS','name'=>'6','cate_id'=>'1032','cate_name'=>'点数','sort'=>'99','odds'=>'13.22','create_time'=>$date,'status'=>'1','update_time' => $date]);
        $this->insert('{{%lottery_odds}}',['id'=>'1031','lottery_id'=>'103','lottery_code'=>'WFKS','name'=>'7','cate_id'=>'1032','cate_name'=>'点数','sort'=>'99','odds'=>'11.81','create_time'=>$date,'status'=>'1','update_time' => $date]);
        $this->insert('{{%lottery_odds}}',['id'=>'1032','lottery_id'=>'103','lottery_code'=>'WFKS','name'=>'8','cate_id'=>'1032','cate_name'=>'点数','sort'=>'99','odds'=>'8.15','create_time'=>$date,'status'=>'1','update_time' => $date]);
        $this->insert('{{%lottery_odds}}',['id'=>'1033','lottery_id'=>'103','lottery_code'=>'WFKS','name'=>'9','cate_id'=>'1032','cate_name'=>'点数','sort'=>'99','odds'=>'6.29','create_time'=>$date,'status'=>'1','update_time' => $date]);
        $this->insert('{{%lottery_odds}}',['id'=>'1034','lottery_id'=>'103','lottery_code'=>'WFKS','name'=>'10','cate_id'=>'1032','cate_name'=>'点数','sort'=>'99','odds'=>'6.35','create_time'=>$date,'status'=>'1','update_time' => $date]);
        $this->insert('{{%lottery_odds}}',['id'=>'1035','lottery_id'=>'103','lottery_code'=>'WFKS','name'=>'11','cate_id'=>'1032','cate_name'=>'点数','sort'=>'99','odds'=>'6.35','create_time'=>$date,'status'=>'1','update_time' => $date]);
        $this->insert('{{%lottery_odds}}',['id'=>'1036','lottery_id'=>'103','lottery_code'=>'WFKS','name'=>'12','cate_id'=>'1032','cate_name'=>'点数','sort'=>'99','odds'=>'6.29','create_time'=>$date,'status'=>'1','update_time' => $date]);
        $this->insert('{{%lottery_odds}}',['id'=>'1037','lottery_id'=>'103','lottery_code'=>'WFKS','name'=>'13','cate_id'=>'1032','cate_name'=>'点数','sort'=>'99','odds'=>'8.15','create_time'=>$date,'status'=>'1','update_time' => $date]);
        $this->insert('{{%lottery_odds}}',['id'=>'1038','lottery_id'=>'103','lottery_code'=>'WFKS','name'=>'14','cate_id'=>'1032','cate_name'=>'点数','sort'=>'99','odds'=>'11.81','create_time'=>$date,'status'=>'1','update_time' => $date]);
        $this->insert('{{%lottery_odds}}',['id'=>'1039','lottery_id'=>'103','lottery_code'=>'WFKS','name'=>'15','cate_id'=>'1032','cate_name'=>'点数','sort'=>'99','odds'=>'13.22','create_time'=>$date,'status'=>'1','update_time' => $date]);
        $this->insert('{{%lottery_odds}}',['id'=>'1040','lottery_id'=>'103','lottery_code'=>'WFKS','name'=>'16','cate_id'=>'1032','cate_name'=>'点数','sort'=>'99','odds'=>'17.04','create_time'=>$date,'status'=>'1','update_time' => $date]);
        $this->insert('{{%lottery_odds}}',['id'=>'1041','lottery_id'=>'103','lottery_code'=>'WFKS','name'=>'17','cate_id'=>'1032','cate_name'=>'点数','sort'=>'99','odds'=>'44.1','create_time'=>$date,'status'=>'1','update_time' => $date]);
         
        $this->insert('{{%lottery_odds}}',['id'=>'1042','lottery_id'=>'103','lottery_code'=>'WFKS','name'=>'111','cate_id'=>'1033','cate_name'=>'三军','sort'=>'99','odds'=>'162.28','create_time'=>$date,'status'=>'1','update_time' => $date]);
        $this->insert('{{%lottery_odds}}',['id'=>'1043','lottery_id'=>'103','lottery_code'=>'WFKS','name'=>'222','cate_id'=>'1033','cate_name'=>'三军','sort'=>'99','odds'=>'162.28','create_time'=>$date,'status'=>'1','update_time' => $date]);
        $this->insert('{{%lottery_odds}}',['id'=>'1044','lottery_id'=>'103','lottery_code'=>'WFKS','name'=>'333','cate_id'=>'1033','cate_name'=>'三军','sort'=>'99','odds'=>'162.28','create_time'=>$date,'status'=>'1','update_time' => $date]);
        $this->insert('{{%lottery_odds}}',['id'=>'1045','lottery_id'=>'103','lottery_code'=>'WFKS','name'=>'444','cate_id'=>'1033','cate_name'=>'三军','sort'=>'99','odds'=>'162.28','create_time'=>$date,'status'=>'1','update_time' => $date]);
        $this->insert('{{%lottery_odds}}',['id'=>'1046','lottery_id'=>'103','lottery_code'=>'WFKS','name'=>'555','cate_id'=>'1033','cate_name'=>'三军','sort'=>'99','odds'=>'162.28','create_time'=>$date,'status'=>'1','update_time' => $date]);
        $this->insert('{{%lottery_odds}}',['id'=>'1047','lottery_id'=>'103','lottery_code'=>'WFKS','name'=>'666','cate_id'=>'1033','cate_name'=>'三军','sort'=>'99','odds'=>'162.28','create_time'=>$date,'status'=>'1','update_time' => $date]);
        
        
        //一分快三
        $this->insert('{{%lottery_odds}}',['id'=>'1048','lottery_id'=>'105','lottery_code'=>'YFKS','name'=>'大','cate_id'=>'1031','cate_name'=>'和值','sort'=>'99','odds'=>'1.80','create_time'=>$date,'status'=>'1','update_time' => $date]);
        $this->insert('{{%lottery_odds}}',['id'=>'1049','lottery_id'=>'105','lottery_code'=>'YFKS','name'=>'小','cate_id'=>'1031','cate_name'=>'和值','sort'=>'99','odds'=>'1.80','create_time'=>$date,'status'=>'1','update_time' => $date]);
        $this->insert('{{%lottery_odds}}',['id'=>'1050','lottery_id'=>'105','lottery_code'=>'YFKS','name'=>'单','cate_id'=>'1031','cate_name'=>'和值','sort'=>'99','odds'=>'1.80','create_time'=>$date,'status'=>'1','update_time' => $date]);
        $this->insert('{{%lottery_odds}}',['id'=>'1051','lottery_id'=>'105','lottery_code'=>'YFKS','name'=>'双','cate_id'=>'1031','cate_name'=>'和值','sort'=>'99','odds'=>'1.80','create_time'=>$date,'status'=>'1','update_time' => $date]);
        
        $this->insert('{{%lottery_odds}}',['id'=>'1052','lottery_id'=>'105','lottery_code'=>'YFKS','name'=>'4','cate_id'=>'1032','cate_name'=>'点数','sort'=>'99','odds'=>'44.1','create_time'=>$date,'status'=>'1','update_time' => $date]);
        $this->insert('{{%lottery_odds}}',['id'=>'1053','lottery_id'=>'105','lottery_code'=>'YFKS','name'=>'5','cate_id'=>'1032','cate_name'=>'点数','sort'=>'99','odds'=>'17.04','create_time'=>$date,'status'=>'1','update_time' => $date]);
        $this->insert('{{%lottery_odds}}',['id'=>'1054','lottery_id'=>'105','lottery_code'=>'YFKS','name'=>'6','cate_id'=>'1032','cate_name'=>'点数','sort'=>'99','odds'=>'13.22','create_time'=>$date,'status'=>'1','update_time' => $date]);
        $this->insert('{{%lottery_odds}}',['id'=>'1055','lottery_id'=>'105','lottery_code'=>'YFKS','name'=>'7','cate_id'=>'1032','cate_name'=>'点数','sort'=>'99','odds'=>'11.81','create_time'=>$date,'status'=>'1','update_time' => $date]);
        $this->insert('{{%lottery_odds}}',['id'=>'1056','lottery_id'=>'105','lottery_code'=>'YFKS','name'=>'8','cate_id'=>'1032','cate_name'=>'点数','sort'=>'99','odds'=>'8.15','create_time'=>$date,'status'=>'1','update_time' => $date]);
        $this->insert('{{%lottery_odds}}',['id'=>'1057','lottery_id'=>'105','lottery_code'=>'YFKS','name'=>'9','cate_id'=>'1032','cate_name'=>'点数','sort'=>'99','odds'=>'6.29','create_time'=>$date,'status'=>'1','update_time' => $date]);
        $this->insert('{{%lottery_odds}}',['id'=>'1058','lottery_id'=>'105','lottery_code'=>'YFKS','name'=>'10','cate_id'=>'1032','cate_name'=>'点数','sort'=>'99','odds'=>'6.35','create_time'=>$date,'status'=>'1','update_time' => $date]);
        $this->insert('{{%lottery_odds}}',['id'=>'1059','lottery_id'=>'105','lottery_code'=>'YFKS','name'=>'11','cate_id'=>'1032','cate_name'=>'点数','sort'=>'99','odds'=>'6.35','create_time'=>$date,'status'=>'1','update_time' => $date]);
        $this->insert('{{%lottery_odds}}',['id'=>'1060','lottery_id'=>'105','lottery_code'=>'YFKS','name'=>'12','cate_id'=>'1032','cate_name'=>'点数','sort'=>'99','odds'=>'6.29','create_time'=>$date,'status'=>'1','update_time' => $date]);
        $this->insert('{{%lottery_odds}}',['id'=>'1061','lottery_id'=>'105','lottery_code'=>'YFKS','name'=>'13','cate_id'=>'1032','cate_name'=>'点数','sort'=>'99','odds'=>'8.15','create_time'=>$date,'status'=>'1','update_time' => $date]);
        $this->insert('{{%lottery_odds}}',['id'=>'1062','lottery_id'=>'105','lottery_code'=>'YFKS','name'=>'14','cate_id'=>'1032','cate_name'=>'点数','sort'=>'99','odds'=>'11.81','create_time'=>$date,'status'=>'1','update_time' => $date]);
        $this->insert('{{%lottery_odds}}',['id'=>'1063','lottery_id'=>'105','lottery_code'=>'YFKS','name'=>'15','cate_id'=>'1032','cate_name'=>'点数','sort'=>'99','odds'=>'13.22','create_time'=>$date,'status'=>'1','update_time' => $date]);
        $this->insert('{{%lottery_odds}}',['id'=>'1064','lottery_id'=>'105','lottery_code'=>'YFKS','name'=>'16','cate_id'=>'1032','cate_name'=>'点数','sort'=>'99','odds'=>'17.04','create_time'=>$date,'status'=>'1','update_time' => $date]);
        $this->insert('{{%lottery_odds}}',['id'=>'1065','lottery_id'=>'105','lottery_code'=>'YFKS','name'=>'17','cate_id'=>'1032','cate_name'=>'点数','sort'=>'99','odds'=>'44.1','create_time'=>$date,'status'=>'1','update_time' => $date]);
         
        $this->insert('{{%lottery_odds}}',['id'=>'1066','lottery_id'=>'105','lottery_code'=>'YFKS','name'=>'111','cate_id'=>'1033','cate_name'=>'三军','sort'=>'99','odds'=>'162.28','create_time'=>$date,'status'=>'1','update_time' => $date]);
        $this->insert('{{%lottery_odds}}',['id'=>'1067','lottery_id'=>'105','lottery_code'=>'YFKS','name'=>'222','cate_id'=>'1033','cate_name'=>'三军','sort'=>'99','odds'=>'162.28','create_time'=>$date,'status'=>'1','update_time' => $date]);
        $this->insert('{{%lottery_odds}}',['id'=>'1068','lottery_id'=>'105','lottery_code'=>'YFKS','name'=>'333','cate_id'=>'1033','cate_name'=>'三军','sort'=>'99','odds'=>'162.28','create_time'=>$date,'status'=>'1','update_time' => $date]);
        $this->insert('{{%lottery_odds}}',['id'=>'1069','lottery_id'=>'105','lottery_code'=>'YFKS','name'=>'444','cate_id'=>'1033','cate_name'=>'三军','sort'=>'99','odds'=>'162.28','create_time'=>$date,'status'=>'1','update_time' => $date]);
        $this->insert('{{%lottery_odds}}',['id'=>'1070','lottery_id'=>'105','lottery_code'=>'YFKS','name'=>'555','cate_id'=>'1033','cate_name'=>'三军','sort'=>'99','odds'=>'162.28','create_time'=>$date,'status'=>'1','update_time' => $date]);
        $this->insert('{{%lottery_odds}}',['id'=>'1071','lottery_id'=>'105','lottery_code'=>'YFKS','name'=>'666','cate_id'=>'1033','cate_name'=>'三军','sort'=>'99','odds'=>'162.28','create_time'=>$date,'status'=>'1','update_time' => $date]);
        
        
    }

    public function down()
    {
        echo "m201106_065043_lottery_add_data cannot be reverted.\n";
        $this->dropTable('{{%lottery_odds}}');
        return false;
    }
}
