<?php

namespace app\controllers;

use Yii;

class UeditorController extends \crazydb\ueditor\UEditorController
{
    public function init() {
        //$this->webroot = Yii::getAlias('@uploadPath');
        $this->config = [
            'imagePathFormat' => '/uploads/image/{yyyy}{mm}{dd}/{time}{rand:6}',
            'scrawlPathFormat' => '/uploads/image/{yyyy}{mm}{dd}/{time}{rand:6}',
            'snapscreenPathFormat' => '/uploads/image/{yyyy}{mm}{dd}/{time}{rand:6}',
            'catcherPathFormat' => '/uploads/image/{yyyy}{mm}{dd}/{time}{rand:6}',
            "catcherUrlPrefix" => Yii::getAlias('@uploadUrl'),
            'videoPathFormat' => '/uploads/video/{yyyy}{mm}{dd}/{time}{rand:6}',
            'filePathFormat' => '/uploads/file/{yyyy}{mm}{dd}/{rand:4}_{filename}',
            'imageManagerListPath' => '/uploads/image/',
            'fileManagerListPath' => '/uploads/file/',
        ];
        parent::init();
    }

    /**
     * 获取远程图片
     */
    public function actionCatchImage()
    {
        /* 上传配置 */
        $config = [
            'pathFormat' => $this->config['catcherPathFormat'],
            'maxSize' => $this->config['catcherMaxSize'],
            'allowFiles' => $this->config['catcherAllowFiles'],
            'oriName' => 'remote.png'
        ];
        $fieldName = $this->config['catcherFieldName'];
        /* 抓取远程图片 */
        $list = [];
        if (isset($_POST[$fieldName])) {
            $source = $_POST[$fieldName];
        } else {
            $source = $_GET[$fieldName];
        }
        foreach ($source as $imgUrl) {
            $item = new \crazydb\ueditor\Uploader($imgUrl, $config, 'remote');
            $info = $item->getFileInfo();
            $info['thumbnail'] = $this->imageHandle($info['url']);
            $list[] = [
                'state' => $info['state'],
                'url' => $info['thumbnail'],
                'source' => $imgUrl
            ];
        }

        /* 返回抓取数据 */
        return $this->show([
            'state' => count($list) ? 'SUCCESS' : 'ERROR',
            'list' => $list
        ]);
    }
}
