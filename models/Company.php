<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%company}}".
 *
 * @property string $id
 * @property string $account 帐号
 * @property string $name 企业名称
 * @property string $password 登陆密码
 * @property string $image 企业的首页大图
 * @property string $slogan 提供服务
 * @property string $description 企业描述
 * @property string $describe_image 我的首图
 * @property string $contact 企业联系人
 * @property string $mobile 企业联系电话
 * @property string $email 企业邮箱
 * @property string $weixin 企业微信号
 * @property string $qq 企业QQ号
 * @property string $tag 标签,行业等
 * @property string $province_id 省
 * @property string $city_id 市
 * @property string $district_id 区
 * @property string $address 地址
 * @property int $state 状态：0禁用，1启用
 * @property string $login_count 登陆次数
 * @property string $service_time 服务到期时间
 * @property string $create_time
 * @property string $last_login_time
 * @property string $last_login_ip
 */
class Company extends \yii\db\ActiveRecord
{
    public $imageUpload;
    public $describeImageUpload;

    public static $cacheIndexImage = 'indexImage';
    public static $cacheCompanyInfo = 'companyInfo';

    /**
     * 状态
     * @var array
     */
    public static $status = [
        STATE_NO => '禁用',
        STATE_YES => '启用',
    ];

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%company}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['description'], 'string'],
            [['province_id', 'city_id', 'district_id', 'state', 'login_count', 'service_time', 'create_time', 'last_login_time'], 'integer'],
            [['account', 'name', 'password', 'image', 'describe_image', 'slogan', 'contact', 'mobile', 'email', 'weixin', 'qq', 'tag', 'address'], 'string', 'max' => 255],
            [['last_login_ip'], 'string', 'max' => 15],
            [['email'], 'email'],
            [['imageUpload'], 'image', 'extensions' => ['png', 'jpg', 'jpeg'], 'minWidth' => 60, 'maxWidth' => 1024, 'minHeight' => 60, 'maxHeight' => 1024, 'maxSize' => 3 * 1024 * 1024],
            [['describeImageUpload'], 'image', 'extensions' => ['png', 'jpg', 'jpeg'], 'minWidth' => 60, 'maxWidth' => 1024, 'minHeight' => 60, 'maxHeight' => 1024, 'maxSize' => 3 * 1024 * 1024],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'account' => '帐号',
            'name' => '企业名称',
            'password' => '登陆密码',
            'image' => '企业的首页大图',
            'slogan' => '提供服务',
            'description' => '企业描述',
            'describe_image' => '企业简介图片',
            'contact' => '企业联系人',
            'mobile' => '企业联系电话',
            'email' => '企业邮箱',
            'weixin' => '企业微信号',
            'qq' => '企业QQ号',
            'tag' => '标签,行业等',
            'province_id' => '省',
            'city_id' => '市',
            'district_id' => '区',
            'address' => '地址',
            'state' => '状态',
            'login_count' => '登陆次数',
            'service_time' => '服务到期时间',
            'create_time' => '创建时间',
            'last_login_ip' => '最后登陆IP',
            'last_login_time' => '最后登陆时间',
            'imageUpload' => '上传首图',
            'describeImageUpload' => '上传企业简介图片',
        ];
    }

    public function getAddressText()
    {
        $address = '';
        if($this->province_id) {
            $address .= Area::getNameById($this->province_id);
        }
        if($this->city_id) {
            $address .= Area::getNameById($this->city_id);
        }
        if($this->district_id) {
            $address .= Area::getNameById($this->district_id);
        }
        $address .= $this->address;
        return $address;
    }

    /**
     * 获取企业大图
     * @return bool|string
     */
    public function getImageUrl()
    {
        $cache = Yii::$app->cache;
        $result = $cache->get(self::$cacheIndexImage . 'BIG');
        if($result) {
            return $result;
        }
        if($this->image) {
            if(!file_exists(Yii::getAlias('@uploadUrl/uploadUrl' . $this->image))) {
                return Yii::getAlias('@resUrl/images/banner.jpg');
            }
            $cache->set(self::$cacheIndexImage . 'BIG', Yii::getAlias('@uploadUrl/uploads/' . $this->image));
            return Yii::getAlias('@uploadUrl/uploads/' . $this->image);
        }
        return Yii::getAlias('@resUrl/images/default_avatar.jpg');
    }

    /**
     * 获取简介图片
     * @return bool|string
     */
    public function getDescribeImageUrl()
    {
        $cache = Yii::$app->cache;
        $result = $cache->get(self::$cacheIndexImage . 'SMALL');
        if($result) {
            return $result;
        }
        if($this->describe_image) {
            if(!file_exists(Yii::getAlias('@uploadUrl/uploads/' . $this->describe_image))) {
                return Yii::getAlias('@resUrl/images/201012116381523084.jpg');
            }
            $cache->set(self::$cacheIndexImage . 'SMALL', Yii::getAlias('@uploadUrl/uploads/' . $this->describe_image));
            return Yii::getAlias('@uploadUrl/uploads/' . $this->describe_image);
        }
        return Yii::getAlias('@resUrl/images/default_avatar.jpg');
    }

    public function getArticleCount()
    {
        return Articles::find()->where(['company_id' => $this->id])->count();
    }

    /**
     * 通过id获取企业信息
     * @param $id
     * @return array|mixed|null|static
     */
    public static function getInfoById($id)
    {
        $cache = Yii::$app->cache;
        $result = $cache->get(self::$cacheCompanyInfo . $id);
        if($result) {
            return $result;
        }
        $row = self::findOne($id);
        if($row) {
            $cache->set(self::$cacheCompanyInfo . $id, $row);
            return $row;
        }
        return [];
    }

    /**
     * 删除文件
     * @param string $prefix
     * @param string | array $file
     */
    public static function deleteFile($prefix, $file)
    {
        if(is_array($file)) {
            foreach($file as $f) {
                @unlink(rtrim($prefix, '/') . '/' . $f);
            }
        } else {
            @unlink(rtrim($prefix, '/') . '/' . $file);
        }
    }

    /**
     * 判断是否为网络图片
     * @param string $image
     * @return bool
     */
    public static function isRemoteImage($image)
    {
        if(substr($image, 0, 4) == 'http' || substr($image, 0, 2) == '//') {
            return true;
        }
        return false;
    }
}
