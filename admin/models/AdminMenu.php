<?php
namespace admin\models;

use common\helpers\ArrayHelper;
use Yii;
use yii\data\Pagination;
class AdminMenu extends Base
{
    public $field_title = [
    
        'type' => ['0' => '目录', '1' => '权限菜单'],
    
        'status' => ['0' => '无效', '1' => '有效'],
    
    ];
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'admin_menu';
    }
    
    public function getMenu()
    {
        $items = self::find()->orderBy('sort asc')->asArray()->all();
        
        $data = [];
        foreach ($items as $item){
            $pid = $item['pid'];
            $id  = $item['id'];
            if($pid == 0){
                $data[$id] = $item; 
            }else{
                $data[$pid]['child'][] = $item;
            }
            
        }
       return $data;   
    }
    
    public function getMenuTree()
    {
        $data = self::find()->asArray()->all();
        $data = $this->loop_data(0, $data);
        return $data;
    }
    
    public function loop_data($parent_id = 0, $data)
    {
        $array = [];
        $new_array = []; 
        $count = count($data);
        for ($i = 0; $i < $count; $i++) {
            if ($data[$i]['pid'] == $parent_id) {
                $new_array = $data[$i];   
                $new_array['child'] = $this->loop_data($data[$i]['id'], $data);   
                if (empty($new_array['child']))
                    unset($new_array['child']);   
                //$key = 'id'.$data[$i]['menu_id'];
                $key = $data[$i]['id'];
                $array[$key] = $new_array;
            }    
        }
        return $array;    
    }
    

    public function getMenuSelect()
    {
        $data = self::find()->where(['type' => '0'])->orderBy('level')->asArray()->all();
        $data = $this->loop_data(0, $data); 
        $select = [
            '0' => '顶级菜单'
        ];
        if ($data) {
            foreach ($data as $v) {
                $select[$v['id']] = $v['title'];
                if (array_key_exists('child',$v)) {    
                    foreach ($v['child'] as $vv) {
                        $select[$vv['id']] = '&nbsp;├' . $vv['title'];
                        if ($vv['child']) {
                            foreach ($vv['child'] as $vvv) {
                                $select[$vvv['id']] = '&nbsp;&nbsp;├' . $vvv['title'];
                            }
                        }
                    }
                }
            }
        }
        return $select;
    }
    
    public function checkExist($url)
    {
        $row = self::find()->where(['url' => $url])->one();
        return $row ? true : false;
    }


    /**
     * 获取菜单的树状结构
     * @return array
     * @author mike
     * @date 2020-12-16
     */
    public static function getAllMenuTree()
    {
        $list = self::find()
            ->select("id,title,pid,url")
            ->asArray()
            ->all();
        return ArrayHelper::list_to_tree($list);
    }
}
