<?php

namespace common\models;

use Yii;

class Base extends \yii\db\ActiveRecord
{
    static $field_title = [
        'sex' => ['0' => '男', '1' => '女'],
        'status' => ['0' => '无效', '1' => '有效'],
    ];
    /**
     * 状态字段
     */
    const FIELDS_STATUS = 'status';

    /**
     * 删除的数据
     */
    const DATA_DELETE = 0;
    /**
     * 存在的数据
     */
    const DATA_ACTIVE = 1;

    /**
     * 分页数
     */
    const PAGE_SIZE  = 10;


    /**
     * 根据ID获取表中数据
     * @param int $id
     * @param string $field
     * @return array|mixed|string|\yii\db\ActiveRecord|null
     * @author mike
     * @date 2020-07-29
     */

    public static function getIdtoInfo(int $id,$field = '')
    {
        $list = self::find()->where(['id'=>$id])->one();
        if(!$list) //查找对象不存在
            return '';
        if(!$field) // 参数没有传递
            return $list;
        if(!$list->$field) //字段不存在
            return '';
        return $list->$field;

    }


    /**
     * @name 重写find方法 查找状态数据
     * @return \yii\db\ActiveQuery
     * @author mike
     * @date 2020-08-09
     */
    /*public static function find(){

        return parent::find()->where(self::FIELDS_STATUS .'='. self::DATA_ACTIVE);
    }*/


    protected function _apiPage($models,$pagination,$page_size,$page)
    {
        $data['list'] = $models;
        $count = $pagination->totalCount;
        $data['page']['total'] = $count;
        $data['page']['pageSize'] = $page_size;
        $data['page']['page'] = $page+1;
        $data['page']['pageTotal'] = ceil($count / $page_size);
        return $data;
    }
    
    static function fetchTitle($data, $field_title, $level = 1)
    {
        $field_title = array_merge(self::$field_title, $field_title);
        $list = [];
        if ($data) {
            foreach ($data as $k => $v) {
                if ($level == '1') {
                    $list[$k] = $v;
                    if (isset($field_title[$k])) {
                        $list[$k . '_title'] = $field_title[$k][$v];
                    }
                } else {
                    $list2 = [];
                    foreach ($v as $kk => $vv) {
                        $list2[$kk] = $vv;
                        if (isset($field_title[$kk])) {
                            if(isset($field_title[$kk][$vv])){
                                $list2[$kk . '_title'] = $field_title[$kk][$vv];
                            }
                        }
                    }
                    $list[$k] = $list2;
                }
    
            }
    
        }
        return $list;
    
    }



}
