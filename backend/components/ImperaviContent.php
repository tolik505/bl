<?php
namespace backend\components;


use vova07\imperavi\Widget;
use yii\helpers\Url;

class ImperaviContent extends Widget {

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        $customSettings = ['minHeight' => 150];
        $settings = array_merge($this->getDefaultSettings(), $customSettings);

        $this->settings = $settings;
    }

    public function getDefaultSettings()
    {
        return [
            //'lang' => 'ru',
            'buttons' => ['html', 'formatting', 'bold', 'italic', 'underline', 'unorderedlist',
                'orderedlist', 'image', 'file', 'link', 'alignment', 'horizontalrule'],
            'pastePlainText' => true,
            'buttonSource' => true,
            'replaceDivs' => false,
            'paragraphize' => true,
            'imageManagerJson' => Url::to(['/imagesUpload/default/images-get']),
            'imageUpload' => Url::to(['/imagesUpload/default/image-upload']),
            'plugins' => [
                'table',
                'clips',
                'imagemanager',
                'fullscreen',
            ]
        ];
    }
}
