<?php

namespace app\models;

use Yii;
use yii\data\Pagination;

/**
 * This is the model class for table "{{%leave_message}}".
 *
 * @property string $id
 * @property string $company_id
 * @property string $name 姓名
 * @property string $email email
 * @property string $mobile 联系电话
 * @property string $title 留言标题
 * @property string $content 留言内容
 * @property string $create_time
 */
class LeaveMessage extends \yii\db\ActiveRecord
{
    public static $cacheMessage = 'message';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%leave_message}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['company_id', 'create_time'], 'integer'],
            [['name', 'email', 'content', 'title'], 'string', 'max' => 255],
            [['mobile'], 'string', 'max' => 11],
            [['email'], 'email'],
            [['mobile', 'title'], 'required',],
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
            'name' => '姓名',
            'email' => 'Email',
            'mobile' => '联系电话',
            'title' => '留言标题',
            'content' => '留言内容',
            'create_time' => 'Create Time',
        ];
    }

    public function beforeSave($insert)
    {
        if($insert) {
            $this->company_id = Yii::$app->params['companyId'];
            $this->create_time = time();
        }
        return true;
    }

    public function afterSave($insert, $changedAttributes)
    {
        $cache = Yii::$app->cache;
        $text = $this->company_id . $this->name . $this->email . $this->mobile . $this->title . $this->content;
        $cache->set(self::$cacheMessage . $this->company_id . $this->title . $this->name . $this->content, $text);
        return true;
    }

    /**
     *  获取列表
     * @param array $where 条件array
     * @param string $page 分页 显示条数
     * @param string $order 排序
     * @return array
     */
    public static function getDataList($where=[], $page='20', $order='id desc')
    {
        $data = self::find()->andWhere(['company_id' => Yii::$app->params['companyId']]);
        if ($where) {
            foreach ($where as $itemArr) {
                foreach ($itemArr as $index => $item) {
                    $data->andWhere($item);
                }
            }
        }
        if($page) {
            $pages = new Pagination(['totalCount' => $data->count(), 'pageSize' => $page]);
            $model = $data->offset($pages->offset)->limit($pages->limit)->orderBy($order)->all();
            return ['data' => $model, 'pages' => $pages];
        } else {
            $model = $data->all();
            return ['data' => $model];
        }
    }
}
