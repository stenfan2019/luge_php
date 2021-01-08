<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "live_s_category".
 *
 * @property string $id 分类ID
 * @property string $pid 上级分类ID
 * @property string $name 标记
 * @property string $title 标题
 * @property string $link 外链
 * @property string $extend 扩展
 * @property string $description 描述
 * @property int $sort 排序（同级有效）
 * @property int $status 是否删除 0为删除，1反之
 * @property string $create_time 创建时间
 * @property string $update_time 更新时间
 */
class Category extends Base
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'live_s_category';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['pid', 'sort', 'status'], 'integer'],
            [['name', 'title'], 'required'],
            [['extend'], 'string'],
            [['create_time', 'update_time'], 'safe'],
            [['name'], 'string', 'max' => 30],
            [['title'], 'string', 'max' => 50],
            [['link'], 'string', 'max' => 250],
            [['description'], 'string', 'max' => 255],
            [['name'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => '分类ID',
            'pid' => '上级分类ID',
            'name' => '标记',
            'title' => '标题',
            'link' => '外链',
            'extend' => '扩展',
            'description' => '描述',
            'sort' => '排序（同级有效）',
            'status' => '是否删除 0为删除，1反之',
            'create_time' => '创建时间',
            'update_time' => '更新时间',
        ];
    }
}
