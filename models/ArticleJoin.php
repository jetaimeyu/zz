<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%article_join}}".
 *
 * @property string $id
 * @property string $article_id 文章id
 * @property string $related_id 相关文章id
 */
class ArticleJoin extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%article_join}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['article_id', 'related_id'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'article_id' => 'Article ID',
            'related_id' => 'Related ID',
        ];
    }

    /**
     * 添加一条关联
     * @param $article_id
     * @param $related_id
     * @return bool
     */
    public static function addOne($article_id, $related_id)
    {
        $joinModel = ArticleJoin::find()
            ->andWhere(['or', ['article_id' => $article_id, 'related_id' => $related_id], ['article_id' => $related_id, 'related_id' => $article_id]])
            ->one();
        if($joinModel) {
            return false;
        }
        $model = new self();
        $model->article_id = $article_id;
        $model->related_id = $related_id;
        $model->save();
    }

    /**
     * 通过id 获取关联的文章id
     * @param $article_id
     * @return array|string
     */
    public static function getIds($article_id)
    {
        $array = [];
        $joinModel = ArticleJoin::find()
            ->andWhere(['or', ['article_id' => $article_id], ['related_id' => $article_id]])->all();
        if(!$joinModel) return '';
        foreach ($joinModel as $k => $v) {
            if($v['article_id'] == $article_id) {
                $array[] = $v['related_id'];
            } else {
                $array[] = $v['article_id'];
            }
        }
        return $array;

    }
}
