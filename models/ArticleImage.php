<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%article_image}}".
 *
 * @property string $id
 * @property string $article_id 产品id
 * @property string $image 图片地址
 * @property string $sort 排序值
 * @property string $desc 描述
 * @property string $create_time 添加时间
 */
class ArticleImage extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%article_image}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['article_id', 'sort', 'create_time'], 'integer'],
            [['image', 'desc'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'article_id' => '文章id',
            'image' => '图片地址',
            'sort' => '排序值',
            'desc' => '描述',
            'create_time' => 'Create Time',
        ];
    }

    public function afterDelete()
    {
        @unlink(Yii::getAlias('@uploadPath/' . $this->image));
        $extension = '.' . pathinfo($this->image, PATHINFO_EXTENSION);
        foreach (Articles::$allowThumbSize as $size) {
            @unlink(Yii::getAlias('@uploadPath' . '/' . rtrim($this->image, $extension) . '!' . $size . $extension));
        }

        return true;
    }

    /**
     * 获取图片url
     * @return bool|string
     */
    public function getImageUrl()
    {
        if(!$this->image) {
            return Yii::getAlias('@resUrl/images/nopic.jpg');
        }
        if(Company::isRemoteImage($this->image)) {
            return $this->image;
        }
        return Yii::getAlias('@uploadUrl/uploads/' . $this->image);
    }

    /**
     * 通过文章id 获取文章id下所有图片
     * @param $articleId
     * @return array
     */
    public static function getImagesByArticleId($articleId)
    {
        $rowset = self::find()->where(['article_id'=>$articleId])->orderBy('sort desc, id asc')->all();
        if(!$rowset) {
            return [];
        }
        $array = [];
        foreach($rowset as $row) {
            $array[] = $row->getImageUrl();
        }
        return $array;
    }

    /**
     * 保存图片
     * @param string | array $imageIds
     * @param integer $articleId
     * @return int
     */
    public static function saveImageById($imageIds, $articleId)
    {
        if(!is_array($imageIds)) {
            $imageIds = explode(',', $imageIds);
        }
        $rowset = self::find()->where(['article_id'=>$articleId])->all();
        foreach($rowset as $row) {
            if(!in_array($row->id, $imageIds)) {
                $row->delete();
            }
        }
        return self::updateAll(['article_id'=>$articleId], ['in', 'id', $imageIds]);
    }

    public static function getImageById($imageId)
    {
        $self = self::findOne($imageId);
        if($self) {
            return $self->image;
        }
        return '';
    }
}
