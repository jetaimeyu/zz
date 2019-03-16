<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%articles}}".
 *
 * @property string $id
 * @property string $company_id 企业id
 * @property string $category_id 种类
 * @property string $name 名称
 * @property string $image 图片
 * @property string $description 描述
 * @property string $content 详情
 * @property string $is_new 最新文章
 * @property string $view_count 浏览量
 * @property int $is_show 是否展示
 * @property string $sort 排序
 * @property string $create_time
 * @property string $update_time
 */
class Articles extends \yii\db\ActiveRecord
{
    public $imageUpload;
    /**
     * 图片允许缩略的大小
     */
    const THUMB_SIZE_SMALL = '100X63';
    const THUMB_SIZE_MIDDLE = '300X187';
    const THUMB_SIZE_BIG = 'W550';
    public static $allowThumbSize = array(self::THUMB_SIZE_SMALL, self::THUMB_SIZE_MIDDLE, self::THUMB_SIZE_BIG);


    /**
     * 显示状态
     */
    public static $showStates = [
        STATE_NO => '隐藏',
        STATE_YES => '显示'
    ];

    const PRODUCT_CENTER = 1;
    const COMPANY_NEWS = 2;
    const PUSH_PRODUCT = 3;
    public static $category = [
        self::PRODUCT_CENTER => '产品中心',
        self::COMPANY_NEWS => '公司新闻',
        self::PUSH_PRODUCT => '推荐产品',
    ];


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%articles}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['company_id', 'category_id', 'is_new', 'view_count', 'is_show', 'sort', 'create_time', 'update_time'], 'integer'],
            [['content'], 'string'],
            [['name', 'image'], 'string', 'max' => 255],
            [['description'], 'string', 'max' => 1024],
            [['imageUpload'], 'image', 'extensions' => 'png, jpg, jpeg', 'minWidth' => 200, 'maxWidth' => 1000, 'minHeight' => 200, 'maxHeight' => 1000, 'maxSize' => 1024 * 1024],
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
            'category_id' => '种类',
            'name' => '名称',
            'image' => '图片',
            'imageUpload' => '头像',
            'description' => '描述',
            'content' => '详情',
            'is_new' => '最新文章',
            'view_count' => '浏览量',
            'is_show' => '是否展示',
            'sort' => '排序',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
        ];
    }

    public function beforeSave($insert)
    {
        if($insert) {
            $this->create_time = time();
        }
        $this->update_time = time();
        return true;
    }

    public function afterDelete()
    {
        foreach ($this->images as $img) {
            $img->delete();
        }
        ArticleJoin::deleteAll([ 'or', 'article_id = :article_id', 'related_id = :related_id'],[ ':article_id' => $this->id, ':related_id' => $this->id]);
        return true;
    }

    public function getImages()
    {
        return $this->hasMany(ArticleImage::className(), ['article_id' => 'id'])->orderBy('id');
    }

    public function getMiddleImageUrl()
    {
        return $this->getImageUrlBySize(self::THUMB_SIZE_MIDDLE);
    }

    public function getImageUrlBySize($size = '100X63')
    {
        if(Company::isRemoteImage($this->image)) {
            return $this->image;
        }
        if(!$this->image) {
            return Yii::getAlias('@resUrl/images/nopic.jpg');
        }

        if (!in_array($size, self::$allowThumbSize)) {
            $size = self::$allowThumbSize[0];
        }
        $extension = '.' . pathinfo($this->image, PATHINFO_EXTENSION);
        return Yii::getAlias('@uploadUrl/uploads/'  . rtrim($this->image, $extension) . '!' . $size . $extension);
    }

    public function getImageUrl()
    {
        if(!$this->image) {
            return Yii::getAlias('@resUrl/images/nopic.jpg');
        }
        return Yii::getAlias('@uploadUrl/uploads/' . $this->image);
    }

    public function getIsShowText()
    {
        return self::$showStates[$this->is_show];
    }

    public function getCategoryName()
    {
        if (!$this->category_id) {
            return '';
        }
        return ArticleCategory::getNameById($this->category_id);
    }

    public function getImageArray()
    {
        return ArticleImage::getImagesByArticleId($this->id);
    }

    /**
     * 通过分类获取列表
     * @param $category
     * @return array
     */
    public static function getListByCategory($category)
    {
        $array = [];
        $row = self::find()->andWhere(['company_id' => Yii::$app->params['companyId'], 'category_id' => intval($category)])
            ->orderBy('sort desc')->all();
        if(!count($row)) return $array;
        foreach ($row as $k => $v){
            $array[$v['id']]['name'] = $v['name'];
            $array[$v['id']]['time'] = $v['create_time'];
            $array[$v['id']]['image'] = $v->imageUrl;
        }
        return $array;
    }

    /**
     * 获取最新文章
     */
    public static function getNewList()
    {
        $array = [];
        $row = self::find()->andWhere(['company_id' => Yii::$app->params['companyId']])->orderBy('create_time desc')->limit(10)->all();
        if(!count($row)) return $array;
        foreach ($row as $k => $v){
            $array[$v['id']]['name'] = $v['name'];
            $array[$v['id']]['time'] = $v['create_time'];
            $array[$v['id']]['image'] = $v->imageUrl;
        }
        return $array;
    }

    /**
     * 通过id 获取上一篇与下一篇文章
     * @param $id
     * @return array
     */
    public static function getLastAndNextOneById($id)
    {
        $array = [];
        $lastArticle = self::find()->andWhere(['company_id' => Yii::$app->params['companyId'], 'is_show' => STATE_YES])
            ->andWhere(['<', 'id', $id])->orderBy('id desc')->one();
        $nextArticle = self::find()->andWhere(['company_id' => Yii::$app->params['companyId'], 'is_show' => STATE_YES])
            ->andWhere(['>', 'id', $id])->orderBy('id asc')->one();
        if($lastArticle) {
            $array['last']['id'] = $lastArticle->id;
            $array['last']['name'] = $lastArticle->name;
        } else {
            $array['last'] = [];
        }
        if($nextArticle) {
            $array['next']['id'] = $nextArticle->id;
            $array['next']['name'] = $nextArticle->name;
        } else {
            $array['next'] = [];
        }
        return $array;
    }

    /**
     * 获取列表
     * @return array
     */
    public static function getList($id=0)
    {
        $array = [];
        $row = self::find()->andWhere(['company_id' => Yii::$app->params['companyId']])->all();
        if(!$row) {
            return [];
        }
        foreach ($row as $k => $v){
            if($id != $v['id']) {
                $array[$v['id']] = $v['name'];
            }
        }
        return $array;
    }
    /**
     * 获取info
     * @return array
     */
    public static function getNameById($id)
    {
        $row = self::find()->andWhere(['company_id' => Yii::$app->params['companyId'], 'id' => $id])->one();
        if(!$row) {
            return '';
        }
        return $row->name;
    }

    /**
     * 获取文章首图url地址
     * @return 文章首图的url地址
     */
    public function getPortraitUrl()
    {
        return self::getAvatarUrlById($this->id);
    }

    /**
     * 获取文章首图存放路径
     * @return 文章首图的存放路径
     */
    public static function getAvatarPathById($companyId)
    {
        $path = $companyId . '/article/' . date('Ym/d/His') . rand(100,999) . image_type_to_extension(IMAGETYPE_JPEG);
        return $path;
    }

    /**
     * 通过用户ID获取文章首图url地址
     */
    public static function getAvatarUrlById($companyId)
    {
        $path = self::getAvatarPathById($companyId);
        return Yii::getAlias('@uploadUrl/' . $path) . (YII_ENV_PROD ? '!portrait' : '');
    }
}
