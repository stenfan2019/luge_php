<?php
namespace api\models;

class NickModel
{
   
    public function getNick()
    {
        $max = count($this->data);
        $index = mt_rand(1, $max)-1;
        return $this->data[$index];
    }
    private $data = [
        '男神傲骨','叼辣条闯世界','判官','孤独的狼','帝王亡天下','儿子别坑爹','爷︷就是拽'
        ,'豪情天地','秋风追猎者','孤独的霸气','闪瞎你狗眼','征战天下','无双剑皇','屌丝主宰一切'
        ,'骚年霸称帝王','一路秒杀','龙飞冲天','冷血江湖','江山偏冷','地狱审核官','超神之战','余生继续浪'
        ,'奢华de低调','刺眼的男人','王者天下','何必将就','朕笑看各种狗','浪场汉子','限量版、帅哥','搬砖男神'
        ,'携酒天涯','拽↘爷霸气↗','挑战狂傲','风云丿灬潮男','风苍溪','帅到天理不容','时间秒杀一切','爷′『狠潇洒'
        ,'爺丶毁天下','胸毛凌空','义海豪情','骚年永世猖狂','创造辉煌','恶魔由我主宰','孤者傲凡','恨天魔君'
        ,'叫声爷爷在此','笑叹一世浮沉','此乃特长','绝版主宰°','笑歎浮生若夢','我、独一无二'
        ,'帅的好烦躁','天生的王者','混世魔王','战火风云','风吻一斩','传说中的嗜神','此生一霸王'
        ,'主宰-死神','霸道恶魔','ｖip↗、爺','快来扶我','快来救我','快来拉我','快来摸我','移动一级包'
        ,'移动二级包','移动三级包','移动四级包','戒你','青冢','素衣','又怨','安诺','惊世','紫烨'
        ,'书生','陪笑','邶谌','陌萧','一镜','','叙年','扶苏','怪谁'
    ];
  
}



