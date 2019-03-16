<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%company_log}}".
 *
 * @property string $id
 * @property string $company_id 管理员ID
 * @property string $content 日志内容
 * @property string $create_time
 * @property string $create_ip
 */
class CompanyLog extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%company_log}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['company_id', 'create_time'], 'integer'],
            [['content'], 'string'],
            [['create_ip'], 'string', 'max' => 15],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'company_id' => 'company ID',
            'content' => 'Content',
            'create_time' => 'Create Time',
            'create_ip' => 'Create Ip',
        ];
    }

    public function beforeSave($insert)
    {
        if ($this->isNewRecord) {
            $this->create_ip = Yii::$app->request->userIP;
            $this->create_time = time();
        }
        return true;
    }

    /**
     * 添加管理日志
     * @param string $content
     * @return boolean
     */
    public static function addLog($content)
    {
        $session = Yii::$app->session;
        $log = new self();
        $log->company_id = $session['companyId'];
        $log->content = $content;
        return $log->save();
    }
}
