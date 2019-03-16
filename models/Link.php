<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%link}}".
 *
 * @property string $id
 * @property string $company_id
 * @property string $name
 * @property string $url
 * @property string $sort
 * @property string $create_time
 */
class Link extends \yii\db\ActiveRecord
{
    public static $cacheNameKey = 'linkName';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%link}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['company_id', 'sort', 'create_time'], 'integer'],
            [['name', 'url'], 'string', 'max' => 255],
            [['name', 'url'], 'required'],
            [['url'], 'url', 'defaultScheme' => 'http'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'company_id' => 'Company ID',
            'name' => '名称',
            'url' => 'Url',
            'sort' => '排序',
            'create_time' => 'Create Time',
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
    public static function getArrayForCompany()
    {
        $array = [];
        $rowset = self::find()->where(['company_id'=>Yii::$app->params['companyId']])->all();
        foreach($rowset as $row) {
            $array[$row->id]['name'] = $row->name;
            $array[$row->id]['url'] = $row->url;
        }
        return $array;
    }

    /**
     * 通过id获取info
     * @param integer $id
     * @return string
     */
    public static function getInfoById($id)
    {
        $cache = Yii::$app->cache;
        $result = $cache->get(self::$cacheNameKey . $id);
        if($result) {
            return $result;
        }

        $row = self::findOne($id);
        if($row) {
            $array = [
                'name' => $row->name,
                'url' => $row->url,
            ];
            $cache->set(self::$cacheNameKey . $id, $array);
            return $array;
        }
        return '';
    }

    /**
     * 通过id获取name
     * @param $id
     * @return string
     */
    public static function getNameById($id)
    {
        $result = self::getInfoById($id);
        if($result) {
            return $result['name'];
        }
        return '';
    }

    /**
     * 通过id获取url
     * @param $id
     * @return string
     */
    public static function getUrlById($id)
    {
        $result = self::getInfoById($id);
        if($result) {
            return $result['url'];
        }
        return '';
    }

}
