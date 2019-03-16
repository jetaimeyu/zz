<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%article_category}}".
 *
 * @property string $id
 * @property string $company_id 企业id
 * @property string $name 分类名称
 * @property int $sort 排序
 */
class ArticleCategory extends \yii\db\ActiveRecord
{

    public static $cacheNameKey = 'articleCategory';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%article_category}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['company_id', 'sort'], 'integer'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'company_id' => '企业id',
            'name' => '分类名称',
            'sort' => '排序',
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
        Articles::updateAll(['category_id'=>0], ['category_id'=>$this->id]);
        return true;
    }

    /**
     * 通过id获取名称
     * @param $id
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
            $cache->set(self::$cacheNameKey . $id, $row->name);
            return $row->name;
        }
        return '';
    }

    /**
     * 获取列表
     */
    public static function getArrayForInput()
    {
        $array = [];
        $rowset = self::find()->orderBy('sort desc')->all();
        if($rowset) {
            foreach ($rowset as $self) {
                $array[$self->id] = $self->name;
            }
        }
        return $array;
    }

    public static function getArrayByCompanyForInput($companyId)
    {
        $array = [];
        $rowset = self::find()->where(['company_id' => $companyId])->orderBy('sort desc')->all();
        if($rowset) {
            foreach ($rowset as $self) {
                $array[$self->id] = $self->name;
            }
        }
        return $array;
    }
}
