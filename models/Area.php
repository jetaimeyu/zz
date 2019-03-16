<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%area}}".
 *
 * @property string $id
 * @property string $region_code 编号
 * @property string $region_name 名称
 * @property string $parent_id 上级id
 * @property string $region_name_en 拼音全拼
 * @property string $region_shortname_en 首字母
 * @property int $level
 */
class Area extends \yii\db\ActiveRecord
{
    public static $cacheNameKey = 'areaName';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%area}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['parent_id', 'level'], 'integer'],
            [['region_code', 'region_name', 'region_name_en', 'region_shortname_en'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'region_code' => 'Region Code',
            'region_name' => 'Region Name',
            'parent_id' => 'Parent ID',
            'region_name_en' => 'Region Name En',
            'region_shortname_en' => 'Region Shortname En',
            'level' => 'Level',
        ];
    }

    public function afterSave($insert, $changedAttributes)
    {
        Yii::$app->cache->delete(self::$cacheNameKey . $this->id);
        return true;
    }

    public function afterDelete()
    {
        Yii::$app->cache->delete(self::$cacheNameKey . $this->id);
        return true;
    }

    /**
     * 获取列表
     */
    public static function getArrayForInput($parentId)
    {
        $array = [];
        $rowset = self::find()->where(['parent_id'=>$parentId])->all();
        foreach($rowset as $row) {
            $array[$row->id] = $row->region_name;
        }
        return $array;
    }

    /**
     * 通过id获取地区名称
     * @param integer $id
     * @return string
     */
    public static function getNameById($id)
    {
        $cache = Yii::$app->cache;
        $result = $cache->get(self::$cacheNameKey . $id);
        if($result) {
            return $result;
        }

        $row = self::findOne($id);
        if($row) {
            $cache->set(self::$cacheNameKey . $id, $row->region_name);
            return $row->region_name;
        }
        return '';
    }
}
